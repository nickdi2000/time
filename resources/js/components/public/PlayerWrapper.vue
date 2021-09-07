<template>
  <v-content>

    <v-btn x-small
      v-if="$store.getters['player/player_id']"
      color="secondary"
      outlined style="float:right;"
      class="mt-2 mr-2"
      @click="logout()"
      >
      End Session
    </v-btn>
    <v-overlay :value="overlay">
     <v-progress-circular
       indeterminate
       size="64"
     ></v-progress-circular>
   </v-overlay>


    <v-container fluid justify-center align-center>
      <v-container fluid justify-center align-center fill-height>
  			<transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>
	  </v-container>
				<PublicFooter />
	  </v-content>
</template>

<script>
import PublicFooter from '$comp/ui/PublicFooter';

export default {
  components: {PublicFooter},
  data: () => ({
    overlay: false,
  }),
  methods: {
    logout(){
      this.overlay = true;
      this.$store.dispatch('player/destroy');
      location.reload();
    }
  }
}
</script>
