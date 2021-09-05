<template>
  <v-content>
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
  components: {PublicFooter}
}
</script>
