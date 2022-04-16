<template>

  <v-container fluid class="w-100 my-0">
    <v-card class="px-3 my-2 py-2">
      <h2>Menu</h2>

        <v-card-text>
             <v-switch
              :label="'Activate Menu'"
              @change=""
              class="mb-v pb-0"
            ></v-switch>
            <ToolTip :message="'The app will still allow requests to be made with an inactive menu -- the users just won\'t be able to select what they want specifically. This can be useful when your inventory is low or inconsistent.'"/>
        </v-card-text>

    </v-card>

    <v-card class="px-3 my-2">
        <v-card-text>
              <v-list>
                <v-subheader>ITEMS</v-subheader>
                <v-list-item-group
                  v-model="selectedItem"
                  color="primary"
                >
                  <v-list-item
                    v-for="(item, i) in items"
                    :key="i"
                  >
                    <v-list-item-icon>
                      <v-icon v-text="item.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
        </v-card-text>

        <v-btn
            color="pink"
            fab
            dark
            small
            absolute
            bottom
            right
          >
            <v-icon>mdi-plus</v-icon>
          </v-btn>
    </v-card>

    <v-card v-if="selectedItem" class="px-3 my-2 py-2">
      selected: {{ selectedItem }}
    </v-card>

  </v-container>

</template>

<script>
import axios from 'axios'
import moment from 'moment'
import api from '~/api';
import ToolTip from '~/components/admin/shared/ToolTip';

  export default {
    props: [],
    components: {ToolTip},
    data() {
      return {
        revealed: null,
         selectedItem: null,
         items: [
            { text: 'Beer', icon: 'mdi-beer' },
            { text: 'Snacks', icon: 'mdi-food' },
            { text: 'Drinks (non alc)', icon: 'mdi-cup' },
          ],
      }
    },
    methods: {
    }
  }

</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.classBanner{
  position: absolute;
  opacity: 0.7;
  width: 100%;
  bottom: 0;
}

</style>
