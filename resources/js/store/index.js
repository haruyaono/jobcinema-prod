import Vue from 'vue';
import Vuex from 'vuex';
import favourite from './modules/favourite';
import favouriteCount from './modules/favouriteCount';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        favourite, favouriteCount
    }
});
