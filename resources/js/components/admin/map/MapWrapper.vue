<template>
  <v-container class="no-margins" style="width:100%;padding:0;margin:0">
    <v-tabs v-model="tab"
            fill-height
            centered
            dark
            icons-and-text
            style="height:100%;width:100%"
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
					 @get-players="getPlayers()"
           @delete-player="deletePlayer"
           />

           <v-alert v-else>Loading...</v-alert>
        </v-card>
      </v-tab-item>

      <v-tab-item value="tab-list">
        <v-card flat v-if="players">
          <List :players="players"
                @get-players="getPlayers()"
                @clear-all="clearAll()"
                />
        </v-card>
      </v-tab-item>

    </v-tabs-items>
  </v-container>

</template>

<script>

  import axios from 'axios'
  import gMap from './Map'
  import List from './List'
  import { mapGetters } from 'vuex'
  import api from '~/api';

  export default {
    components: {
      gMap,
      List
    },
    data() {
      return {
        tab: null,
        course: {},
        players: [],
      }
    },
    methods: {
      async clearAll(){
        if (confirm("Clear all requests?, Players can submit another request if they choose to")){
          console.log("clearing all");
          const res = await api.clearAll(this.course.id);
          console.log(res);
          this.players = [];
        }
      },
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
      },
      async deletePlayer(id){
        const res = await api.deletePlayer(id);
        this.$toast.success(res.message);
        this.getPlayers();
      },
      handlePlayerEvent(data){
        console.log("PLAYING EVENT!", data);
        if(data.playerExists === false){
            this.players.push(data.playerData);
            this.$toast.success("New Request!");
            return;
        }

        const index = this.players.findIndex(q => q.id === data.playerData.id);
        this.players.splice(index, 1, data.playerData);
        console.log("splayer is: ", this.players[index]);

      }
    },
    computed: mapGetters({
      user: 'auth/user'
    }),

    mounted() {
      this.getCourse();
      let app = this;
      var playerEvents = window.pusher.subscribe('players-1'); //TODO: make dynamic course_id
      playerEvents.bind('PlayerAdded', function(e) {
        app.handlePlayerEvent(e);
      });

    }
  }

</script>
