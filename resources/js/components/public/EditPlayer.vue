<template >
  <v-content>
    <v-card elevation="18" class="spacing-playground pa-6 mt-3">
      <v-alert
          text
          dense
          color="teal"
          icon="mdi-clock-fast"
          border="left"
        >
        <small>Providing more details will help the cart attendant find and identify you.</small>
    </v-alert>

    <v-text-field
        v-model="player.name"
        outlined
        label="Name.."
        persistent-hint
        hint="Give us a name or nick-name to help us find you, or just use the provided name"
      ></v-text-field>

      <v-container class="py-2">
        <v-col cols="12">
             <v-subheader class="pl-0">
               Current Hole
             </v-subheader>
             <v-slider
               v-model="player.hole"
               thumb-label="always"
               min="1"
               max="18"
               hint="This is used if the geo-locate fails. "
             ></v-slider>
           </v-col>
    </v-container>

      <v-btn color="success" @click="save()">Save</v-btn>
      <v-btn @click="$emit('hide-edit')">Back</v-btn>
</v-card>
	 </v-content>

</template>

<script>
import axios from 'axios';

export default {
  components: {},
  props: ['player'],
  data: () => ({
  }),
  methods: {
    save(){
      let audio = new Audio('/sounds/ui_click.wav');
      audio.play();
      axios.put('/api/player/' + this.player.id, this.player)
        .then(res => {
          console.log(res.data);
          this.$toast.success(res.data.message);
          this.$emit('hide-edit');

        })
    }
  }
}
</script>
