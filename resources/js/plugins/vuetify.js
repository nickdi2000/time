import Vue from 'vue'
import Vuetify, { VSnackbar, VBtn, VIcon } from 'vuetify/lib'
import VuetifyToast from 'vuetify-toast-snackbar'


const theme = {
		primary: '#1e88e5',
    info: '#1e88e5',
    success: '#21c1d6',
    accent: '#fc4b6c',
    default: '#563dea'
}

const sleek = {
	primary: '#116466',
	secondary: '#2C3531',
	success_: '#D9B08C',
	success: '#21c1d6',
	accent: 'FFCB9A',
	default: 'D1E8E2',
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
          dark: sleek,
          light: sleek,
        },
      }
});
