<template>

  <v-container fluid class="w-100 my-0">
    <v-card class="px-3 my-2 py-2">
        <v-card-text>
             <div class="mx-auto">
                 <v-switch
                :label="'Activate Menu'"
                @change=""
                class="mb-v pb-0"
              ></v-switch>
              <ToolTip style="float:right;" :message="'The app will still allow requests to be made with an inactive menu -- the users just won\'t be able to select what they want specifically. This can be useful when your inventory is low or inconsistent.'"/>
              <br/>
            </div>
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
                      <v-icon v-text="item.icon ? item.icon : 'mdi-food'"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>

                  <v-list-item v-if="addFormVisible">
                    <v-text-field
                    label="Name of Item"
                    v-model="form.text"
                    v-on:keyup.enter="saveForm()"
                    >
                    </v-text-field>
                    <v-btn color="success" @click="saveForm()">
                      Save
                    </v-btn>
                  </v-list-item>

                </v-list-item-group>
              </v-list>
        </v-card-text>

        <v-btn
            @click="addFormVisible = true"
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
         selectedItem: {},
         addFormVisible: false,
         form: {},
         items: [
            { text: 'Beer', icon: 'mdi-beer' },
            { text: 'Snacks', icon: 'mdi-food' },
            { text: 'Drinks (non alc)', icon: 'mdi-cup' },
          ],
      }
    },
    methods: {
      saveForm(){
        this.items.push(this.form);
        this.addFormVisible = false;
        this.form = {};
      }
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

.v-input--switch{
  display:inline;
  width: 30px;
}
</style>
