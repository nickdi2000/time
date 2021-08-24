<template>
  <div>
    <h2 class="mb-4 primary--text headline">Your Golf Course</h2>

		<v-progress-circular
			v-if="Object.keys(course).length === 0"
      indeterminate
      color="primary"
    ></v-progress-circular>


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
			<h3>Address</h3>
				<vue-google-autocomplete
						id="g-map"
						classname="form-control"
						placeholder="Start typing"
						v-on:placechanged="getAddressData"
						class="form-control map"
				>
				</vue-google-autocomplete>
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
    course: {
    },
		loading: true,
  }),
	methods: {
		getData(){
			axios.get('/api/my-course')
				.then(res => {
					this.course = res.data;
					this.loading = false;
				});
		},
		getAddressData(v){
			console.log(v);
		}
	},

  mounted() {
    this.getData();
  }
}
</script>

<style scoped>

.map{
	width: 100%;
}

</style>
