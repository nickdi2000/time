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
    		<h3>{{course.name}}</h3>
				<p v-html="this.$options.filters.address(course)"></p>
      </v-card-text>

    </v-card>
		  <v-card class="mb-2">
	      <v-card-text>
					<h3>Public Access Link</h3>
					<h2 class="py-3 font-weight-bold">{{url()}}</h2>
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
    //course: {},
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
    auth: 'auth/user',
		course: 'course/course'
  }),

  mounted() {
		console.log(this.course);
		this.user = Object.assign(this.user, this.auth);
    //this.getCourseData();


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
