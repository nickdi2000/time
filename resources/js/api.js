import Axios from 'axios'
import router from './router'
//import store from './store'

  var baseURL = process.env.MIX_APP_URL + "/api/";

  const axios = Axios.create({
      baseURL: baseURL
  });
  console.log('enver', baseURL);

  const DEBUG = process.env.VUE_APP_ENV !== "production";

axios.interceptors.request.use(request => {
    const api_token = localStorage.getItem('token');

    if (api_token) {
        request.headers.Authorization = 'Bearer ' + api_token;
    }

    return request;
});

axios.interceptors.response.use((response,metrics) => {

			return response;
		},
		error => {
    //if (error.response.status === 401) {
    if (error) {
        //localStorage.removeItem('token');
        //store.commit('unsetUser');
        console.log("Error from API");
        if(router.currentRoute.path != '/'){
          router.push('/');
        }

    }

    return error.response;
});


export default {
     'getApiToken': async function (email, password) {
        const response = await axios.post('auth/token', {
            'email': email,
            'password': password,
            'device_name': 'webapp'
        });

        return response.data;
    },

    getUser: async function () {
        const response = await axios.get('auth/user');

        return response.data.data;
    },
    //login is actually register because its single-use game
    login: async function (data) {
      const response = await axios.post('register', data);
      return response.data;
    },
    saveCourseData: async function (data){
      const response = await axios.put('course/' + data.id, data);
      console.log("api res: ", response);
			//this.$toast.success(res.data.message);
      return response.data;
    },
    getCourseData: async function (id) {
      //const response = await axios.post('register', data);
      //return response.data;
      console.log("getting courso");
    },



};
