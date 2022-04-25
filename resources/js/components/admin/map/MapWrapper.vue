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
           @update-player="updatePlayerStatus"
           />

           <v-alert v-else>Loading...</v-alert>
        </v-card>
      </v-tab-item>

      <v-tab-item value="tab-list">
        <v-card flat v-if="players">
          <List :players="players"
                @get-players="getPlayers()"
                @clear-all="clearAll()"
                @update-player="updatePlayerStatus"
                />
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
        course: {},
        players: [],
      }
    },
    methods: {
      async clearAll(){
        let msg = `This will deactive all players' requests.
        From their end, they will see that their request has expired.`;
        if ( await this.$refs.confirm.open('Clear All', msg, { color: 'red' }) ) {
          const res = await api.clearAll(this.course.id);
          console.log(res);
          this.getPlayers();
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
      async updatePlayerStatus(player_id, status_id){
        console.log("updating status", status_id);
        let data = {"status_id" : status_id };
        const res = await api.updatePlayer(player_id, data);
        this.$toast.success(res.message);
        this.getPlayers();
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
            let audio = new Audio('/sounds/new_request.mp3')
            audio.play()
            this.$toast.success("New Request!");
            return;
        }

        const index = this.players.findIndex(q => q.id === data.playerData.id);
        this.players.splice(index, 1, data.playerData);
        console.log("existing player is: ", this.players[index].name);

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
      this.tab = 'tab-list';

    }
  }

</script>
