import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/**
 * Initial state
 */
export const state = {
  user: null,
  token: window.localStorage.getItem('token'),
	player:null,
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
	  },


	  [types.FETCH_PLAYER_FAILURE](state) {
	    state.player_id = null
	    window.localStorage.removeItem('player_id')
	  },

		/*ADMINS*/
  [types.SET_USER](state, { user }) {
    state.user = user
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null
    window.localStorage.removeItem('token')
  },

  [types.FETCH_USER_FAILURE](state) {
    state.user = null
    window.localStorage.removeItem('token')
  },

  [types.SET_TOKEN](state, { token }) {
    state.token = token
    window.localStorage.setItem('token', token)
  }
}

/**
 * Actions
 */
export const actions = {

	/* PLAYER */

	savePlayerId({ commit }, payload) {
    commit(types.SET_PLAYER_ID, payload)
		commit(types.SET_PLAYER_STATUS, payload)
		console.log(payload);
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


	/* ADMINS */
  saveToken({ commit }, payload) {
    commit(types.SET_TOKEN, payload)
  },

  async fetchUser({ commit }) {
    try {
      const { data } = await axios.get(api.path('me'))
      commit(types.SET_USER, data)
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  setUser({ commit }, payload) {
    commit(types.SET_USER, payload)
  },

  async logout({ commit }) {
    await axios.post(api.path('logout'))
    commit(types.LOGOUT)
  },

  destroy({ commit }) {
    commit(types.LOGOUT)
  }
}

/**
 * Getters
 */
export const getters = {
  user: state => state.user,
  check: state => state.user !== null,
  token: state => state.token
}
