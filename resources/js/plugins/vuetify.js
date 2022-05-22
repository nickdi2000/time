import Vue from 'vue'
import Vuetify, { VSnackbar, VBtn, VIcon } from 'vuetify/lib'
import VuetifyToast from 'vuetify-toast-snackbar'
import '@mdi/font/css/materialdesignicons.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

const theme = {
		primary: '#1e88e5',
    info: '#1e88e5',
    success: '#21c1d6',
    accent: '#fc4b6c',
    default: '#563dea'
}

const sleek = {
	primary: '#116466',
	secondary: '#2C3531', //darkgreen
	success_: '#D9B08C',
	success: '#21c1d6',
	accent: 'FFCB9A',
	default: 'D1E8E2',
}

const sandstone = {
		primary_: '#325d88',
		primary: '#264728',
		secondary: '#8e8c84',
    info: '#29abe0',
    success: '#93c54b',
    accent: '#f47c3c',
		warning: '#f47c3c',
    default: '#6f8c4a',
		danger: '#d9534f',
}

const course = {
	primary_: '#86af49',
	primary: '#1A237E',
	default: '#b2ad7f'
}


Vue.use(Vuetify, {
  components: {
    VSnackbar,
    VBtn,
    VIcon
  }
})
Vue.use(VuetifyToast)

export default new Vuetify({
    theme: {
        themes: {
					dark: course,
          light: sandstone,
        },
				dark: true,
      },
			icons: {
		    iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
		  },
});
