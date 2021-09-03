<template>
  <v-content>
    <v-container fluid justify-center align-center>
      <v-container fluid justify-center align-center fill-height>
  			<transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>



	  </v-container>
				<v-container class="w-100 d-flex" fluid justify-center align-items-end>

				</v-container>
				<v-footer style="position: absolute; bottom: 0;width:100%" class="w-100">
			    <v-col
			      class="text-center"
			      cols="12"
			    >
			      {{ new Date().getFullYear() }} — <small>Work at the course? | <router-link :to="'/register'">Sign Up</router-link></small>
			    </v-col>
			  </v-footer>
	  </v-content>
</template>

<script>

export default {
}
</script>
