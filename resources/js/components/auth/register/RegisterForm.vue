<template>

	<v-form v-if="form.user_type == ''">
			<v-row
			v-for="user in user_types"
	    align="center"
	    class="py-2"

	  >

				<v-btn
				block
				elevation="2"
				color="default"
				justify="space-around"
				x-large
				@click="form.user_type = user.id"
				>
					REGISTER AS {{user.name}}
				</v-btn>
		</v-row>
	</v-form>

  <v-form v-else ref="form" @submit.prevent="submit" lazy-validation v-model="valid">
    <v-alert type="warning" v-for="(error, index) in errors" :key="index">
      {{ error[0] }}
    </v-alert>

    <v-text-field
      label="Name (optional)"
      v-model="form.name"
      :error-messages="errors.name"
      :rules="[rules.required('name')]"
      :disabled="loading"
      @input="clearErrors('name')"
    ></v-text-field>

		<v-combobox
			v-model="form.golf_course"
			label="Golf Course"
			:items="courses"
			:item-value="name"
			item-text="name"
			auto-select-first
      required
		>
		</v-combobox>

    <v-text-field
      :label="labels.email"
      v-model="form.email"
      type="email"
      :error-messages="errors.email"
      :rules="[rules.required('email')]"
      :disabled="loading"
      @input="clearErrors('email')"
    ></v-text-field>

    <v-text-field
      :label="labels.password"
      v-model="form.password"
      :append-icon="passwordHidden ? 'visibility_off' : 'visibility'"
      @click:append="() => (passwordHidden = !passwordHidden)"
      :type="passwordHidden ? 'password' : 'text'"
      :error-messages="errors.password"
      :disabled="loading"
      :rules="[rules.required('password')]"
      hint="At least 6 characters"
      @input="clearErrors('password')"
    ></v-text-field>

    <v-text-field
      :label="labels.password_confirmation"
      v-model="form.password_confirmation"
      :type="passwordHidden ? 'password' : 'text'"
      :error-messages="errors.password_confirmation"
      :disabled="loading"
      :rules="[rules.required('password_confirmation')]"
      @input="clearErrors('password')"
    ></v-text-field>

    <v-layout row class="mt-4 mx-0">
      <v-spacer></v-spacer>
      <v-btn
        text
        :disabled="loading"
        :to="{ name: 'login' }"
        color="grey darken-2"
        exact
      >
        Back to login
      </v-btn>

      <v-btn
        type="submit"
        :loading="loading"
        :disabled="loading || !valid"
        color="primary"
        class="ml-4"
      >
        Register
      </v-btn>
    </v-layout>
			<button @click.prevent="fakeData">*</button>
  </v-form>

</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import Form from '~/mixins/form'


export default {
  mixins: [Form],

  data: () => ({
    passwordHidden: true,
    errors: [],
    form: {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
			user_type: '',
			golf_course: '',
    },
		  form_prefilled: {
	      name: 'roger',
	      email: 'roger@gmail.com',
	      password: 'password',
	      password_confirmation: 'password',
				user_type: '2',
				golf_course: 'Test Course',
	    },
			user_types: [
				{id: 0, name: 'BEVERAGE CART ATTENDANT'},
				{id: 1, name: 'COURSE MANAGEMENT'},
			],
		courses: []
  }),

  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        this.loading = true
        axios.post(api.path('register'), this.form)
          .then(res => {
            this.$toast.success('You have been successfully registered!')
            this.$emit('success', res.data)
          })
          .catch(err => {
            this.handleErrors(err.response.data.errors);
            this.errors = err.response.data.errors;
          })
          .then(() => {
            this.loading = false
          })
      }
    },
		getCourses(){
			let url = "/api/course";

			axios.get(url)
				.then(res => {
					this.courses = res.data;
				})
				.catch(err => {
            this.handleErrors(err.response.data.errors)
          })
		},
		fakeData(){
			this.form = this.form_prefilled;
		}
  },
	mounted() {
		this.getCourses();

	}
}
</script>
