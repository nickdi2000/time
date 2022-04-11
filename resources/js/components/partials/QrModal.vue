<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          dark
          v-bind="attrs"
          v-on="on"
        >
          QR <v-icon right>mdi-qrcode</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5">
          QR CODE
        </v-card-title>

        <v-card-text class="mx-auto d-flex flex-column justify-content-center">
          <v-alert type="info" condensed >
            Let a fellow golfer scan this so they can order a drink when they're ready.
          </v-alert>
          

				<vue-qrcode :value="link" />
        <br/>
        <i>*NOTE: If the QR code fails, users can navigate to this link manually: <b>{{ url }}</b></i>
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
  </div>
</template>

<script>
import VueQrcode from 'vue-qrcode'
  export default {
    components: {VueQrcode},
    props: ['url'],
    data () {
      return {
        dialog: false,
      }
    },
    computed: {
      link(){
        return 'https://' + this.url;
      }
    }
  }
</script>
