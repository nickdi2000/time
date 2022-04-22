<template>
  <v-app id="app">
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
  </v-app>
</template>

<script>

export default {
  mounted(){
    console.log("mounting app...");
    let course_data = this.$store.getters['player/player_course_data'];
    if ( course_data && course_data.code !== undefined && this.$route.name !== 'player'){
        console.log("my course data ", course_data.code);
        this.$router.push('/' + course_data.code);
    }

  }
}
</script>
