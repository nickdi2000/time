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
                <i v-if="!player.status_id">[player cancelled]</i>
                <b v-if="player.name">{{ player.name}}</b>
                <i v-else> {{player.alias}}</i>
                <span v-if="player.hole"> Hole: {{player.hole}}</span>
                <div class="d-flex flex-row-reverse justify-space-between">
                  <b>{{player.created_at | moment("h:mm a") }}</b>
                  <small>{{ timeAgo(player.created_at) | duration('humanize', true) }}</small>
                </div>
                <div>
                  <v-btn color="error" outlined x-small @click="destroy(player.id)"><v-icon left small>delete</v-icon>remove</v-btn>
                </div>

                </v-alert>
    </v-card>

  </transition-group>

  <v-container class="text-center">
    <v-btn
      color="success"
      small
      @click="$emit('get-players')"
      >Refresh
      <v-icon right>refresh</v-icon>
    </v-btn>
  </v-container>

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
      },
      destroy(id){
        axios.delete('/api/player/' + id)
          .then(res => {
            this.$toast.success(res.data.message);
            this.$emit('get-players');
          })
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
