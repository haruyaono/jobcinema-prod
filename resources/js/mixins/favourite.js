import { mapState } from 'vuex';
// import Processing from "./processing";

export default {
  // mixins: [Processing],
  props: ["jobid", "favourited"],
  created() {
    this.$store.commit('favourite/setFavourite', {
      show: this.jobFavourited ? true : false,
    })
  },

  computed: {
    ...mapState('favourite', {
      'showFlag': 'show'
    }),

    jobFavourited() {
      return this.favourited;
    }
  },
  methods: {
    save() {
      this.$store.dispatch('favourite/save', this.jobid);
    },
    unsave() {
      this.$store.dispatch('favourite/unsave', this.jobid);
    }
  }
};
