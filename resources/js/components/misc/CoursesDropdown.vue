<template>
	<div>
		<br/>selected: {{ selected_course.id }}
		<v-combobox
			v-model="selected_course"
			label="Golf Course"
			:items="courses"
			:item-value="name"
			item-text="name"
			auto-select-first
			@input="$emit('update-course', selected_course.id)"
		>
		</v-combobox>
	</div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {

  data: () => ({
		courses: [],
		selected_course: {},
		name: "",
  }),

  methods: {
		getCourses(){
			let url = "/api/guest-course";
			axios.get(url)
				.then(res => {
					this.courses = res.data;
				})
				.catch(err => {
            this.handleErrors(err.response.data.errors)
          })
		},

  },
	mounted() {
		this.getCourses();

	},

}
</script>
