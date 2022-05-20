<template>

  <v-container fluid class="w-100 my-0">
    <v-slide-y-transition group tag="v-card" hide-on-leave>
      <v-card v-for="(player, index) in players"
              v-if="mix_playerIsActive(player.status_id)"
              class="mx-auto my-2 "

              :key="player.id">
        <v-alert border="left" colored-border
                 :type="statusType(player.status_id)"
                 :color="statusColor(player.status_id)"
                 elevation="2"
                 >
          <b v-if="player.name">{{ player.name}} </b>
          <i v-else> {{player.alias}}</i>

          <v-chip :class="{'glow': player.status_id == 1}" class="ml-3 status-chip" :color="statusColor(player.status_id)" small>
            {{ statusName(player.status_id) }}
          </v-chip>

          <v-chip v-if="player.group_size > 1">Party of {{player.group_size}}</v-chip>

          <div v-if="player.hole > 1"> Hole: {{player.hole}}</div>
          <div class="d-flex flex-row-reverse justify-space-between">
            <b class="mt-3">{{player.updated_at | moment("h:mm a") }}</b>
            <small :title="player.updated_at">
              Updated {{ timeAgo(player.updated_at) }}
            </small>
          </div>

          <div v-if="showLat">{{ player.position.lat }}, {{player.position.lng }}</div>
          <v-chip color="default" label outlined v-for="(ord, k) in mix_compactOrder(player.order_object)"
          :key="player.id + '-' + k" class="mr-1">

            <v-icon left>mdi-food</v-icon>
            {{ k }} x {{ ord }}
          </v-chip>

          <div class="d-flex flex-row-reverse">
            <StatusSelect @update-status="updateStatus(player.id, $event)" />
          </div>

        </v-alert>
      </v-card>
    </v-slide-y-transition>

    <v-card v-if="!mix_activeCount() && !showInactive">
      <v-alert type="info">There are currently no active requests. Customers may submit requests at <strong>{{ $store.getters['auth/user']['course']['publicUrl'] }}</strong></v-alert>
    </v-card>

    <v-sheet elevation="2" class="text-center px-2">
      <v-btn color="success" small
             @click="$emit('get-players')">Refresh
        <v-icon right>refresh</v-icon>
      </v-btn>

      <v-btn color="error" small @click="$emit('clear-all')" v-if="!showInactive && mix_activeCount()">
        <v-icon left>mdi-delete</v-icon>Reject All</v-btn>
      <div class="mt-2">
        <v-switch label="Show Inactive Players" v-model="showInactive"></v-switch>
        <small>Total: {{ players.length }} | Active: {{ mix_activeCount() }}</small>
      </div>
    </v-sheet>

  </v-container>

</template>

<script>

  import axios from 'axios'
  import moment from 'moment'
  import api from '~/api'
  import getStatus from '~/mixins/getStatus'
  import StatusSelect from './ui/StatusSelect'

  export default {
    props: ['players'],
    components: { StatusSelect },
    mixins: [getStatus],
    data() {
      return {
        revealed: null,
        showLat: false,
        showInactive: false
      }
    },
    methods: {
      revealInfo(i) {
        this.revealed = this.revealed ? null : i
      },
      isRevealed(i) {
        return this.revealed == i
      },
      timeAgo(time) {
        return moment(time).fromNow(); // | duration('humanize', true);
      },
      async updateStatus(player_id, status_id) {
        console.log('updating to async: ' + status_id + ' ' + player_id)
        this.$emit('update-player', player_id, status_id)
      },
      async destroy(id) {
        const res = await api.deletePlayer(id)
        this.$toast.success(res.message)
        this.$emit('get-players')
      }
    }
  }

</script>

<style scoped>

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }

  .classBanner {
    position: absolute;
    opacity: 0.7;
    width: 100%;
    bottom: 0;
  }

  .glow {
    background-color: #fff;
    animation: glowing 1.4s infinite alternate;
  }

  .status-chip{
    float:right;
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
