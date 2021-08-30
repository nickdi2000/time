import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/**
 * Initial state
 */
export const state = {
  course: null,
}

/**
 * Mutations
 */
export const mutations = {
  [types.SET_COURSE](state, { course }) {
    state.course = course
  },

  [types.LOGOUT](state) {
    state.course = null
  },

  [types.FETCH_COURSE_FAILURE](state) {
    state.course = null
  },

}

/**
 * Actions
 */
 export const actions = {
  async fetchCourse({ commit }) {
    try {
      const { data } = await axios.get(api.path('user/my-course'))
      commit(types.SET_COURSE, data)
    } catch (e) {
      commit(types.FETCH_COURSE_FAILURE)
    }
  },

  setCourse({ commit }, payload) {
    commit(types.SET_COURSE, payload)
  },

  destroy({ commit }) {
    commit(types.LOGOUT)
  }
}

/**
 * Getters
 */
export const getters = {
  course: state => state.course
}
