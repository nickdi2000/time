<template>
  <v-content>
      <v-data-table
        v-if="!courseVisible"
        :headers="headers"
        :items="users"
        :items-per-page="5"
        class="elevation-1"
      >
        <template #item.email="{ item }">
          <a target="_blank" :href="`mailto:${item.email}`">
            {{ item.email }}
          </a>
        </template>

        <template #item.course.name="{ item }">
          <a
            href="javascript:void"
            v-if="courseId(item.course)"
            @click="showCourse(item.course)"
            >
            {{ getCourse(item.course) }}
          </a>
          <i v-else>No Course</i>
        </template>
     </v-data-table>

     <v-container v-else class="d-flex justify-content-center flex-column pt-0 mt-0">
       <CourseInfo  :course="currentCourse" />
       <div>
         <v-btn @click="courseVisible=false">Back</v-btn>
       </div>
     </v-container>

   </v-content>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import CourseInfo from './CourseInfo';

export default {
  props: ['users'],
  components: {CourseInfo},
  data: () => ({
		app_name: process.env.MIX_APP_NAME,
    currentCourse: {},
    courseVisible: false,
    headers: [
      {text: "Name", value: "name"},
      {text: "Email", value: "email"},
      {text: "Signed Up", value: "created_at"},
      {text: "Course", value: "course.name"}
    ]
  }),
  methods: {
    getUsers(){
      axios.get('/api/user/')
        .then(res => {
          console.log(res);
          this.users = res.data;
        })
    },
    showCourse(course){
      this.currentCourse = course;
      this.courseVisible = true;
    },
    getCourse(course){
      return course ? course.name : '--';
    },
    courseId(course){
      return course ? course.id : 0;
    }
  }
}
</script>
