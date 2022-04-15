<template>
  <v-container fluid grid-list-xl>
    <v-layout row justify-center wrap>
      <v-flex lg12>
        <transition name="fade" mode="out-in">
          <router-view :user="auth"></router-view>
        </transition>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Sidemenu from '$comp/ui/Sidemenu'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  components: {
    Sidemenu
  },

  data: () => ({
    items: [],
  }),
  computed: mapGetters({
    auth: 'auth/user'
  }),
  mounted() {


  },
  methods: {

  }
}
</script>
