<template>
    <v-layout row justify-center wrap>
              <v-tabs
                v-model="active_tab"
                fixed-tabs
              >
                <v-tab
                  href="#config-tab"
                  class="primary--text"
                  :key="'config'"
                >
                  <v-icon>{{mdiCog}}</v-icon>

                </v-tab>

                <v-tab
                  href="#menu-tab"
                  class="primary--text"
                  :key="'menu'"
                >
                  <v-icon>mdi-food</v-icon>
                </v-tab>

              </v-tabs>


          <v-tabs-items v-model="active_tab">
            <v-tab-item value="config-tab" full-width fluid>
            <v-container fluid>
              <MenuConfig :menu.sync="menu" :user="user" @fetch-menu="fetchMenu()" @save-menu="saveMenu()"/>
            </v-container>

            </v-tab-item>

            <v-tab-item value="menu-tab" >
              <Menu :menu.sync="menu"  :user="user" @fetch-menu="fetchMenu()" />
            </v-tab-item>
          </v-tabs-items>

      <!--<v-flex lg9 sm11 xs12>
        <transition name="fade" mode="out-in">
          <router-view :user="auth"></router-view>
        </transition>
      </v-flex>
    -->
  </v-layout>


</template>

<script>
import Sidemenu from '$comp/ui/Sidemenu'
import api from '~/api'
import { mapGetters } from 'vuex'
import Menu from './menu'
import MenuConfig from './MenuConfig'
import { mdiCog } from '@mdi/js'

export default {
  components: {
    Sidemenu,
    Menu,
    MenuConfig
  },

  data: () => ({
    items: [],
    tabs: null,
    active_tab: 'config-tab',
    mdiCog: mdiCog,
    menu: {}
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  async mounted() {
      this.menu.course_id = this.user.course_id
      await this.fetchMenu();
      if(this.menu.active){
        console.log("is active");
        this.active_tab = 'menu-tab';
      }
  },
  methods: {
    async fetchMenu() {
      const menu = await api.getMenu(this.user.course_id)
      if (menu.data) {
        this.menu = menu.data
      }
    },
  async saveMenu(){
      this.loading = true;
      const m = await api.createOrUpdateMenu(this.menu);
      console.log(m.data);
      this.menu = m.data;
      this.$toast.success("Menu Saved");
      this.loading = false;
    }
  }
}
</script>

<style>

.v-window, .v-window-item {
  width: 100%;
}

</style>
