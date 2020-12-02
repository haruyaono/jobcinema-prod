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
        <!-- Button trigger modal -->
        <div class="text-right mb-2">
          <a
            href="javascript:void(0)"
            class="help-btn"
            data-toggle="modal"
            data-target="#helpModal"
          >
            <!-- <span class="help-mark">?</span> -->
            <span class="help-txt link">カテゴリについて</span>
          </a>
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
    <!-- Modal -->
    <div
      class="modal fade"
      id="helpModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="helpModalLabel"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="helpModalLabel">カテゴリについて</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 class="h4">■エリア</h4>
            <p class="font-weight-bold">新橋大通り周辺</p>
            <p class="pl-2">東川町・治水町・暁町・豊川町</p>
            <p class="font-weight-bold">柳町公園付近</p>
            <p class="pl-2">中園町・柳町・光陽町・花園町</p>
            <p class="font-weight-bold">釧路駅裏</p>
            <p class="pl-2">若松町・松浦町・新富町・白金町</p>
            <p class="font-weight-bold">新橋大通り周辺</p>
            <p class="pl-2">川端町・新川町・若草町・若竹町・新栄町・中島町・駒場町・住之江町</p>
            <p class="font-weight-bold">イオン釧路店周辺</p>
            <p class="pl-2">豊美・北都・雁来・富原・睦・桂木・木場・光和・新開・北見団地・黒誉・若葉・曙・桂</p>
            <p class="font-weight-bold">南大通周辺</p>
            <p class="pl-2">宮本・弥生・浦見・大町・入舟・港町・米町・知人町</p>
            <p class="font-weight-bold">釧路ガス周辺</p>
            <p class="pl-2">寿・仲浜町・海運・浪花町・南浜町・宝町</p>
            <p class="font-weight-bold">市役所周辺</p>
            <p class="pl-2">黒金町・錦町</p>
            <p class="font-weight-bold">ナイトスポット</p>
            <p class="pl-2">末広町・栄町</p>
            <p class="font-weight-bold">遠矢・別保方面</p>
            <p class="pl-2">中央・東陽西</p>
            <hr />
            <h4 class="h4">■雇用形態</h4>
            <p class="font-weight-bold">ナイト</p>
            <p class="pl-2">深夜営業の居酒屋を含むバーやスナックの業態</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn modal-btn yellow" data-dismiss="modal">閉じる</button>
          </div>
        </div>
      </div>
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
