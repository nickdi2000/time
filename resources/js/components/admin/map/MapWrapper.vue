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
      <v-tab-item value="tab-map">
        <v-card flat >
          <gMap
          v-if="Object.keys(course).length !== 0"
          :course="course"
					:markers="players"
					 @get-players="getPlayers()" />

           <v-alert v-else>Loading...</v-alert>
        </v-card>
      </v-tab-item>

      <v-tab-item value="tab-list">
        <v-card flat v-if="players">
          <List :players="players"
                @get-players="getPlayers()" />
        </v-card>
      </v-tab-item>

    </v-tabs-items>
    COURSE: {{ course}}
  </v-container>

</template>

<script>

  import axios from 'axios'
  import gMap from './Map'
  import List from './List'
  import { mapGetters } from 'vuex'


  export default {
    components: {
      gMap,
      List
    },
    data() {
      return {
        tab: null,
        course: {},
        players: [
          {
            position: {
              lat: 0, //43.2392954,
              lng: 0 //-79.8775022
            }
          }
        ],
      }
    },
    methods: {
      getPlayers() {
        axios.get('/api/player/list/' + this.user.course_id).then(res => {
          this.players = res.data
        })
      },
      getCourse() {
        console.log('getting course');
        axios.get('/api/course/' + this.user.course_id)
          .then(res => {
            this.course = res.data;
            this.getPlayers();
          })
      }
    },
    computed: mapGetters({
      user: 'auth/user'
    }),

    mounted() {
      this.getCourse();
    }
  }

</script>
