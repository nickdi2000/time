import 'babel-polyfill'
import Vue from 'vue'

import router from '~/router/index'
import store from '~/store/index'
import App from '$comp/App'
import '~/plugins/index'
import vuetify from '~/plugins/vuetify'
import * as VueGoogleMaps from "vue2-google-maps"

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyAu2LdngQaedWU8hJx3L80WS_hqEYbDw7A",
    libraries: "places"
  }
});

Vue.filter("address", function(address) {
	// call like: <p v-html="this.$options.filters.address(course.address)"></p>
    let addr_string = `<b>Address: </b> ${address.street_number} ${address.locality}
			<br/> <b>Country: </b> ${address.country}
			<br/> <b>Postal: </b> ${address.postal_code}
			<br/> (lon: ${address.longitude}, lat: ${address.latitude})
			`;

    if (address.name) {
        addr_string = `${address.name}: ${addr_string}`;
    }

    return addr_string;
});


export const app = new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
