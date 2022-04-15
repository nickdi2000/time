<template>

  <v-container fluid justify-center align-center fill-height>
    <v-flex sm8 md6 lg4>
      <v-card>
        <v-alert dense outlined
                 type="error"
                 v-if="$route.params.error">
          This course is either inactive, or has not been registered yet. Courses may sign up for free at
          <a :href="$app_url + '/register'">{{$app_url}}/register</a>
        </v-alert>

        <v-toolbar dark color="primary" flat>
          <v-toolbar-title>Find a Course</v-toolbar-title>
        </v-toolbar>
        <v-card-text class="d-flex flex-column" fluid justify-center align-center>
          <v-combobox v-if="courses"
                      v-model="selectedCourse"
                      label="Golf Course"
                      :items="courses"
                      item-text="name"
                      auto-select-first
                      :hint="hint()">
          </v-combobox>

          <v-btn color="success" large
                 @click="go()"
                 :disabled="!selectedCourse"
                 class="mt-4 align-self-end">GO
            <v-icon right>check_circle</v-icon>
          </v-btn>

        </v-card-text>
      </v-card>

      <v-card class="mt-4 pt-2 py-2 animated tdFadeInUp">
        <v-card-text class="d-flex flex-column">
          <Radar v-if="loading" />
          <v-btn v-else type="accent" elevation="2" @click="useMyLocation()">
            {{ closestCourse ? 'Try Again' : 'Use My Location' }}
            <v-icon right>mdi-crosshairs-gps</v-icon>
          </v-btn>
          <v-alert type="error"  class="my-3" v-if="error">
            {{ error }}
          </v-alert>

          <div v-if="closestCourse" class="mt-3 mx-auto d-flex flex-column">
            The closest course we found is {{closestCourse.distance}}KM away:<br/>
            <v-btn
                color="info"
                elevation="5"
                :to="'/' + closestCourse.code"
            >
              <v-card-text>{{ closestCourse.name }}</v-card-text>
            </v-btn>
          </div>
        </v-card-text>
      </v-card>

      <div class="text-center mt-4">Work for the Course?
        <router-link :to="{ name: 'register' }">Register</router-link>
      </div>
    </v-flex>
  </v-container>

</template>

<script>

  import PublicFooter from '$comp/ui/PublicFooter'
  import axios from 'axios'
  import Geo from '~/mixins/geo'
  import api from '~/api'
  import Radar from '~/components/misc/Radar'

  export default {
    components: { PublicFooter, Radar },
    mixins: [Geo],
    data: () => ({
      courses: [],
      disabled: true,
      selectedCourse: null,
      loading: false,
      closestCourse: null,
      error: null
    }),
    methods: {
      go() {
        console.log('go', this.selectedCourse)
        this.$router.push('/' + this.selectedCourse.code)
      },
      getCourses() {
        let url = '/api/guest-course'
        axios
          .get(url)
          .then(res => {
            this.courses = res.data
          })
          .catch(err => {
            this.handleErrors(err.response.data.errors)
          })
      },
      async useMyLocation(){
        this.error = null;
        this.loading = true;
        const loc = await this.getLocation();
        let app = this;
        try {
          const course = await api.findClosestCourse(loc);
          console.log('course::', course);
          if(course.data.distance > 12){
            app.closestCourse = course.data;
          } else {
            app.$router.push('/' + course.data.code);
          }
        } catch (error) {
          console.log("caught an error: ", error);
          this.error = "Unable to fetch location.  Please make sure your devices location is enabled.";
        }
      },
      hint() {
        let code = this.selectedCourse ? this.selectedCourse.code : ''
        return this.$app_url + '/' + code
      }
    },
    mounted() {
      this.getCourses()
      console.log(this.$route.params.error)
    }
  }

</script>
