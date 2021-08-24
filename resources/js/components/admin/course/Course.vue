<template>
  <div>
    <h2 class="mb-4 primary--text headline">Your Golf Course</h2>

		<v-card v-if="Object.keys(course).length === 0" class="my-4">
		<v-progress-circular
      indeterminate
      color="primary"
    ></v-progress-circular>
		</v-card>


    <v-card v-else class="mb-2">
      <v-card-text>
        <v-text-field
          label="Golf Course"
          v-model="course.name"
          filled
          readonly
          hide-details
          class="mb-4"
        ></v-text-field>

				  <v-text-field
	          label="City"
	          v-model="course.city"
	          filled
	          readonly
	          hide-details
	          class="mb-4"
	        ></v-text-field>





      </v-card-text>

    </v-card>

		<v-card>
			<v-card-text>
			<h3>Course Address</h3>
				<vue-google-autocomplete
						id="g-map"
						class="form-control form-control-lg my-3"
						placeholder="Find Address.."
						v-on:placechanged="getAddressData"
				>
				</vue-google-autocomplete>

				 <v-alert
				 v-if="course.address"
		      border="left"
		      colored-border
		      color="deep-purple accent-4"
		      elevation="2"
					class="mt-4"
		    >
				 <p v-html="this.$options.filters.address(course.address)"></p>

				 <v-btn color="info" @click.prevent="saveAddress()">Use This Address <v-icon>check</v-icon></v-btn>
				</v-alert>

				<v-alert
						class="mt-4"
						border="left"
			      colored-border
			      type="warning"
			      elevation="2">
					The golf course address is not yet set-up
				</v-alert>
			</v-card-text>
		</v-card>


  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import VueGoogleAutocomplete from 'vue-google-autocomplete'


export default {
	components: {VueGoogleAutocomplete},
  data: () => ({
    course: {},
		loading: true,
		user: {}
  }),
	methods: {
		getCourseData(){
			axios.get('/api/user/my-course')
				.then(res => {
					this.course = res.data;
					this.loading = false;
				});
		},
		getAddressData(v){
			console.log(v);
			this.course.address = v;
		},
		saveAddress(){
				axios.put('/api/course/' + this.course.id, this.course.address)
					.then(res => {
						this.$toast.success(res.data.message);
					}).error(err => {
						console.log(err);
					});
		}
	},
	computed: mapGetters({
    auth: 'auth/user'
  }),

  mounted() {
		this.user = Object.assign(this.user, this.auth);
    this.getCourseData();


  }
}
</script>

<style scoped>



</style>
