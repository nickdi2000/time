<template>
  <v-content>
    <v-container fluid justify-center align-center>
      <v-container fluid justify-center align-center fill-height>
  			<transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>
	  </v-container>
	  </v-content>
</template>

<script>

export default {
}
</script>
