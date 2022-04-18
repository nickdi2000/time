<template>
  <span>
    <v-btn
      @click="dialog=true"
      elevation="2"
      small
    >
      <v-icon>mdi-help-circle</v-icon>
    </v-btn>

    <v-dialog
      v-model="dialog"
      width="500"
    >
      <v-card>
        <v-card-title class="text-h5">
          Tip!
        </v-card-title>

        <v-card-text class="mx-auto d-flex flex-column justify-content-center">
          <p v-html="message"></p>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </span>
</template>

<script>
  export default {
    props: ['message'],
    data () {
      return {
        dialog: false,
      }
    },
    computed: {

    }
  }
</script>

<style>


</style>
