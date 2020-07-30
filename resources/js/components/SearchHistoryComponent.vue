<template>
  <div v-if="searchItems.length !== 0" class="search-history-section">
    <h2 class="txt-h2 top-heading-h2">
      <i class="fas fa-history font-yellow mr-2"></i>検索履歴
    </h2>
    <div class="search-history-wrap">
      <ul class="search-history-list">
        <li v-for="(searchItem, index) in searchItems" :key="searchItem.id">
          <dl class="p-mypage-search-condition-text">
            <dt>履歴{{index + 1}}</dt>
            <dd class="job-hostory-name">
              <a
                v-bind:href="'/jobs/search/all?' + params[index] "
                class="txt-blue-link"
              >{{ nameList['no'+index] }}</a>
            </dd>
            <dd class="job-hostory-count">{{searchItem.count}}件</dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchItems: [],
      nameList: {
        no0: "",
        no1: "",
        no2: ""
      },
      params: []
    };
  },
  mounted() {
    const self = this;

    if (sessionStorage.hasOwnProperty("search-params")) {
      self.searchItems = JSON.parse(sessionStorage.getItem("search-params"));

      this.getName();
      this.getUrl();
    }
  },
  methods: {
    getName: function() {
      const self = this;
      let searchItems = this.searchItems;

      for (let sItem in searchItems) {
        let data = {
          idList: []
        };

        for (let key in searchItems[sItem]) {
          if (key == "count" || key == "keyword" || key == "salary") {
            continue;
          }
          if (key == "salary_child") {
            for (let sChildItem in searchItems[sItem][key]) {
              if (searchItems[sItem][key][sChildItem] !== "") {
                data.idList.push(searchItems[sItem][key][sChildItem]);
              }
            }
            continue;
          }
          data.idList.push(searchItems[sItem][key]);
        }

        axios
          .post("/api/category_namelist", data, {
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
          })
          .then(function(response) {
            let nl = response.data.nameList;
            if (nl.length === 0 && searchItems[sItem]["keyword"] === "") {
              nl = "条件なし";
              self.nameList["no" + sItem] = nl;
            } else {
              if (searchItems[sItem]["keyword"] !== "") {
                nl.push(searchItems[sItem]["keyword"]);
              }
              self.nameList["no" + sItem] = nl.join("、");
            }
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    getUrl: function() {
      const self = this;
      let searchItems = self.searchItems,
        searchParams = [],
        paramList = [];

      for (let sItem in searchItems) {
        let paramStr = "";
        for (let i in searchItems[sItem]) {
          if (searchItems[sItem][i] === "" || i == "count") {
            continue;
          }
          if (i == "salary_child") {
            for (let sChildItem in searchItems[sItem][i]) {
              if (searchItems[sItem][i][sChildItem] !== "") {
                paramStr +=
                  sChildItem + "=" + searchItems[sItem][i][sChildItem] + "&";
              }
            }
            continue;
          }
          paramStr += i + "=" + searchItems[sItem][i] + "&";
        }
        paramList[sItem] = paramStr;
      }

      for (let param in paramList) {
        searchParams[param] = new URLSearchParams(paramList[param]);
        searchParams[param] = searchParams[param].toString();
      }

      self.params = searchParams;
    }
  }
};
</script>
