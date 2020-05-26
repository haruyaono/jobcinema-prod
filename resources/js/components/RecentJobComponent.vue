<template>
  <div id="recent-joblist">
    <div class="box-title">
      <h3>
        <i class="far fa-clock font-yellow mr-2 h4"></i>最近見た求人
      </h3>
    </div>
    <div class="loader" v-if="loading">Loading</div>
    <ul class="box-wrap cf" v-if="show">
      <li class="wrap-items" v-for="item in limitCount" v-bind:job="item" v-bind:key="item.id">
        <a :href="'/jobs/' + item.id">
          <div class="wrap-img">
            <img v-if="env == 'local'" :src="item.job_img" />
            <img v-else :src="baseurl + item.job_img" />
          </div>
          <div class="wrap-text">
            <p>勤務先: {{item.job_office | truncate(9)}}</p>
            <p>職種: {{item.job_type | truncate(10)}}</p>
            <p>給与: {{item.job_hourly_salary | truncate(10)}}</p>
          </div>
        </a>
      </li>
    </ul>
    <p v-if="itemflag">閲覧した求人は現在ありません。</p>
  </div>
</template>

<script>
import isMobile from "ismobilejs";
export default {
  headers: {
    "X-CSRF-TOKEN": document.getElementsByName("csrf-token")[0].content
  },
  props: ["job"],
  data() {
    return {
      show: false,
      loading: true,
      items: [],
      itemflag: false,
      isSmartPhone: isMobile.phone,
      env: document.getElementById("env_input").value,
      baseurl: document.getElementById("s3_url_input").value
    };
  },

  mounted: function() {
    this.load();
  },
  methods: {
    load: function() {
      var self = this;
      axios
        .post("/jobs/ajax_history_sheet_list")
        .then(function(res) {
          if (res.data != "") {
            self.items = res.data;
            self.show = true;
            self.loading = false;
            self.itemflag = false;
          } else {
            self.show = false;
            self.loading = false;
            self.itemflag = true;
          }
        })
        .catch(function(error) {
          self.show = false;
          self.loading = false;
          self.itemflag = true;
        });
    }
  },
  computed: {
    limitCount() {
      if (this.isSmartPhone) {
        return this.items.slice(0, 3);
      } else {
        return this.items.slice(0, 5);
      }
    }
  },
  filters: {
    truncate: function(value, length, omission) {
      var length = length ? parseInt(length, 10) : 20;
      var ommision = omission ? omission.toString() : "";

      if (value.length <= length) {
        return value;
      }

      return value.substring(0, length) + ommision;
    }
  }
};
</script>
