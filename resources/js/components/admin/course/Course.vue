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

		<v-card class="my-4">
			<v-card-text>
			<h3>Course Address</h3>
				<vue-google-autocomplete
						id="g-map"
						class="form-control form-control-lg my-3"
						placeholder="Start Typing...."
						v-on:placechanged="getAddressData"
						v-model="query"
				>
				</vue-google-autocomplete>

				 <v-alert
				 v-if="course && course.country"
		      border="left"
		      colored-border
		      color="deep-purple accent-4"
		      elevation="2"
					class="mt-4"
		    >
				 <p v-html="this.$options.filters.address(course)"></p>

				 <div v-if="changed">
					 <v-btn
						color="primary"
						@click.prevent="saveAddress()"
						>
						Use This Address
						<v-icon>save</v-icon>
					</v-btn>

					<v-btn color="light" @click.prevent="cancel()">Cancel</v-btn>
				</div>

				</v-alert>

				<v-alert
						class="mt-4"
						border="left"
			      colored-border
			      type="warning"
			      elevation="2"
						v-if="!course.validAddress"
						>
					The golf course address is not yet set-up
				</v-alert>
			</v-card-text>
		</v-card>

		  <v-card class="mb-2">
	      <v-card-text>
					<h3>Public Access Link</h3>
					<h2 class="py-3 font-weight-bold">{{url()}}</h2>

						  <v-text-field
			          label="CODE"
								id="code"
			          v-model="course.code"
			          filled
			          hide-details
			          class="mb-4"
								@input="(val) => (course.code = course.code.toUpperCase())"
			        ></v-text-field>
							<div class="d-flex flex-row-reverse">
								<v-btn color="primary" @click="saveAddress()" v-if="showCodeSaveBtn"> Save <v-icon>save</v-icon></v-btn>
							</div>

							<v-alert class="d-flex justify-center">
									<vue-qrcode :scale="8" :value="'https://caddysnack.ca/' + course.code" />
							</v-alert>
							<p class="font-weight-thin">Golfers may navigate to your unique url ({{url()}}), or scan this QR code.  Remember that if you change your code, the QR Code will change as well.</p>

				</v-card-text>
			</v-card>





  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import VueGoogleAutocomplete from 'vue-google-autocomplete'
import VueQrcode from 'vue-qrcode'

export default {
	components: {VueGoogleAutocomplete, VueQrcode},
  data: () => ({
    course: {},
		loading: true,
		user: {},
		query: '',
		changed: false,
		showCodeSaveBtn: false,
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
			let id = this.course.id;
			this.course = v;
			this.course.id = id;
			this.changed = true;
		},
		saveAddress(){
				axios.put('/api/course/' + this.course.id, this.course)
					.then(res => {
						this.$toast.success(res.data.message);
						this.changed = false;
						this.getCourseData();
					}).error(err => {
						console.log(err);
					});
		},
		url(){
			return "CaddySnack.ca/" + (this.course.code ? this.course.code : '');
		},
		cancel(){
			this.getCourseData();
			this.changed = false;
		}
	},
	computed: mapGetters({
    auth: 'auth/user'
  }),

  mounted() {
		this.user = Object.assign(this.user, this.auth);
    this.getCourseData();


  },
	watch: {
		"course.code": function(oldVal, newVal){
			if(oldVal != newVal && (typeof newVal != 'undefined')){
				this.showCodeSaveBtn = true;
			}

		}
	}
}
</script>

<style scoped>


</style>
