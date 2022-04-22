<template>

  <v-container fluid class="w-100 my-0">

    <v-card class="px-3 my-2" v-if="!_.isEmpty(menu)">
      <v-card-text>
        <div>
          <ToolTip style="float:right;" :message="item_help()" /><br/>
        </div>
        <v-list>
          <v-list-group :value="false"
                        v-for="(item, i) in menu.items"
                        :key="i"
                        @click="selectedItemObject = item">


              <template v-slot:prependIcon>
                <v-icon @click="changeIcon()">{{ item.display_icon }}</v-icon>
              </template>


                <template  v-slot:appendIcon>
                  <v-icon v-if="item.sub_items && item.sub_items.length">mdi-menu-down</v-icon>
                  <v-icon v-else></v-icon>
                </template>

            <template v-slot:activator>
                    <v-list-item-title :class="{ 'strike': !item.active  }">{{ item.title }}
                      <i v-if="item.sub_items.length">
                        ({{item.sub_items.length}})</i>
                      </v-list-item-title>
                      <v-icon v-if="!item.active" @click="toggleHidden(item)">mdi-eye-off</v-icon>
                  </template>

              <v-list-item v-for="s in item.sub_items" :key="s.id" class="ml-4">
                <ArrowIcon />
                <v-btn @click="selectedItemObject = s" color="secondary" rounded
                       class="ml-3 "
                       :class="{ 'strike': !s.active  }">{{s.title}}
                </v-btn>

                <v-list-item-action>
                  <v-btn icon @click="toggleHidden(s)">
                    <v-icon color="grey lighten-1">{{s.active ? 'mdi-eye' : 'mdi-eye-off' }}</v-icon>
                  </v-btn>
                </v-list-item-action>
              </v-list-item>


            </v-list-item>

          </v-list-group>
        </v-list>

        <v-list-item v-show="addFormVisible" :key="selectedItem" transition="scroll-x-transition">
          <v-text-field label="Name of Item"
                        v-model="form.title"
                        v-on:keyup.enter="createItem()">
          </v-text-field>
          <v-btn color="success" @click="createItem()">
            Save
          </v-btn>
        </v-list-item>

      </v-card-text>

      <v-btn @click="addFormVisible = true"
             color="pink"
             fab
             dark
             small
             absolute
             bottom
             right>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-card>


    <v-expand-transition>

      <v-card v-if="!_.isEmpty(selectedItemObject)" class="px-3 my-2 py-2">
        <v-card-text v-if="!subTypeFormVisible">
          <v-text-field
              v-model="selectedItemObject.title"
              filled
              :label="(_.has(selectedItemObject, 'sub_items') && selectedItemObject.sub_items.length) ? 'Name of Category' : 'Item Name'"
          >
          </v-text-field>
          <div>

             <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                <v-btn small
                       style="float:right;margin-left:2px"
                        v-bind="attrs" v-on="on"
                       @click="subTypeFormVisible = true"
                       v-if="!selectedItemObject.parent_id">
                  <v-icon left>mdi-plus</v-icon>
                  Add Sub-Items
                </v-btn>
              </template>
              <span>This item will act as a category if you add sub-items to it.</span>
            </v-tooltip>

            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    small
                    dark
                    v-bind="attrs"
                    v-on="on"
                    style="float:right;margin-right:2px;"
                    v-if="!hasSubItems(selectedItemObject)"
                  >
                    {{ selectedItemObject.parent_id ? 'Change Category' : 'Attach to Category' }}
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item
                    v-for="(cat, index) in cats"
                    :key="index"
                  >
                    <v-list-item-title @click="changeCat(cat.id)">{{ cat.title }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>

          </div>

          <v-switch :label="selectedItemObject.active ? 'Visible' : 'Hidden'"
                    class="mb-2"
                    inset
                    v-model="selectedItemObject.active"
                    :hint="'Hiding  ' + selectedItemObject.title + ' will remove it from the users menu screen' "></v-switch>

          <div class="mt-2">
            <v-btn color="error" outlined @click="destroyMenuItem()">
              Delete
            </v-btn>

            <v-btn color="success" @click="saveMenuItem()">
              Save
            </v-btn>
          </div>
          <v-btn small
                 @click="selectedItemObject = {}"
                 color="secondary"
                 style="float:right;">cancel
            <v-icon right>mdi-close-box-outline</v-icon>
          </v-btn>
          <br/>
        </v-card-text>

        <v-card-text v-else>
          <v-text-field :label="'Name of ' + selectedItemObject.title +' Item'"
                        v-model="form.title"
                        v-on:keyup.enter="createItem(selectedItemObject.id)">
          </v-text-field>
          <v-btn color="success" @click="createItem(selectedItemObject.id)">
            Create
          </v-btn>
          <v-btn @click="subTypeFormVisible = false">Back</v-btn>
        </v-card-text>

      </v-card>
    </v-expand-transition>
    <confirm ref="confirm"></confirm>
  </v-container>

</template>

<script>

  import axios from 'axios'
  import moment from 'moment'
  import api from '~/api'
  import ToolTip from '~/components/admin/shared/ToolTip'
  import confirm from '~/components/partials/Confirm'
  import ArrowIcon from '~/components/svg/ArrowIcon'

  export default {
    props: ['menu', 'user'],
    components: { ToolTip, confirm, ArrowIcon },
    data() {
      return {
        loading: false,
        showSave: false,
        revealed: null,
        activateIconDrawer: false,
        selectedItemObject: {},
        selectedItem: null,
        addFormVisible: false,
        subTypeFormVisible: false,
        form: {},

      }
    },
    computed: {
      cats(){
        return this.menu.items;
      }
    },
    mounted() {
      this.menu.course_id = this.user.course_id
      this.$emit('fetch-menu')
    },
    methods: {
      async changeIcon(){
        console.log("changing..");
        this.activateIconDrawer = true;
      },
      hasSubItems(obj){
        return _.has(obj, 'sub_items') && obj.sub_items.length;
      },
      async destroyMenuItem() {
        let msg = 'Are you sure you want to permanently delete ' + this.selectedItemObject.title;
        msg += _.has(this.selectedItemObject, 'sub_items') ? ' and all of its sub-items?' : '?';
        if (
          await this.$refs.confirm.open('Delete', msg, {
            color: 'red'
          })
        ) {
          const rec = await api.deleteMenuItem(this.selectedItemObject.id)
          this.$emit('fetch-menu')
          this.selectedItemObject = {};
        }
      },
      item_help() {
        let str = ''
        if (this.menu.items.length == 3) {
          str = `Beer, Snacks and Drinks are the default item types.  But you may modify, delete or add more items as required.<br/><br/>`
        }
        str += `The items can be used as 'categories' by adding sub-items below them (ie: Beer -> Budweiser, Blue),
          or just leave them as is, in which case the category will just act as its own generic "item".
            (order a "Beer" instead of a "Budweiser").  You can mix and match the specificity of each line of items, and change it at any time.
              In other words, a category without items will act as an "item", and still be available to request.`
        return str
      },
      resetPage(){
        this.selectedItemObject = {};
        this.addFormVisible = false
        this.subTypeFormVisible = false
        this.form = {}
      },
      async saveMenuItem() {
        const menu = await api.updateMenuItem(this.selectedItemObject, this.selectedItemObject.id)
        this.selectedItem = null
        this.$toast.success(menu.message)
        this.$emit('fetch-menu');
        this.resetPage();
      },
      async createItem(parent_id = null) {
        this.form.menu_id = this.menu.id
        if (parent_id) {
          this.form.parent_id = parent_id
        }
        const item = await api.createMenuItem(this.form)
        this.$emit('fetch-menu')
        this.resetPage();
      },
      async toggleHidden(itemObj) {
        itemObj.active = !itemObj.active
        const menu = await api.updateMenuItem(itemObj, itemObj.id)
        this.$toast.success(menu.message)
        this.$emit('fetch-menu')
      },
      changeCat(id){
        this.selectedItemObject.parent_id = id;
        this.saveMenuItem();
      }
    },
    watch: {
      selectedItem() {
        this.selectedItemObject = this.menu.items[this.selectedItem]
      },
      addFormVisible() {
        this.selectedItem = null
        this.selectedItemObject = null
      }
    }
  }

</script>

<style>

  .strike {
    text-decoration: line-through;
    color: #986868;
  }
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }

</style>
