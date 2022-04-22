<template>

  <v-container fluid class="w-100 my-0">

    <v-card class="px-3 my-2" v-if="!_.isEmpty(menu)">
      <v-card-text>
        <ToolTip style="float:right;" :message="item_help()" />
        <v-list v-if="!_.isEmpty(menu.items)">
          <v-subheader>ITEM TYPES</v-subheader>

          <v-list-item-group v-model="selectedItem"
                             color="primary">
            <v-list-item v-for="(item, i) in menu.items"
                         :key="i">
              <v-list-item-icon>
                <v-icon v-text="'mdi-' + (item.icon ? item.icon : 'food')"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
                      <v-chip v-for="s in item.sub_items">{{ s.title }}</v-chip>
              </v-list-item-content>
              <v-icon v-if="!item.active" title="Item is inactive">mdi-eye-off</v-icon>
            </v-list-item>
          </v-list-item-group>
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

    <v-card v-if="selectedItem !== null" class="px-3 my-2 py-2">
      <v-card-text v-if="!subTypeFormVisible">
        <v-text-field v-model="selectedItemObject.title" filled
                      label="Item Title">
        </v-text-field>
        <div>
          <v-btn small style="float:right;" @click="subTypeFormVisible = true"> <v-icon left>mdi-plus</v-icon>Add Sub-Items</v-btn>
        </div>

          <v-switch :label="'Active'"
                    class="mb-2"
                    inset
                    v-model="selectedItemObject.active"
                    :hint="'You may temporarily hide ' + selectedItemObject.title + ' by making it inactive' "></v-switch>

          <div class="mt-2">
          <v-btn color="error" outlined
                 @click="destroyMenuItem()">
            Delete
          </v-btn>

          <v-btn color="success"
                 @click="saveMenuItem()">
            Save
          </v-btn>
        </div>
        <v-btn small @click="selectedItem = null" color="secondary" style="float:right;">cancel<v-icon right >mdi-close-box-outline</v-icon></v-btn>
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


  export default {
    props: ['menu', 'user'],
    components: { ToolTip, confirm },
    data() {
      return {
        loading: false,
        showSave: false,
        revealed: null,
        selectedItemObject: {},
        selectedItem: null,
        addFormVisible: false,
        subTypeFormVisible: false,
        form: {},
        items_: [
          { title: 'Beer', icon: 'mdi-beer' },
          { title: 'SSnacks', icon: 'mdi-food' }
        ]
      }
    },
    mounted() {
      this.menu.course_id = this.user.course_id
      this.$emit('fetch-menu');
    },
    methods: {
      async destroyMenuItem() {
        if (
          await this.$refs.confirm.open('Delete', 'Are you sure you want to permanently delete this item?', {
            color: 'red'
          })
        ) {
          const rec = await api.deleteMenuItem(this.selectedItemObject.id)
          this.$emit('fetch-menu');
        }
      },
      item_help() {
        console.log('item:')
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
      async saveMenuItem() {
        const menu = await api.updateMenuItem(this.selectedItemObject, this.selectedItemObject.id)
        this.selectedItem = null
        this.$toast.success(menu.message)
      },
      async createItem(parent_id = null) {
        this.form.menu_id = this.menu.id;
        if(parent_id){
          this.form.parent_id = parent_id;
        }
        const item = await api.createMenuItem(this.form)
        this.$emit('fetch-menu');
        this.addFormVisible = false
        this.subTypeFormVisible = false;
        this.form = {}
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

<style scoped>

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
