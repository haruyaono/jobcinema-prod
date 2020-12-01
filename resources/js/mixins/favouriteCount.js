export default {
  props: ["count", "place"],

  created() {
    this.$store.commit('favouriteCount/setCount', {
      count: this.count
    })
  },

  computed: {
    showCount() {
      return this.$store.state.favouriteCount.count;
    },
    getPlace() {
      return this.place;
    }
  },
};
