const state = {
    show: false,
}

const mutations = {
    setFavourite(state, { show }) {
        state.show = show || false;
    }
}

const actions = {
    save({ commit }, jobid) {
        axios
            .post("/keeplist/save/" + jobid)
            .then(response => {
                if (response.data.fav_save_status == 1) {
                    commit('setFavourite', { 'show': true });
                    commit('favouriteCount/setCount', { 'count': response.data.count }, { root: true });
                    alert("お仕事情報を保存しました。");
                } else {
                    alert("アイテムがすでに存在");
                }
            })
            .catch(
                error => {
                    console.log('err:', error);
                })
        // .finally(() => );
    },
    unsave({ commit }, jobid) {
        axios
            .post("/keeplist/unsave/" + jobid)
            .then(response => {
                if (response.data.fav_del_status == 1) {
                    commit('setFavourite', { 'show': false });
                    commit('favouriteCount/setCount', { 'count': response.data.count }, { root: true });
                    alert("削除しました。");
                } else {
                    alert("削除するアイテムなし");
                }
            })
            .catch(
                error => {
                    console.log('err:', error);
                })
        // .finally(() => );
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
