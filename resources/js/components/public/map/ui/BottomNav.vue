<template>
  <v-bottom-navigation v-model="value" grow>

    <v-btn v-if="Object.keys(me).length" value="recent" @click="pan(me)">
      <span>Me</span>

      <v-icon>mdi-account</v-icon>
    </v-btn>

    <v-btn value="favorites" @click="pan(course.start)">
      <span>Start</span>

      <v-icon>mdi-play</v-icon>
    </v-btn>

    <v-btn value="nearby" @click="pan(course.finish)">
      <span>Finish</span>

      <v-icon>mdi-flag-checkered</v-icon>
    </v-btn>
  </v-bottom-navigation>
</template>

<script>
  export default {
    data: () => ({ value: 'recent' }),
    props: ['course', 'me'],
    methods: {
      pan(c){
        this.$emit('panTo', c);
      }
    }
  }
</script>
