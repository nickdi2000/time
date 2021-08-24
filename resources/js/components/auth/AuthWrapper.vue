<template>
  <v-content>
    <v-container fluid justify-center align-center>
      <v-container class="d-flex justify-center mt-3">
        <h1>Caddy Snack</h1>
      </v-container>

      <v-container fluid justify-center align-center fill-height>
  			<transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>
	  </v-container>
	  </v-content>
</template>

<script>
import Pulse from '~/components/misc/Pulse'

export default {
	components: {Pulse}
}
</script>


<style scoped>
	#logoDiv{
			width:100%;
			height: 100%;
			background: url("/images/golf-ball.png");
			background-size: cover;
	}


	.pulse{
		bottom: 15%;
		width: 10%;
		left: 45%;
	}

  h1{
    z-index: 99;
  }


</style>
