<template>

  <v-container fluid class="w-100">
    <v-card style="height:100%">
      <GmapMap
              v-if="Object.keys(center).length !== 0"
              :center="center"
               :zoom="zoom"
               map-type-id="terrain"
               style="width: 100%; height: 600px">
        <GmapMarker :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :clickable="true"
                    :draggable="true"
                    @click="markerClicked(m)"
                    :icon="golfIcon" />

        <gmap-info-window
           @closeclick="closeWindow()"
           :opened="windowOpen"
           :position="windowLocation"
           >
           <formatted-player :player="currentLocation" />
       </gmap-info-window>
      </GmapMap>
    </v-card>

  </v-container>

</template>

<script>

  import axios from 'axios'
  import FormattedPlayer from '$comp/admin/shared/FormattedPlayer';

  export default {
    name: 'google-map',
    components: {FormattedPlayer},
    data() {
      return {
        windowOpen: false,
        windowLocation: null,
        currentLocation: null,
        center_: {
          lat: 43.2392954,
          lng: -79.8775022
        },
        center: {},
        zoom: 16,
        savedLocations: [],
        locPlaces: [],
        existingPlace: null,
        locationDetails: {
          name: '',
          comments: ''
        },
				saving: false,

      }
    },
    props: ['markers','course'],
    mounted() {
      console.log('map course', this.course.latitude);
      this.setCenter();
      this.locateGeoLocation();

    },
    methods: {
      setCenter(){
        this.center = {
          lat: parseFloat(this.course.latitude),
          lng: parseFloat(this.course.longitude)
        };
      },
      markerClicked(m){
        console.log(m);
        this.windowOpen = true;
        this.windowLocation = m.position;
        this.currentLocation = m;

      },
      closeWindow(){
        this.windowOpen = false;
      },
      initMarker(loc) {
        this.locationDetails.name = loc.name
        this.existingPlace = loc
      },
      locateGeoLocation: function() {
        navigator.geolocation.getCurrentPosition(res => {
          this.center = {
            lat: res.coords.latitude,
            lng: res.coords.longitude
          }
        })
      },
    },
    computed: {
      golfIcon() {
        return {
          url: '/images/golf-red.png', // url
          scaledSize: new google.maps.Size(50, 50), // scaled size
          origin: new google.maps.Point(0, 0), // origin
          anchor: new google.maps.Point(0, 0) // anchor
        }
      },


    }
  }

</script>
\
