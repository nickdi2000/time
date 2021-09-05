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
						      type="success"
						      elevation="2"
						    >
                <b v-if="player.name">{{ player.name}}</b>
                <i v-else> {{player.alias}}</i>

                <div class="d-flex flex-row-reverse justify-space-between">
                  <b>{{player.created_at | moment("h:mm a") }}</b>
                  <small>{{ timeAgo(player.created_at) | duration('humanize', true) }}</small>
                </div>
                </v-alert>
    </v-card>

  </transition-group>

  <v-alert
      v-if="players.length"
      text
      outlined
      color="deep-orange"
      icon="mdi-fire"
      style="position:relative;top:40px;opacity:0.7"
    >
      {{ players.length }} requests.
    </v-alert>

  </v-container>

</template>

<script>
import axios from 'axios'
import moment from 'moment'

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

</style>
