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
				<v-footer style="position: absolute; bottom: 0;width:100%" class="w-100">
			    <v-col
			      class="text-center"
			      cols="12"
			    >
						<small>


							<router-link :to="'/register'">Register</router-link> |
							<router-link :to="'/login'">Login</router-link> |
							<router-link :to="'/about'">About</router-link>

						</small>
			    </v-col>
			  </v-footer>
	  </v-content>
</template>

<script>
import Footer from '$comp/ui/footer';

export default {
	components: ['Footer']
}
</script>
