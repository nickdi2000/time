<template>
  <v-container class="no-margins" style="width:100%;padding:0;margin:0">
    <v-tabs v-model="tab"
            fill-height
            centered
            dark
            icons-and-text
            class="px-0 mx-0">
      <v-tabs-slider></v-tabs-slider>

        <v-tab href="#tab-list">
          RACE!
          <v-icon>mdi-clock</v-icon>
        </v-tab>

      <v-tab href="#tab-map">
        Map
        <v-icon>mdi-map</v-icon>
      </v-tab>

      <v-tab href="#tab-list">
        SCORES
        <v-icon>mdi-format-list-bulleted</v-icon>
      </v-tab>

    </v-tabs>

    <v-tabs-items v-model="tab" fill-height>
      <v-tab-item value="tab-map">
        <v-card flat >
          <gMap
          v-if="Object.keys(course).length !== 0"
          :course="course"
           />

           <v-alert v-else>Loading...</v-alert>
        </v-card>
      </v-tab-item>

      <v-tab-item value="tab-list">
        <v-card flat v-if="players">

        </v-card>
      </v-tab-item>

    </v-tabs-items>
    <confirm ref="confirm"></confirm>
  </v-container>

</template>

<script>

  import axios from 'axios'
  import gMap from './Map'
  import List from './List'
  import { mapGetters } from 'vuex'
  import api from '~/api';
  import confirm from '~/components/partials/Confirm'

  export default {
    components: {
      gMap,
      List,
      confirm
    },
    data() {
      return {
        tab: null,
        course: {
          start: {
            lat: 43.25080218322437,
            lng: -79.85945315788987
          },
          finish: {
            lat: 43.24414141085183,
            lng: -79.88095089286679
          }

        },

        players: [],
      }
    },
    methods: {

    },
    computed: mapGetters({
      user: 'auth/user'
    }),

    mounted() {
      /*
      let app = this;
      var playerEvents = window.pusher.subscribe('players-1'); //TODO: make dynamic course_id
      playerEvents.bind('PlayerAdded', function(e) {
        app.handlePlayerEvent(e);
      });
      this.tab = 'tab-list';
      */
    }
  }

</script>
