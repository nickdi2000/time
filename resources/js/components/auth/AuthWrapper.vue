<template>
  <v-content>
    <v-container fluid justify-center align-center>
      <v-container class="d-flex justify-center mt-3">
        <h1>{{ $app_name }}</h1>
      </v-container>

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
  methods: {
    header(){
      //return this.$store.getters['auth/user']['course']['name'];
    }
  }
}
</script>
