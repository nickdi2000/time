<template>
  <v-flex sm8 md6 lg4 >
		<v-container v-if="loading" class="w-100 d-flex" fluid justify-center align-center>
		<v-progress-circular
			class="my-4 pb-4 pt-1"
      indeterminate
      color="purple"
    ></v-progress-circular>
		</v-container>

		<div v-else>
				<v-container  class="w-100 d-flex" fluid justify-center align-center>
						<transition name="slide-fade">
							<v-img v-if="showLogo"
              src="/images/beer-logo.png"
              max-width="100"
              v-on:dblclick="dev=true"
              ></v-img>
						</transition>
				</v-container>



		    <v-card class="mx-auto">
		      <v-toolbar dark color="primary" flat>
		        <v-toolbar-title>{{ $app_url }}/{{ code }}</v-toolbar-title>
		      </v-toolbar>
					<v-card-text >
		        <v-container v-if="notFound">
		          <v-alert
		           border="right"
		           colored-border
		           type="warning"
		           elevation="2"
		         >
		          No CaddySnack profile exists for this course.. <br/><br/>
		          Suggest that they sign up at <b>CaddySnack.ca/register</b>
		         </v-alert>
		        </v-container>

						<v-container style="text-align:center;" v-else fluid class="d-flex flex-column align-items-center justify-content-center">
		         <span v-if="!requested">
               <small>Welcome to</small>
		             <h2 class="animate__animated animate__bounce"> {{ course.name }} </h2>
            </span>
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
								color="success"
								large
								block
								class="mt-4 px-6 w-100"
		            @click="request()"
							>
							<v-icon left dark>notifications</v-icon>
							<h3 >Request Drink!</h3>
							</v-btn>

		        </v-container>

		          <v-container v-else style="text-align:center;" class="d-flex flex-column align-items-center justify-content-center my-5">
		            <Pulse class="py-4" />

                <div class="column align-items-end mt-4" style="height: 100%;" fill-height>
                    <v-btn @click="cancel()" color="error" outlined x-small style="opacity:0.7">
                      <v-icon left small>remove_circle</v-icon>
                      Cancel
                    </v-btn>
                </div>
                  <div v-if="!edit">

    		            <v-alert
    		                dense
    		                text
    		                type="success"
    		                class="mt-6"
    		              >
    		              <strong>DRINK CART REQUESTED!</strong>
    		              </v-alert>


                      <div v-if="player" class="mb-4">
                        Your Name: <br/>
                        <h2>
                          {{ player.name }}
                        </h2>
                        <v-btn
                          small
                          raised
                          color="accent"
                          @click="edit=true"
                          class="my-2"
                          >
                          More Options <v-icon right>expand_more</v-icon>
                        </v-btn>
                      </div>
                </div>

                <transition name="fade" v-else>
                  <EditPlayer :player="player" @hide-edit="edit=false" />
                </transition>

		          </v-container >
						</v-container>
				</v-card-text>
				</v-card>
				<v-card v-if="dev" class="py-4 px-4 my-4">
					CourseID: {{course.id}}
					<br/>Player id: {{ player_id }}<br/>
					player status: {{ player_status }}<br/>
          Player Data: {{ player }}
				</v-card>

			</div>
		 </v-flex>
</template>

<script>
import Beer from '$comp/misc/Beer'
import Bell from '$comp/misc/Bell'
import Pulse from '$comp/misc/Pulse'
import VueStar from 'vue-star'
import "animate.css"
import { mapGetters } from 'vuex'
import EditPlayer from './EditPlayer';

import axios from 'axios'

export default {
  components: { Beer,VueStar , Pulse, EditPlayer},
  data: () => ({
    edit: false,
		dev: false,
    pulseSize: 1.3,
    name: "",
		showLogo: false,
    code: '',
    course: {},
    notFound: false,
    requested: false,
    player: {},
		loading: true,
  }),
  methods: {
    getCourse(){
      axios.get("/api/course/get-by-code/" + this.code)
        .then(res =>{
					this.loading = false;
          if (!res.data){
            this.notFound = true;
            return;
          }
          if(!res.data.active){
            this.$router.push({name: 'find-course', params: {error: 'not-active'}});
          }
          console.log('get course', res.data);
          this.course = res.data;
					this.player.course_id = res.data.id;
					this.$store.dispatch('player/setPlayerCourseId', {player_course_id: res.data.id});
        });
    },
    async request(){
			this.loading = true;

      let audio = new Audio('/sounds/confirm.wav');
      audio.play();
			const coords = await this.getLocation();
			//console.log("coords recieved", coords);
			this.player.latitude = coords.latitude;
			this.player.longitude = coords.longitude;
			this.storePlayer();

    },
		storePlayer(){
        if(this.player_id){
          this.player.status_id = 1;
          axios.put("/api/player/" + this.player_id, this.player)
            .then(res => {
                this.player = res.data.data;
                this.$store.dispatch('player/setPlayerStatus', {status_id: 1});
                this.requested = true;
                this.$toast.success('Request re-sent');

            });
        }else{
          axios.post("/api/player", this.player)
	        .then(res => {
              console.log('new player', res.data);
              this.player = res.data.data;
							this.requested = true;
							this.$store.dispatch('player/savePlayerId', res.data.data);
							this.$toast.success('Request sent for cart attendant');
	        });
        }
		},
    cancel(){
      this.$toast.error('Request Cancelled');
      this.requested = false;

			let status = {status_id: 0};

			axios.put("/api/player/" + this.player_id, status)
				.then(res => {
					console.log(res);
					this.$store.dispatch('player/setPlayerStatus', status);
				})


    },
    async getLocation(){
			return new Promise((resolve, reject) => {
				console.log('getLocation');
	      	let lat = 0
	        let long = 0
					let app = this
	        if(navigator.geolocation) {
	            navigator.geolocation.getCurrentPosition(pos => {
								this.loading = false;
			          resolve(pos.coords);
			        }, err => {
								this.loading = false;
			          reject(err);
								this.$toast.error(err.message);
			        });
	        }
			});
    },
    fetchPlayer(){
      axios.get('/api/player/' + this.player_id)
        .then(res => {
          console.log('fetchedplaye Data', res.data);
          this.player = res.data;
        });
    }
  },
	created () {
		if(this.player_status == 1){
			this.requested = true;
		}
	},
	mounted() {
		this.showLogo = true;
    this.code = this.$route.path.substring(1);
    this.getCourse();

    if(this.player_id){
      this.fetchPlayer();
    }
	},
  computed: mapGetters({
    player_id: 'player/player_id',
    player_status: 'player/player_status',
  }),
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

.colorizer {
	background: linear-gradient(-45deg, #ffffff, #e73c7e, #23a6d5, #ffffff);
	background-size: 400% 400%;
	animation: gradient 15s ease infinite;
	height: 100vh;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

</style>
