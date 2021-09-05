<template>
  <v-container fluid class="no-margins">
    <v-tabs v-model="tab"
            fill-height
            centered
            dark
            icons-and-text
            style="height:100%;"
            class="px-0 mx-0">
      <v-tabs-slider></v-tabs-slider>

      <v-tab href="#tab-map">
        Map
        <v-icon>mdi-map</v-icon>
      </v-tab>

      <v-tab href="#tab-list">
        List
        <v-icon>mdi-format-list-bulleted</v-icon>
      </v-tab>

    </v-tabs>

    <v-tabs-items v-model="tab" fill-height>
      <v-tab-item value="tab-map" v-if="locations">
        <v-card flat >
          <gMap
					:markers="locations"
					 @get-locations="getLocations()" />
        </v-card>
      </v-tab-item>

      <v-tab-item value="tab-list">
        <v-card flat>
          <List :locations="locations"
                @get-locations="getLocations()" />
        </v-card>
      </v-tab-item>

    </v-tabs-items>
  </v-container>

</template>

<script>

  import axios from 'axios'
  import gMap from './Map'
  import List from './List'

  export default {
    components: {
      gMap,
      List
    },
    data() {
      return {
        tab: null,
        locations: [
          {
            position: {
              lat: 43.2392954,
              lng: -79.8775022
            }
          }
        ],
      }
    },
    methods: {
      getLocations() {
        axios.get('/api/location').then(res => {
          this.locations = res.data
        })
      }
    },
    mounted() {
      //this.getLocations()
    }
  }

</script>
