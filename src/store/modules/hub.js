import api from '../../api'
import * as types from '../mutation-types'

// initial state
const state = {
  error: null,
  notice: null,
  loading: true,
  loading_progress: 0,
  audio: null,
  logo: null,
}

// getters
const getters = {
  isLoading: state => state.loading_progress < 100,
  loadingProgress: state=> state.loading_progress,
  loadingIncrement: state => { return 100 / SETTINGS.LOADING_SEGMENTS },
  audio: state => state.audio,
  logo: state => state.logo,
}

// actions
const actions = {
  loadLogo({commit}){
    axios.get(window.SETTINGS.API_BASE_PATH + 'media?slug=logo').then(response=>{
      // console.log(response.data)
      commit('loadLogo',response.data[0].guid.rendered)
    })
  }
}

// mutations
const mutations = {
  [types.INCREMENT_LOADING_PROGRESS] (state, val) {
    state.loading_progress = Math.min(state.loading_progress + getters.loadingIncrement(), 100)
  },
  [types.RESET_LOADING_PROGRESS] (state) {
    state.loading_progress = 0
  },
  setAudio(state, autioURL){
    state.audio = autioURL;
  },
  loadLogo(state, logo){
    state.logo = logo;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
