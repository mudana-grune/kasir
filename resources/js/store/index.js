import Vue from "vue";
import Vuex from 'vuex';
Vue.use(Vuex);
export default new Vuex.Store({
	state: {
		notification: {
			text: '',
			isOpen: false,
			color: 'success',
			multiLine: false,
		},
	},
    mutations: {
        setNotification(state, notif) {
            state.notification = notif;
          },
          closeNotification(state) {
            state.notification.isOpen = false;
          },
    },
    actions: {},
    getters: {}
})
