<template>
  <section class="search-section">
    <div class="inner">
      <form id="composite-form" method="get" action="/jobs/search/all" role="form" class="cf">
        <div
          v-for="(category, index) in categories"
          :key="category.id"
          v-bind:class="'composite composite-' + index"
        >
          <div class="composite-left">
            <p>
              {{category.name}}
              <span class="ib-only-pc">で探す</span>
            </p>
          </div>
          <div class="composite-right">
            <div v-bind:class="'select-wrap select-wrap-' + category.slug">
              <select
                v-if="category.slug == 'salary'"
                v-bind:id="'search-' + category.slug "
                class="selectbox"
                v-bind:name="category.slug"
                v-model="params[category.slug]"
                v-on:change="fetchSalaries"
              >
                <option value>選択</option>
                <option
                  v-for="cat in category.children"
                  :key="cat.id"
                  v-bind:value="cat.id"
                  v-bind:data-val="cat.name"
                  ref="category"
                >{{ cat.name }}</option>
              </select>
              <select
                v-else
                v-bind:id="'search-' + category.slug "
                class="selectbox"
                v-bind:name="category.slug"
                v-model="params[category.slug]"
              >
                <option value>選択してください</option>
                <option
                  v-for="cat in category.children"
                  :key="cat.id"
                  v-bind:value="cat.id"
                  v-bind:data-val="cat.name"
                  ref="category"
                >{{ cat.name }}</option>
              </select>
            </div>
            <div
              v-if="category.slug == 'salary'"
              class="option-lst jsc-option-lst jsc-option-required-wrapper select-wrap"
            >
              <select
                v-bind:name="salaries['slug']"
                id="salary-child"
                class="selectbox"
                v-model="params.salary_child[salaries['slug']]"
              >
                <option value>指定なし</option>
                <option
                  v-for="cCat in salaries['children']"
                  :key="cCat.id"
                  v-bind:value="cCat.id"
                >{{ cCat.name }}</option>
              </select>
            </div>
          </div>
        </div>
        <div class="composite mb-3 composite-5">
          <div class="composite-left">
            <p>キーワード</p>
          </div>
          <div class="composite-right">
            <input
              id="search-text"
              type="text"
              name="keyword"
              style="height:35px; padding: 4px 6px; width: 100%;"
              placeholder="例）コンビニ"
              value
              v-model="params.keyword"
            />
          </div>
        </div>
        <div class="search-bottom">
          <p class="search-job-result">
            検索結果
            <span id="job-count">{{params.count}}</span>件
          </p>

          <button type="submit" id="filter-search" @click="search()">
            <i class="fas fa-search"></i>絞り込み検索
          </button>
        </div>
      </form>
    </div>
    <!-- inner -->
  </section>
  <!-- search-section -->
</template>

<script>
export default {
  name: "search-component",
  data() {
    return {
      params: {
        status: "",
        type: "",
        area: "",
        salary: "",
        salary_child: {
          salary_h: "",
          salary_d: "",
          salary_m: ""
        },
        date: "",
        keyword: "",
        count: null
      },
      salaries: [],
      categories: [],
      searchObj: [],
      jobs: []
    };
  },
  mounted() {
    const self = this;
    let sessionParam = [];

    if (sessionStorage.hasOwnProperty("search-params")) {
      sessionParam = JSON.parse(sessionStorage.getItem("search-params"));
    }

    this.getCategory();
    this.getJobItems();

    if (sessionParam.length !== 0) {
      let defaultParams = sessionParam.pop();
      for (let dParam in defaultParams) {
        if (dParam == "count") {
          continue;
        }
        this.params[dParam] = defaultParams[dParam];
      }
    }
  },
  watch: {
    params: {
      handler: function(val) {
        var filterJobs = this.filterJobItems();
        if (filterJobs === false) {
          this.params.count = this.jobs.length;
        } else {
          this.params.count = Object.keys(filterJobs).length;
        }
      },
      deep: true
    }
  },
  updated() {
    const self = this;
    this.$nextTick(function() {
      if (self.params.salary !== "") {
        let sVal = self.params.salary,
          tmp_salaries = [];

        if (self.categories.length !== 0) {
          if (sVal == 284) {
            tmp_salaries = self.categories[3]["children"][0];
          } else if (sVal == 297) {
            tmp_salaries = self.categories[3]["children"][1];
          } else if (sVal == 306) {
            tmp_salaries = self.categories[3]["children"][2];
          } else {
            $("#salary-child").prop("selectedIndex", 0);
          }
        }

        self.salaries = tmp_salaries;
      }
    });
  },
  methods: {
    fetchSalaries: function() {
      const self = this;
      var tmp_salaries = [];

      Object.keys(self.params.salary_child).forEach(
        key => (self.params.salary_child[key] = "")
      );

      if (self.params.salary == 284) {
        tmp_salaries = self.categories[3]["children"][0];
      } else if (self.params.salary == 297) {
        tmp_salaries = self.categories[3]["children"][1];
      } else if (self.params.salary == 306) {
        tmp_salaries = self.categories[3]["children"][2];
      } else {
        $("#salary-child").prop("selectedIndex", 0);
      }
      self.salaries = tmp_salaries;
    },
    getCategory: function() {
      const self = this;
      fetch("/api/all_category")
        .then(response => response.json())
        .then(data => {
          self.categories = data.categoryList;
        })
        .catch(error => {});
    },
    getJobItems: function() {
      const self = this;
      axios
        .get("/api/jobs")
        .then(res => {
          self.jobs = res.data.data;
          self.params.count = self.jobs.length;
        })
        .catch(err => {
          console.log(err.statusText);
        });
    },
    filterJobItems: function() {
      const self = this;
      let params = [],
        filtered = {};

      for (let pKey in self.params) {
        if (pKey == "count" || pKey == "salary") {
          continue;
        }
        if (pKey == "salary_child") {
          for (let sItem in self.params[pKey]) {
            if (self.params[pKey][sItem] === "") {
              continue;
            }
            params.push(sItem);
          }
          continue;
        }
        if (self.params[pKey] !== "") {
          params.push(pKey);
        }
      }

      if (params.length == 0) {
        filtered = false;
      } else {
        if (self.jobs != null) {
          for (let i in self.jobs) {
            let job = self.jobs[i];
            const cResult = [];

            for (let param in params) {
              if (params[param] == "keyword") {
                if (
                  job["job_title"].indexOf(self.params[params[param]]) === -1
                ) {
                  if (filtered["job_id" + job.id] !== undefined) {
                    delete filtered["job_id" + job.id];
                  }
                  break;
                }
              } else {
                let categories = job.categories;
                const cList = categories.filter(value => {
                  if (
                    params[param] == "salary_d" ||
                    params[param] == "salary_h" ||
                    params[param] == "salary_m"
                  ) {
                    for (let sChildParam in params[param]) {
                      if (
                        value.id ===
                        parseInt(self.params["salary_child"][params[param]])
                      ) {
                        return value;
                      }
                    }
                  }
                  if (value.id === parseInt(self.params[params[param]])) {
                    return value;
                  }
                });

                if (cList.length === 1) {
                  cResult.push(cList);
                } else {
                  cResult = null;
                }
              }

              if (cResult === null) {
                if (filtered["job_id" + job.id] !== undefined) {
                  delete filtered["job_id" + job.id];
                }
                break;
              }

              if (filtered[job.id] !== undefined) break;
              filtered["job_id" + job.id] = job;
            }
          }
        }
      }
      return filtered;
    },
    search: function() {
      const self = this;
      let sessionParam = [];

      if (sessionStorage.hasOwnProperty("search-params")) {
        sessionParam = JSON.parse(sessionStorage.getItem("search-params"));
      }

      if (sessionParam.length >= 3) {
        sessionParam = sessionParam.slice(-2);
      }

      sessionParam.push(self.params);
      sessionStorage.setItem("search-params", JSON.stringify(sessionParam));
    }
  }
};
</script>
