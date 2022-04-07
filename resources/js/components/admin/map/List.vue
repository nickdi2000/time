<template>

  <v-container fluid class="w-100 my-0">
    <transition-group name="list" tag="p">
    <v-card v-for="(player, index) in players"
            class="mx-auto my-2 "
            outlined
            :key="player.id">
							 <v-alert
						      border="left"
						      colored-border
						      :type="player.status_id ? 'success' : 'warning'"
						      elevation="2"
						    >
                <i v-if="player.status_id !== 1">[player cancelled]</i>
                <b v-if="player.name">{{ player.name}} </b> <v-chip v-if="player.group_size">Party of {{player.group_size}}</v-chip>
                <i v-else> {{player.alias}}</i>
                <div v-if="player.hole > 1"> Hole: {{player.hole}}</div>
                <div class="d-flex flex-row-reverse justify-space-between">
                  <b>{{player.updated_at | moment("h:mm a") }}</b>
                  <small>Updated {{ timeAgo(player.updated_at) | duration('humanize', true) }}</small>
                </div>

                <div>{{ player.position.lat }}, {{player.position.lng }}</div>
                <div>
                  <v-btn color="warning" outlined x-small @click="destroy(player.id)">
                    <v-icon left small>delete</v-icon>
                    DELETE
                  </v-btn>
                </div>

                </v-alert>
    </v-card>


  </transition-group>

      <v-card v-if="!players.length">
        <v-alert color="info">There are currently no requests</v-alert>
      </v-card>

  <v-container class="text-center">
    <v-btn
      color="success"
      small
      @click="$emit('get-players')"
      >Refresh
      <v-icon right>refresh</v-icon>
    </v-btn>

    <v-btn color="warning" small @click="$emit('clear-all')">Delete All</v-btn>
  </v-container>

  <v-alert
      v-if="players.length"
      text
      outlined
      color="deep-orange"
      icon="mdi-fire"
      class="requestBanner"
    >
      {{ players.length }} requests.
    </v-alert>

  </v-container>

</template>

<script>
import axios from 'axios'
import moment from 'moment'
import api from '~/api';

  export default {
    props: ['players'],
    data() {
      return {
        revealed: null,
      }
    },
    methods: {
      revealInfo(i){
        this.revealed = this.revealed ? null : i;
      },
      isRevealed(i){
        return this.revealed == i;
      },
      timeAgo(time){
        return moment(time).fromNow();// | duration('humanize', true);
      },
      async destroy(id){
        const res = await api.deletePlayer(id);
        this.$toast.success(res.message);
        this.$emit('get-players');
      }
    }
  }

</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.classBanner{
  position: absolute;
  opacity: 0.7;
  width: 100%;
  bottom: 0;
}

</style>
