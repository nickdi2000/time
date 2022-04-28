import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/**
 * Initial state
 */
export const state = {
  player_id: window.localStorage.getItem('player_id'),
	player_status: window.localStorage.getItem('player_status'),
	player_course_id: window.localStorage.getItem('player_course_id'),
	player_course_data: window.localStorage.getItem('player_course_data'),
	player_data: window.localStorage.getItem('player_data')

}

/**
 * Mutations
 */
export const mutations = {

	  [types.SET_PLAYER_ID](state, { id }) {
	    state.player_id = id
	    window.localStorage.setItem('player_id', id)
	  },

	  [types.SET_PLAYER_STATUS](state, { status_id }) {
	    state.player_status = status_id
	    window.localStorage.setItem('player_status', status_id)
	  },

		[types.SET_PLAYER_COURSE_ID](state, { player_course_id }) {
	    state.player_course_id = player_course_id
	    window.localStorage.setItem('player_course_id', player_course_id)
	  },

		[types.SET_PLAYER_DATA](state, { player_data }) {
      console.log("storing playerdata: ", player_data);
	    state.player_data = player_data
	    window.localStorage.setItem('player_data', JSON.stringify(player_data))
	  },

		[types.SET_PLAYER_COURSE_DATA](state, player_course_data ) {
	    state.player_course_data = player_course_data
	    window.localStorage.setItem('player_course_data', JSON.stringify(player_course_data))
	  },


	  [types.FETCH_PLAYER_FAILURE](state) {
	    state.player_id = null
	    window.localStorage.removeItem('player_id')
	  },

    [types.PLAYER_LOGOUT](state) {
      state.player_id = null
      state.player_status = null
      //state.player_course_id = null
      window.localStorage.removeItem('player_id')
      window.localStorage.removeItem('player_status')
      window.localStorage.removeItem('player_data')
      //window.localStorage.removeItem('player_course_id')
    },

}

/**
 * Actions
 */
export const actions = {

	/* PLAYER */

  // not used currently
  /*
  setPlayer({ commit }, payload) {
    console.log("sePlayer payload", payload);
    commit(types.SET_PLAYER_DATA, payload);
  },
  */

	savePlayerId({ commit }, payload) {
    commit(types.SET_PLAYER_ID, payload)
		commit(types.SET_PLAYER_STATUS, payload)
		// console.log("payload", payload);
  },
	setPlayerStatus({ commit }, payload) {
    commit(types.SET_PLAYER_STATUS, payload)
  },
	setPlayerCourseId({ commit }, payload) {
	  commit(types.SET_PLAYER_COURSE_ID, payload)
	},
	setPlayerCourseData({ commit }, payload) {
	  commit(types.SET_PLAYER_COURSE_DATA, payload)
	},
	setPlayerData({ commit }, payload) {
    console.log("payload: ", payload);
	  commit(types.SET_PLAYER_DATA, payload)
	},

	updatePlayerField({ commit }, payload) {
    let data = state.player_data ? stat.player_data : {};
    let field = payload[0];
    let value = payload[1];
    data.field = value;
	  commit(types.SET_PLAYER_DATA, data)
	},

  /*
	  async fetchPlayer({ commit }) {
	    try {
	      const { data } = await axios.get('/me-player/' + state.player_id)
	      commit(types.SET_PLAYER_DATA, data.data)
        console.log('fetching: ', data.data);
	    } catch (e) {
				commit(types.FETCH_PLAYER_FAILURE)
	      console.log("failed to fetch player nd");
	    }
	  },
    */

    destroy({ commit }) {
      commit(types.PLAYER_LOGOUT)
    },

}

/**
 * Getters
 */
export const getters = {
	  player_id: state => state.player_id,
		player_status: state => state.player_status,
  	player_course_id: state =>('player_course_data' in state) ? state.player_course_data.id : 0,
  	player_course_data: state => state.player_course_data,
  	player_data: state => JSON.parse(state.player_data)
}
