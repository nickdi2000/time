<template>

  <v-container fluid class="w-100 my-0">
    <v-card class="px-3 my-2 py-2">
        <v-card-text>
             <div class="mx-auto">
               <ToolTip style="float:right;" :message="'The app will still allow requests to be made with an inactive menu -- the users just won\'t be able to select what they want specifically. This can be useful when your inventory is low or inconsistent.'"/>
               <span style="width:50%;display:inline;">
                 <v-switch
                  :label="'Activate Menu'"
                  @change="saveMenu()"
                  class="mb-v pb-0"
                  v-model="menu.active"
              ></v-switch>
              </span>
            </div>

            <v-text-field
              v-model="menu.message"
              @input="showSave = true"
              label="Menu Message"
              v-on:keyup.enter="saveMenu()"
              hint="Use this if there is a message you would like to communicate to your users regarding the menu"
              >
            </v-text-field>
            <v-btn color="success" @click="saveMenu()" small class="mt-2" v-if="showSave" :loading="loading">
              Save<v-icon>mdi-save</v-icon>
            </v-btn>

        </v-card-text>

    </v-card>

    <v-card class="px-3 my-2" v-if="!_.isEmpty(menu)">
        <v-card-text>
          <ToolTip style="float:right;" :message="item_help()" />
              <v-list v-if="!_.isEmpty(menu.items)">
                <v-subheader>ITEMS</v-subheader>

                <v-list-item-group
                  v-model="selectedItem"
                  color="primary"
                >
                  <v-list-item
                    v-for="(item, i) in menu.items"
                    :key="i"
                  >
                    <v-list-item-icon>
                      <v-icon v-text="'mdi-' + (item.icon ? item.icon : 'food')"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title v-text="item.title"></v-list-item-title>
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
                    user: {{ user.id}}
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

    <v-card v-if="selectedItem !== null" class="px-3 my-2 py-2">
      <v-card-text>
        <v-text-field
          v-model="selectedMenuItem.title"
          filled
          label="Item Title"
          >
        </v-text-field>

          <v-switch
           :label="'Active'"
           class="mb-2"
           v-model="selectedMenuItem.active"
           :hint="'You may temporarily hide ' + selectedMenuItem.title + ' by making it inactive' "
           ></v-switch>

           <v-btn
            color="warning">
            Delete
          </v-btn>

           <v-btn
            color="success"
            @click="saveMenuItem()"
            >
            Save
          </v-btn>


      </v-card-text>

    </v-card>

  </v-container>

</template>

<script>
import axios from 'axios'
import moment from 'moment'
import api from '~/api';
import ToolTip from '~/components/admin/shared/ToolTip';
import { mapGetters } from 'vuex'

  export default {
    props: [],
    components: {ToolTip},
    data() {
      return {
        loading: false,
        menu: {},
        showSave: false,
        revealed: null,
        selectedMenuItem: {},
         selectedItem: null,
         addFormVisible: false,
         form: {},
         items_: [
            { title: 'Beer', icon: 'mdi-beer' },
            { title: 'SSnacks', icon: 'mdi-food' },
          ],
      }
    },
    computed: {
      ...mapGetters({
        user: 'auth/user'
      }),

    },
    mounted(){
      this.fetchMenu();
      this.menu.course_id = this.user.course_id;
    },
    methods: {
      async fetchMenu(){
        const menu = await api.getMenu(this.user.course_id);
        if(menu.data){
          this.menu = menu.data;
        }

      },
      async saveMenuItem(){
        const menu = await api.updateMenuItem(this.selectedMenuItem, this.selectedMenuItem.id);
        console.log(menu);
      },
      item_help(){
        console.log("item:", );
        let str = '';
        if('BeerSnacksDrinks (non-alc)' == this.menu.items[0].title + this.menu.items[1].title + this.menu.items[2].title && this.menu.items.length == 3){
          str = `These 3 (beer,snacks,drinks) are the default items.  But you may modify, delete or add more items as required.<br/><br/>`;
        }
        str += `The menu can be simple and generic (beer, snacks, etc) or specific to your offerings (Budweiser, Doritos)... or a mix of both.
        In other words, you can use the items as 'categories' by adding sub-items below them (ie: Beer -> Budweiser, Blue), or just leave them as is
        and allow the golfers to place an order for a "Beer" instead of a "Budweiser".  You can mix and match these how specific you are across the board and change it any time.
          `;
        return str;
      },
      saveForm(){
        this.menu.items.push(this.form);
        this.addFormVisible = false;
        this.form = {};
      },
      async saveMenu(){
        this.loading = true;
        const m = await api.createOrUpdateMenu(this.menu);
        console.log(m.data);
        this.menu = m.data;
        this.$toast.success("Menu Saved");
        this.loading = false;
        this.showSave = false;
      }
    },
    watch: {
      selectedItem() {
        this.selectedMenuItem = this.menu.items[this.selectedItem];
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
