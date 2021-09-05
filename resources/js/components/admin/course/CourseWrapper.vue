<template>
  <v-container fluid grid-list-xl>
    <v-layout row justify-center wrap>
      <v-flex lg7 sm8 xs12>
        <transition name="fade" mode="out-in">
          <router-view :course="course"></router-view>
        </transition>
      </v-flex>
      <v-flex lg3 sm4 xs12 mt-12>
        <sidemenu :threshold="67" :offset="90" :items="items"></sidemenu>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Sidemenu from '$comp/ui/Sidemenu'
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  components: {
    Sidemenu
  },

  data: () => ({
    items: [],
    course: {}
  }),

  mounted() {
    this.navigation();
    this.getCourseData();

  },
  methods: {
    getCourseData(){
      console.log('getting course data');
      let course_id = this.$store.getters['auth/user']['course_id'];
      axios.get('/api/course/' + course_id)
        .then(res => {
          this.course = res.data;
          this.loading = false;
        });
    },
    navigation() {
      this.items = [
        { title: 'View', icon: 'visibility', to: { name: 'course' } },
        { title: 'Edit', icon: 'edit', to: { name: 'course-edit' } },
      ]
    }
  }
}
</script>
