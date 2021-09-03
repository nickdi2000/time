import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/**
 * Initial state
 */
export const state = {
  player_id: window.localStorage.getItem('player_id'),
	player_status: window.localStorage.getItem('player_status'),
	player_course_id: window.localStorage.getItem('player_course_id')
}

/**
 * Mutations
 */
export const mutations = {

	/* PLAYERS */
	  [types.SET_PLAYER](state, { player }) {
	    state.player = player
	  },

	  [types.SET_PLAYER_ID](state, { id }) {
	    state.player_id = id
	    window.localStorage.setItem('player_id', id)
	  },

	  [types.SET_PLAYER_STATUS](state, { status_id }) {
	    state.player_status = status_id
	    window.localStorage.setItem('player_status', status_id)
	  },

		[types.SET_PLAYER_COURSE_ID](state, { id }) {
	    state.player_course_id = id
	    window.localStorage.setItem('player_course_id', id)
			console.log("setting placyer course id: " + id);
	  },


	  [types.FETCH_PLAYER_FAILURE](state) {
	    state.player_id = null
	    window.localStorage.removeItem('player_id')
	  },

}

/**
 * Actions
 */
export const actions = {

	/* PLAYER */

	savePlayerId({ commit }, payload) {
    commit(types.SET_PLAYER_ID, payload)
		commit(types.SET_PLAYER_STATUS, payload)
		// console.log("payload", payload);
  },
	setPlayerStatus({ commit }, payload) {
    commit(types.SET_PLAYER_STATUS, payload)
  },
	setPlayerCourseId({ commit }, course_id) {
	  commit(types.SET_PLAYER_COURSE_ID, course_id)
	},

	  async fetchPlayer({ commit }) {
	    try {
	      const { data } = await axios.get(api.path('player'))
	      commit(types.SET_PLAYER, data)
				console.log('fetchplayer?');
	    } catch (e) {
				commit(types.FETCH_PLAYER_FAILURE)
	      console.log("failed to fetch player nd");
	    }
	  },

}

/**
 * Getters
 */
export const getters = {
	  player_id: state => state.player_id,
		player_status: state => state.player_status,
  	player_course_id: state => state.player_course_id,
}
