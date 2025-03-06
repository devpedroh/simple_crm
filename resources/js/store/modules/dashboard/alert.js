const state = {
    alert: false,
    alertData: {
        title: '',
        type: '',
        text: '',
        redirect: '',
        canClose: false,
        timeout: 2000,
        blackdrop: false,
    },
};

const mutations = {
    setAlert(state, { value, data }) {
        state.alertData.title = data?.title || '';
        state.alertData.type = data?.type || '';
        state.alertData.text = data?.text || '';
        state.alertData.redirect = data?.redirect || '';
        state.alertData.canClose = data?.canClose || false;
        state.alertData.timeout = data?.timeout || 2000;
        state.alertData.blackdrop = data?.blackdrop || false;

        state.alert = value;
    },
};

const actions = {

};

const getters = {
    getAlert: (state) => state.alert,
    getAlertData: (state) => state.alertData,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
