<template>
  <v-content>
      <h2>Course Info</h2>
      <p v-for="(val, i) in course">
        <strong>{{ i }}:</strong> {{ val }}
      </p>

  </v-content>

</template>

<script>
import axios from 'axios'

export default {
  props: ['course']
}
</script>
