<template>

  <v-container fluid class="w-100">
    <v-card style="height:100vh;width:100%;" v-if="center.lat">
      <GmapMap v-if="Object.keys(center).length !== 0"
               :center="center"
               :zoom="zoom"
               ref="map"
               map-type-id="terrain"
               style="width: 100%; height: 80vh"
               @click="mapClicked()">
        <GmapMarker :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :clickable="true"
                    @click="markerClicked(m)"
                    :icon="golfIcon" />

        <GmapMarker @click="infoMarkerClicked('start', course.start)"
                    :position="course.start"
                    :clickable="true"
                    :icon="startIcon" />
        <GmapMarker @click="infoMarkerClicked('finish', course.finish)"
                    :position="course.finish"
                    :clickable="true"
                    :icon="finishIcon" />

        <GmapMarker @click="infoMarkerClicked('current', currentLocation)"
                    :position="currentLocation"
                    :clickable="true"
                    :icon="youIcon" />

        <gmap-info-window :opened="infoWindowOpen" :position="infoWindowLocation">
          <div v-html="infoWindowText"></div>
        </gmap-info-window>

      </GmapMap>

      <div class="w-100 d-flex flex-column mx-4 my-4" justify-center align-center>
        <v-btn v-if="!locationStatus" @click="verifyLocation()" :loading="verifying" color="success" class="mr-2" elevation="3">
          <v-icon left>mdi-map-marker</v-icon> Verify My Location
        </v-btn>

        <v-btn v-else :color="statusColor()" @click="showDrawer=!showDrawer">
          <v-icon left>mdi-menu-up-outline</v-icon> {{ statusName() }}
        </v-btn>
      </div>

    </v-card>

    <div class="glow floater">
          <v-btn
            elevation="2"
            color="info"
            fab
            @click="showDrawer=!showDrawer"
          ><v-icon>mdi-clock</v-icon></v-btn>
    </div>

    <Drawer :drawer="showDrawer" @update="updateDrawer" v-show="showDrawer" :loading="verifying">
      <div>
        <v-chip color="dark" class="my-3">
          <h2>00:00:00</h2>
        </v-chip>
      </div>

      <v-progress-linear v-if="verifying" indeterminate
                         color="teal"></v-progress-linear>

      <v-card elevation="7" v-else class="py-4 px-4">
        <div class="py-2 my-1">
          <v-btn @click="verifyLocation()" color="success">
            <v-icon left>mdi-map-marker</v-icon>
            {{ !locationStatus ? 'Detect Location' : 'Try Again' }}
          </v-btn>
          <br/>
          <v-alert text dense outlined :color="statusColor()" v-html="statusMessage" class="py-2 px-2 my-2 mx-2">
          </v-alert>

          <small>GO TO:</small>
          <BottomNav @panTo="panTo" :course="course" :me="currentLocation"/>
          <!--<v-btn :href="'https://maps.google.com/?q='+course.start.lat + ',' + course.start.lng" target="_BLANK">
            SHOW STARTING POINT <v-icon right>mdi-open-in-new</v-icon>
          </v-btn>-->

        </div>

        <div class="py-0 text-muted" v-if="locationStatus">
          <small>
                Coords: {{ currentLocation.lat}}, {{ currentLocation.lng }} &#8226;
                  {{ distanceToStart }} M from Start &#8226;
                  {{ distanceToFinish }} M to Finishline ({{ locationStatus }})
              </small>
        </div>

      </v-card>

    </Drawer>


  </v-container>

</template>

<script>

  import axios from 'axios'
  import BottomNav from '$comp/public/map/ui/BottomNav'
  import FormattedPlayer from '$comp/admin/shared/FormattedPlayer'
  import { gmapApi } from 'vue2-google-maps'
  import api from '~/api'
  import getStatus from '~/mixins/getStatus'
  import geo from '~/mixins/geo'
  import Drawer from './ui/Drawer'

  export default {
    name: 'google-map',
    components: { FormattedPlayer, Drawer, BottomNav },
    mixins: [getStatus, geo],
    data() {
      return {
        saveOptionsVisible: false,
        showDrawer: false,
        verifying: false,
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
        locationStatus: 0,
        originalLocation: {},
        locationDetails: {
          name: '',
          comments: ''
        },
        saving: false,
        icons: []
      }
    },
    props: ['markers', 'course'],
    async mounted() {
      this.setCenter()
    },
    async created() {
      this.$gmapApiPromiseLazy().then(async map => {
        console.log('map has loaded!')
        //await this.getCurrentLocation();
        //this.liveLocation();
      })
    },
    methods: {
      updateDrawer(v) {
        this.showDrawer = v
      },
      openMapTab(){
        //
      },
      async verifyLocation() {
        this.verifying = true
        this.showDrawer = true
        const loc = await this.getCurrentLocation()

        if ('lat' in loc) {
          this.currentLocation = loc
          this.locationStatus = this.distanceToStart < 8 ? 1 : 2
          this.panTo(this.currentLocation);
        }
        this.verifying = false
        //this.liveLocation();
      },
      panTo(coords = null) {
        this.showDrawer = false;
        coords = coords ? coords : this.center
        this.$refs.map.$mapPromise.then(map => {
          map.panTo(coords)
        })
      },
      goToNextPlayer() {
        console.log('selefcted: ', this.activeMarkers[this.selectedPlayerIndex].name)
        this.panTo(this.activeMarkers[this.selectedPlayerIndex].position)
        this.selectedPlayerIndex =
          this.selectedPlayerIndex >= this.activeMarkers.length - 1 ? 0 : this.selectedPlayerIndex + 1
      },
      updateCenter(e) {
        //only do on first drag
        if (!this.saveOptionsVisible) {
          this.originalLocation = this.center
        }

        this.course.lat = e.lat()
        this.course.lng = e.lng()
        this.setCenter()
        this.saveOptionsVisible = true
      },
      cancelUpdateCenter() {
        this.saveOptionsVisible = false
        this.center = this.originalLocation
        this.course.lat = this.originalLocation.lat
        this.course.lng = this.originalLocation.lng
      },
      setCenter() {
        this.center = {
          lat: parseFloat(this.course.start.lat),
          lng: parseFloat(this.course.start.lng)
        }
        if (!this.center.lat) {
          console.log('no center!')
          //this.center = this.center_;
        }
        //console.log('setting center as', this.center);
      },
      async updateCourseCoords() {
        const course = await api.updateCourseCoords(this.course.id, this.course)
        this.$toast.success(course.message)
        this.saveOptionsVisible = false
      },
      markerClicked(m) {
        console.log(m)
        this.windowOpen = true
        this.windowLocation = m.position
        this.selectedPlayer = m
      },
      mapClicked() {
        this.windowOpen = false
        this.infoWindowOpen = false
      },
      infoMarkerClicked(type, pos = this.center) {
        let messages = {
          start: `This is beginning of the race. <br/> You must be here to start the race`,
          finish: `This is the finish line!`,
          current: `You are here now!`
        }
        this.infoWindowLocation = pos //(type == 'center') ? this.center : this.currentLocation;
        console.log('info window: ', this.infoWindowLocation)
        this.infoWindowText = messages[type]
        this.infoWindowOpen = true
      },
      closeWindow() {
        this.windowOpen = false
      },
      deletePlayer(id) {
        this.$emit('delete-player', id)
        this.closeWindow()
      },
      initMarker(loc) {
        this.locationDetails.name = loc.name
        this.existingPlace = loc
      },
      liveLocation() {
        const self = this
        this.interval = setInterval(function() {
          self.getCurrentLocation()
        }, 2000)
      },
      async getCurrentLocation() {
        return new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(
            position => resolve({ lat: position.coords.latitude, lng: position.coords.longitude }),
            error => reject(error)
          )
        })
        /*
            console.log("refreshing location...");
            await navigator.geolocation.getCurrentPosition(res => {
              this.currentLocation = {
                lat: res.coords.latitude,
                lng: res.coords.longitude
              };

            });
            this.setCenter();
            return true;
            */
      }
    },
    beforeDestroy() {
      console.log('leaving..')
      clearInterval(this.interval)
    },
    computed: {
      distanceToStart() {
        return this.geo_getDistance(this.currentLocation, this.course.start)
      },
      distanceToFinish() {
        return this.geo_getDistance(this.currentLocation, this.course.finish)
      },
      activeMarkers() {
        let app = this
        return this.markers.filter(marker => {
          return app.isActive(marker.status_id)
        })
      },
      startIcon() {
        return {
          url: '/images/start_ring.png', // url
          scaledSize: { width: 68, height: 68 }
        }
      },
      finishIcon() {
        return {
          url: '/images/greenflag.png', // url
          scaledSize: { width: 68, height: 68 }
        }
      },
      youIcon() {
        return {
          url: '/images/you.png', // url
          scaledSize: { width: 68, height: 68 }
        }
      }

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

  .smallText {
    font-size: 1em;
  }
  .footerOptions {
    bottom: 20%;
    left: 0;
    width: 100%;
    position: absolute;
    text-align: center;
    display: flex;
    justify-content: center;
    flex-direction: row;
    z-index: 99;
  }

  small {
    color: #BBB;
  }

  .floater{
    position: fixed;
    left: 24px;
    bottom: 90px;

  }

  .glow {
    background-color: #fff;
    animation: glowing 1.4s infinite alternate;
    border-radius: 50%;
  }

  @keyframes glowing {
    from {
      box-shadow:
      0 0 6px 2px #fff,
      0 0 10px 4px #00008b,
      0 0 14px 6px #0ff;
    }
    to {
      box-shadow:
      0 0 16px 5px #fff,
      0 0 10px 4px #00008b,
      0 0 14px 7px #0ff;
    }
  }

</style>
