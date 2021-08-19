<template>
  <v-content>
		<div class="logoDiv"><img :src="'/images/golf-ball.png'" class="logo"></div>
    <v-container fluid fill-height justify-center align-center>

			<transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
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
	}

	.pulse{
		bottom: 15%;
		width: 10%;
		left: 45%;
	}
</style>
