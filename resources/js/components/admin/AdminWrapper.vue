<template>
  <div class="fill-height">
    <app-nav :mini="mini" @nav-toggle="navToggle"></app-nav>
    <top-menu @nav-toggle="navToggle"></top-menu>

    <v-content class="fill-height" >
      <v-container>
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>
    </v-content>

    <app-footer></app-footer>
  </div>
</template>

<script>
import AppNav from './shared/AppNav'
import TopMenu from './shared/TopMenu'
import AppFooter from './shared/AppFooter'
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    mini: false
  }),

  components: {
    AppNav,
    TopMenu,
    AppFooter
  },

  methods: {
    navToggle() {
      this.mini = !this.mini
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  mounted(){
    console.log("User is", this.user);
  }
}
</script>
