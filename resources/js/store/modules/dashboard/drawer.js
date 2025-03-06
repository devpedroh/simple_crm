const state = {
    drawer: true,
};

const mutations = {
    setDrawer(state, value) {
        state.drawer = value;
    },
};

const actions = {
    toggleDrawer({ commit }, value) {
        commit('setDrawer', value);
    },
};

const getters = {
    getDrawer: (state) => state.drawer,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
