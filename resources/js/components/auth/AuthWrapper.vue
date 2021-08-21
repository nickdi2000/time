<template>
  <v-content>
		<div class="logoDiv"><img :src="'/images/golf-ball.png'" class="logo"></div>
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
	.logoDiv{
			width:100%;
			text-align: center;
			position: fixed;
			top: 3%;
	}

	.logo {
		width: 30%;
		opacity: 0.6;
    z-index: -99;
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
