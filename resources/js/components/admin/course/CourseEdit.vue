<template>
  <div>
    <h2 class="mb-4 primary--text headline">Edit Profile</h2>

    <v-card>
      <v-card-text>
        <v-text-field
          label="Golf Course"
          v-model="user.name"
          filled
          readonly
          hide-details
          class="mb-4"
        ></v-text-field>

      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    course: {
    }
  }),
	methods: {
		getData(){
			alert('hello');
		}
	},

  mounted() {
    getData();
  }
}
</script>
