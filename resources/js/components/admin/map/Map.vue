<template>

  <v-container fluid class="w-100">
    <v-card style="height:100%;width:100%;">
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
                    @click="markerClicked(m)"
                    :icon="golfIcon" />

          <GmapMarker
                    :position="currentLocation"
                    :clickable="true"
                    :icon="cartGlow"/>

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
        interval: null,
        center: {},
        zoom: 16,
        savedLocations: [],
        locPlaces: [],
        existingPlace: null,
        currentLocation: {},
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
      //this.getCurrentLocation();
      this.liveLocation();


    },
    methods: {
      setCenter(){
        this.center = {
          lat: parseFloat(this.course.latitude),
          lng: parseFloat(this.course.longitude)
        };
        console.log('setting center as', this.center);
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
      liveLocation(){
        const self = this;
        this.interval = setInterval(function(){
            self.getCurrentLocation();
            //console.log ('refresh location');
        }, 3000);
      },
      getCurrentLocation: function() {
        console.log("getCurrentLocation");
        navigator.geolocation.getCurrentPosition(res => {
          this.currentLocation = {
            lat: res.coords.latitude,
            lng: res.coords.longitude
          };

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
      cartGlow() {
        return {
          url: '/images/cart-glow.png', // url
          scaledSize: new google.maps.Size(50, 50), // scaled size
          origin: new google.maps.Point(0, 0), // origin
          anchor: new google.maps.Point(0, 0) // anchor
        }
      },
      myIcon() {
        return  {
          //path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
          path: "M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z",
          fillColor: "blue",
          fillOpacity: 0.6,
          strokeWeight: 0,
          rotation: 0,
          scale: 2,
          anchor: new google.maps.Point(15, 30),
        };
      },


    }
  }

</script>
\
