const state = {
    user: '',
    token: '',
};

const mutations = {
    setUser(state, value) {
        state.user = value;
    },
    setUserToken(state, value) {
        state.token = value;
    },
};

const actions = {

};

const getters = {
    getUser: (state) => state.user,
    getToken: (state) => state.token,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
