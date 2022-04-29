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
        <small>All this info is optional, but providing more details can help the cart attendant find and identify you quicker.</small>
    </v-alert>

    <v-text-field
        v-model="player.name"
        outlined
        label="Name (or use default)"
        hint="Give us a name or nick-name to help us find you, or just use the dummy name already provided."
      ></v-text-field>

      <p>Size of your party</p>
      <v-slider
        :tick-labels="sizes"
        v-model="player.group_size"
        min="1"
        max="4"
        ticks="always"
        tick-size="3"
      >

      </v-slider>

      <v-container class="py-2" v-if="false">
        <v-col cols="12">
             <v-subheader class="pl-0">
               Current Hole (used if Geo-locate fails)
             </v-subheader>
             <v-slider
               v-model="player.hole"
               thumb-label="always"
               min="1"
               max="18"
               hint="Attendant will be provided an estimated hole based on the hole you give now. "
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
    sizes: ['1', '2', '3', '4']
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
