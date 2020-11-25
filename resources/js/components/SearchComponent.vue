<template>
  <section class="search-section">
    <div class="inner">
      <form id="composite-form" method="get" action="/job_sheet/search/all" role="form" class="cf">
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
                <option value selected>指定なし</option>
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
            <span id="job-count" v-if="message != ''">{{ message }}</span>
            <span id="job-count" v-else>{{ countJobs }}</span>
            <span>件</span>
          </p>

          <button type="submit" id="filter-search" @click="search()">
            <i class="fas fa-search"></i>絞り込み検索
          </button>
        </div>
      </form>
    </div>
  </section>
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
        keyword: ""
      },
      salaries: [],
      categories: [],
      searchObj: [],
      jobs: [],
      message: ""
    };
  },
  mounted() {
    const self = this;

    var urlParam = new Object();
    var pair = location.search.substring(1).split("&");
    pair = pair.filter(v => v);

    for (var i = 0; pair[i]; i++) {
      if (pair[i] === "") {
        continue;
      }
      var kv = pair[i].split("=");
      urlParam[kv[0]] = kv[1];
    }

    if (urlParam.length !== 0) {
      urlParam["salary_child"] = {
        salary_h: "",
        salary_d: "",
        salary_m: ""
      };

      for (let p in urlParam) {
        if (p == "page" || p == "ks[f]") {
          delete urlParam[p];
        }
        if (p == "keyword") {
          urlParam[p] = decodeURIComponent(urlParam[p]);
          continue;
        }

        if (p == "salary_h" || p == "salary_d" || p == "salary_m") {
          urlParam["salary_child"][p] = urlParam[p];
          delete urlParam[p];
        }
      }

      self.params = Object.assign(self.params, urlParam);
    }
  },
  computed: {
    countJobs: function() {
      return this.jobs.length;
    }
  },
  created() {
    this.getCategory();
  },
  updated() {
    const self = this;
    this.$nextTick(function() {
      if (self.params.salary !== "") {
        const pSalaryCategory = self.categories[3]["children"];
        let sVal = self.params.salary,
          tmp_salaries = [];
        if (self.categories.length !== 0) {
          if (sVal == pSalaryCategory[0].id) {
            tmp_salaries = pSalaryCategory[0];
          } else if (sVal == pSalaryCategory[1].id) {
            tmp_salaries = pSalaryCategory[1];
          } else if (sVal == pSalaryCategory[2].id) {
            tmp_salaries = pSalaryCategory[2];
          } else {
            document.getElementById("salary-child").selectedIndex = "";
          }
        }
        self.salaries = tmp_salaries;
      }
    });
  },
  watch: {
    params: {
      handler: "getAnswer",
      deep: true,
      immediate: true
    }
  },
  methods: {
    fetchSalaries: function() {
      const self = this,
        pSalaryCategory = self.categories[3]["children"];
      let tmp_salaries = [];

      Object.keys(self.params.salary_child).forEach(
        key => (self.params.salary_child[key] = "")
      );

      if (self.params.salary == pSalaryCategory[0].id) {
        tmp_salaries = pSalaryCategory[0];
      } else if (self.params.salary == pSalaryCategory[1].id) {
        tmp_salaries = pSalaryCategory[1];
      } else if (self.params.salary == pSalaryCategory[2].id) {
        tmp_salaries = pSalaryCategory[2];
      } else {
        document.getElementById("salary-child").selectedIndex = "";
      }
      self.salaries = tmp_salaries;
    },
    getCategory: function() {
      const self = this;
      let list = [];

      return fetch("/api/categories/")
        .then(response => response.json())
        .then(data => {
          list = data.categories;
          const ite = (function*() {
            while (true) {
              const items = list.splice(0, 100);
              if (items.length <= 0) break;
              yield setTimeout(() => {
                for (let len = items.length, i = 0; i < len; i++) {
                  const item = items[i];
                  self.categories.push(item);
                }
                ite.next();
              });
            }
          })();
          ite.next();
        })
        .catch(error => {});
    },
    getAnswer: _.debounce(function() {
      this.message = "...";
      let vm = this;
      let params = this.params;
      let path = vm.setParameter(params);

      axios
        .get(path)
        .then(function(res) {
          vm.jobs = res.data.jobitems;
        })
        .catch(function(error) {
          vm.message = "Error!" + error;
          console.log(error);
        })
        .finally(function() {
          vm.message = "";
        });
    }, 1000),
    setParameter: function(paramsArray) {
      let path = "/api/job_sheets";
      let params = paramsArray;

      for (let key in paramsArray) {
        if (key == "salary_child") {
          params = { ...params, ...params[key] };
          delete params.salary_child;
        }
      }

      for (let key in params) {
        path += path.indexOf("?") == -1 ? "?" : "&";
        path += key + "=" + params[key];
      }

      return path;
    },
    search: function() {
      const self = this;
      let sessionParam = [];
      let params = self.params;

      for (let key in params) {
        if (key == "salary_child") {
          params = { ...params, ...params[key] };
          delete params.salary_child;
        }
      }

      for (let v in params) {
        if (params[v] == "") delete params[v];
      }

      if (Object.keys(params).length == 0) {
        return;
      }

      if (sessionStorage.hasOwnProperty("search-params")) {
        sessionParam = JSON.parse(sessionStorage.getItem("search-params"));
      }

      // params.count = self.jobs.length;

      if (sessionParam.length >= 3) {
        sessionParam = sessionParam.slice(-2);
      }

      sessionParam.push(params);
      sessionStorage.setItem("search-params", JSON.stringify(sessionParam));
    }
  }
};
</script>
