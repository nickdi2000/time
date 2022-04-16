<template>
  <span>
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          v-bind="attrs"
          v-on="on"
          elevation="2"
          small
        >
          <v-icon>mdi-help-circle</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5">
          Tip!
        </v-card-title>

        <v-card-text class="mx-auto d-flex flex-column justify-content-center">
          <p>{{ message }}</p>
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
