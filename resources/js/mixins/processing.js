export default {
  data() {
    return {
      processing: false
    }
  },
  methods: {
    startProcessing: function () {
      this.processing = true
    },
    endProcessing: function () {
      this.processing = false
    },
    isProcessing: function () {
      return this.processing
    }
  }
}
