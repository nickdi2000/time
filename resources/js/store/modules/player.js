import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/**
 * Initial player_state
 */
export const player_state = {
  player: null,
	player_id: window.localStorage.getItem('player_id')
}

/**
 * Mutations
 */
export const mutations = {
  [types.SET_PLAYER](player_state, { player }) {
    player_state.player = player
  },

  [types.SET_PLAYER_ID](player_state, { player_id }) {
    player_state.player_id = player_id
		console.log("playerid: " + player_state.player_id)
    window.localStorage.setItem('player_id', player_id)
  },

  [types.FETCH_PLAYER_FAILURE](state) {
    player_state.player_id = null
    window.localStorage.removeItem('player_id')
  }

}

/**
 * Actions
 */
export const actions = {

	savePlayerId({ commit }, payload) {
    commit(types.SET_PLAYER_ID, payload)
		console.log(payload);
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

  setPlayer({ commit }, payload) {
    commit(types.SET_PLAYER, payload)
  },

}

/**
 * Getters
 */
export const getters = {
  player: player_state => player_state.player,
  check: player_state => player_state.player !== null,
  player_id: player_state => player_state.player_id
}
