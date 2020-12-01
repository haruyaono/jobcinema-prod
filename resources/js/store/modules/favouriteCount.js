const state = {
    count: 0
}

const mutations = {
    setCount(state, { count }) {
        state.count = count || 0;
    }
}

export default {
    namespaced: true,
    state,
    mutations,
};
