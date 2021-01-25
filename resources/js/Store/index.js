import {isLoggedIn} from "./utils";

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        isLoggedIn: false,
        user: {}
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
        setLoggedIn(state, payload) {
            state.isLoggedIn = payload;
        }
    },
    actions: {
        async loadUser({commit, dispatch}) {
            if (isLoggedIn) {
                try {
                    const user = (await axios.get("/api/user")).data;
                    commit("setUser", user);
                    commit("setLoggedIn", true);
                } catch (error) {
                    console.log(error)
                }
            }
        }
    },
    getters: {
        isLoggedIn: state => {
            return state.isLoggedIn;
        },
        user: state => {
            return state.user;
        }
    }
});

export default store;