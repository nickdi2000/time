<template>
  <div class="text-center">
    <v-dialog
      v-model="active"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="red lighten-2"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Click Me
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          {{ header }}
        </v-card-title>

        <v-card-text>
          {{ content }}
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="closeModal()"
          >
            Okay
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props: {
        content: {
         type: String,
         required: true
        },
        header: {
         type: String,
         default: "Info"
        },
        active: {
          type: Boolean,
          default: false
        }
    },
    data () {
      return {
        //dialog: false,
      }
    },
    methods: {
      closeModal(){
        this.$emit('modal-active', false);
      }
    }
  }
</script>
