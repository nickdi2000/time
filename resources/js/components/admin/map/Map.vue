<template>

  <v-container fluid class="w-100">
    <v-card style="height:100%;width:100%;" v-if="center.lat">
      <GmapMap
              v-if="Object.keys(center).length !== 0"
              :center="center"
               :zoom="zoom"
               ref="map"
               map-type-id="satellite"
               style="width: 100%; height: 600px"
               @click="mapClicked()"
               >
        <GmapMarker :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :clickable="true"
                    @click="markerClicked(m)"
                    :icon="golfIcon" />

          <GmapMarker @click="infoMarkerClicked('current')" :position="currentLocation" :clickable="true" :icon="cartIcon"/>
          <GmapMarker @click="infoMarkerClicked('center')"
            :draggable="true"
            @dragend="updateCenter($event.latLng)"
            :position="center"
            :clickable="true"
            :icon="courseIcon"/>

        <gmap-info-window
           @closeclick="closeWindow()"
           :opened="windowOpen"
           :position="windowLocation"
           >
           <formatted-player :player="selectedPlayer" @delete-player="deletePlayer"/>
       </gmap-info-window>

       <gmap-info-window
          :opened="infoWindowOpen"
          :position="infoWindowLocation" >
          <div v-html="infoWindowText"></div>
       </gmap-info-window>

      </GmapMap>
    </v-card>

    <v-card v-else class="py-2 px-2">
      <v-alert color="warning">
        Location is not set up for this course yet.  Please configure the address.
        <br/>

      </v-alert>
        <v-btn :to="{ name: 'course-edit' }" elevation="2" color="default">SET UP ADDRESS</v-btn>
    </v-card>


      <div v-if="saveOptionsVisible"  class="footerOptions">
            <v-btn @click="updateCourseCoords()" color="success" class="mr-2" elevation="3">Save Changes</v-btn>
            <v-btn @click="cancelUpdateCenter()" color="secondary" elevation="3">Cancel</v-btn>
      </div>

      <div v-else class="footerOptions">
        <v-btn @click="$emit('get-players')" color="success" elevation="3" class="mr-2" title="Refresh Players"><v-icon>refresh</v-icon></v-btn>
        <v-btn @click="panTo()" color="info" elevation="3" title="Go To Center of Course" class="mr-2"><v-icon>mdi-image-filter-center-focus</v-icon></v-btn>
        <v-btn @click="goToNextPlayer()" color="warning" title="Go To Next Golfer" elevation="3"><v-icon>mdi-account-arrow-right</v-icon></v-btn>
      </div>
  </v-container>

</template>

<script>

  import axios from 'axios'
  import FormattedPlayer from '$comp/admin/shared/FormattedPlayer';
  import {gmapApi} from 'vue2-google-maps'
  import api from '~/api';
  import getStatus from '~/mixins/getStatus'


  export default {
    name: 'google-map',
    components: {FormattedPlayer},
    mixins: [getStatus],
    data() {
      return {
        saveOptionsVisible: false,
        windowOpen: false,
        windowLocation: null,
        infoWindowOpen: false,
        infoWindowLocation: null,
        infoWindowText: '',
        selectedPlayer: {},
        selectedPlayerIndex: 0, //for cycling through panTo
        center_: {
          lat: 43.2392954,
          lng: -79.8775022
        },
        interval: null,
        center: {},
        zoom: 16,
        savedLocations: [],
        locPlaces: [],
        existingPlace: null,
        currentLocation: {},
        originalLocation: {},
        locationDetails: {
          name: '',
          comments: ''
        },
				saving: false,
        icons: [],
      }
    },
    props: ['markers','course'],
    async mounted() {
      console.log('map course', this.course.latitude);
    },
    async created() {
       this.$gmapApiPromiseLazy().then(async (map) => {
          console.log("map has loaded!");
          await this.getCurrentLocation();
          this.liveLocation();
       });
    },
    methods: {
      panTo(coords = null){
        coords = coords ? coords : this.center;
        this.$refs.map.$mapPromise.then((map) => {
            map.panTo(coords);
          });
      },
      goToNextPlayer(){
        console.log("selefcted: ", this.activeMarkers[this.selectedPlayerIndex].name);
        this.panTo(this.activeMarkers[this.selectedPlayerIndex].position);
        this.selectedPlayerIndex = this.selectedPlayerIndex >= this.activeMarkers.length-1 ? 0 : this.selectedPlayerIndex + 1;

      },
      updateCenter(e){
        //only do on first drag
        if(!this.saveOptionsVisible){
          this.originalLocation = this.center;
        }

        this.course.latitude = e.lat();
        this.course.longitude = e.lng();
        this.setCenter();
        this.saveOptionsVisible = true;
      },
      cancelUpdateCenter(){
        this.saveOptionsVisible = false;
        this.center = this.originalLocation;
        this.course.latitude = this.originalLocation.lat;
        this.course.longitude = this.originalLocation.lng;
      },
      setCenter(){
        this.center = {
          lat: parseFloat(this.course.latitude),
          lng: parseFloat(this.course.longitude)
        };
        if(!this.center.lat){
          console.log("no center!");
          //this.center = this.center_;
        }
        //console.log('setting center as', this.center);
      },
      async updateCourseCoords(){
        const course = await api.updateCourseCoords(this.course.id, this.course);
        this.$toast.success(course.message);
        this.saveOptionsVisible = false;
      },
      markerClicked(m){
        console.log(m);
        this.windowOpen = true;
        this.windowLocation = m.position;
        this.selectedPlayer = m;

      },
      mapClicked(){
        this.windowOpen = false;
        this.infoWindowOpen = false;
      },
      infoMarkerClicked(type){
        let messages = {
          'center' : `This is the center anchor point to the course. <br/> Your map will initiate here by default. Drag to change.`,
          'current' : `This is your location.  Players cannot see this.`
        }
        this.infoWindowLocation = (type == 'center') ? this.center : this.currentLocation;
        console.log("info window: ", this.infoWindowLocation);
        this.infoWindowText = messages[type];
        this.infoWindowOpen = true;

      },
      closeWindow(){
        this.windowOpen = false;
      },
      deletePlayer(id){
        this.$emit('delete-player', id);
        this.closeWindow();
      },
      initMarker(loc) {
        this.locationDetails.name = loc.name
        this.existingPlace = loc
      },
      liveLocation(){
        const self = this;
        this.interval = setInterval(function(){ self.getCurrentLocation(); }, 2000);
      },
      async getCurrentLocation() {
        console.log("refreshing location...");
        await navigator.geolocation.getCurrentPosition(res => {
          this.currentLocation = {
            lat: res.coords.latitude,
            lng: res.coords.longitude
          };

        });
        this.setCenter();
        return true;
      },
    },
    beforeDestroy(){
      console.log("leaving..");
      clearInterval(this.interval);
    },
    computed: {
      activeMarkers(){
        let app = this;
        return this.markers.filter((marker) => {
          return app.isActive(marker.status_id);
        });
      },
      golfIcon() {
        return {
          url: '/images/green-marker.png', // url
          scaledSize: {width: 58, height: 58}
        }
      },
      courseIcon() {
        return {
          url: '/images/radar.png', // url
          scaledSize: {width: 38, height: 38}  }
      },
      cartIcon() {
        return {
          url: '/images/golf-caddy.png', // url
          scaledSize: {width: 38, height: 38}  }
      },

      /*myIcon() {
        return  {
          path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
          fillColor: "blue",
          fillOpacity: 0.6,
          strokeWeight: 0,
          rotation: 0,
          scale: 2,
        };
      },
      */



    }
  }

</script>
<style>
.smallText{
  font-size: 1em;
}
  .footerOptions{
    bottom: 22px;
    left: 0;
    width: 100%;
    position: fixed;
    text-align:center;
    display: flex;
    justify-content: center;
    flex-direction: row;
  }

</style>
