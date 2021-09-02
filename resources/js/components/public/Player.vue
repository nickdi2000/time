<template>
  <v-flex sm8 md6 lg4>

		<v-container class="w-100 d-flex" fluid justify-center align-center>
				<transition name="slide-fade">
					<v-img v-if="showLogo" src="/images/beer-logo.png" max-width="100"></v-img>
				</transition>
		</v-container>



    <v-card class="mx-auto">
      <v-toolbar dark color="primary" flat>
        <v-toolbar-title>CaddySnack.ca/{{ code }}</v-toolbar-title>
      </v-toolbar>
			<v-card-text >
        <v-container v-if="notFound">
          <v-alert
           border="right"
           colored-border
           type="error"
           elevation="2"
         >
          No CaddySnack profile exists for this course.. <br/><br/>
          Suggest that they sign up at <b>CaddySnack.ca/register</b>
         </v-alert>
        </v-container>

				<v-container style="text-align:center;" v-else fluid class="d-flex flex-column align-items-center justify-content-center">
         <small>Welcome to</small>
         <h3 class="animate__animated animate__bounce"> {{ course.name }} </h3>
				<!--<v-text-field
            v-model="name"
            outlined
            label="Name.."
						persistent-hint
						hint="Give us a name or nick-name to help us find you"
						style="font-size:2em"
          ></v-text-field>-->
          <v-container v-if="!requested" class="p-4">
	         <v-btn
						color="default"
						large
						block
						class="mt-4 px-6 w-100"
            @click="request()"
					>
					<v-icon left dark>pan_tool</v-icon>
					<h3 >Request Drink!</h3>
					</v-btn>

        </v-container>

          <v-container v-else style="text-align:center;" class="d-flex flex-column align-items-center justify-content-center my-5">
            <Pulse class="py-5"/>
            <v-alert
                dense
                text
                type="success"
                class="mt-6"
              >
              Drink cart requested!
              </v-alert>

              <v-btn @click="cancel()" small>Cancel</v-btn>
          </v-container >
				</v-container>
		</v-card-text>
		</v-card>
  </v-flex>
</template>

<script>
import Beer from '$comp/misc/Beer'
import Bell from '$comp/misc/Bell'
import Pulse from '$comp/misc/Pulse'
import VueStar from 'vue-star'
import "animate.css"


import axios from 'axios'

export default {
  components: { Beer,VueStar , Pulse},
  data: () => ({
    name: "",
		showLogo: false,
    code: '',
    course: {},
    notFound: false,
    requested: false,
    position: {},
  }),
  methods: {
    success(data) {
      this.$store.dispatch('auth/saveToken', data)
      this.$store.dispatch('auth/setUser', data)
      this.$router.push({ name: 'index' })
    },
		UserType(v) {
			this.user_type = v;
		},
    getCourse(){
      axios.get("/api/course/get-by-code/" + this.code)
        .then(res =>{
          if (!res.data){
            this.notFound = true;
            return;
          }
          this.course = res.data;
        });
    },
    async request(){
      await this.getLocation();
      axios.post("/api/player", this.position)
        .then(res => {
            console.log(res);
        });

      this.$toast.success('Request sent for cart attendant');
      this.requested = true;
    },
    cancel(){
      this.$toast.error('Request Cancelled');
      this.requested = false;
    },
    getLocation(){
      const success = (position) => {
            const latitude  = position.coords.latitude;
            const longitude = position.coords.longitude;

            this.position = {
              latitude: latitude, longitude: longitude
            };

        };

        const error = (err) => {
            console.log(error)
        };
        navigator.geolocation.getCurrentPosition(success, error);
    }
  },
	mounted() {
		this.showLogo = true;
    this.code = this.$route.path.substring(1);
    this.getCourse();
	}
}
</script>

<style>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all 2.3s ease;
}
.slide-fade-leave-active {
  transition: all .1.8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(60px);
  opacity: 0;
}
</style>
