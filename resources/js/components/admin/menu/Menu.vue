<template>

  <v-container fluid class="w-100 my-0">
    <v-card class="px-3 my-2">
      <h2>Menu</h2>

        <v-card-text>
           <v-row no-gutters>
             <v-col cols="6">
             <v-switch
              :label="'Active Menu'"
              @change=""
            ></v-switch>
          </v-col>
            <v-col>
            <ToolTip />
          </v-col>
          </v-row>

        </v-card-text>

      <v-alert condensed type="info" outline text>
        The app will still allow requests to be made with an inactive menu -- the users just won't be able to select what they want specifically.  To de-activate the app temporarily,
        navigate to the main <router-link :to="'/course'">Course Setup</router-link> page.
      </v-alert>

    </v-card>

    <v-card class="px-3 my-2">
        <v-card-text>
              <v-list flat>
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
