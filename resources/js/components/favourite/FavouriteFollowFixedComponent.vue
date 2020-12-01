<template>
  <a
    href="javascript:void(0)"
    v-if="showFlag"
    @click.prevent="unsave()"
    class="btn btn-web-keep"
  >お気に入り削除</a>
  <a href="javascript:void(0)" v-else @click.prevent="save()" class="btn btn-web-keep">お気に入り追加</a>
</template>
<script>
import Favourite from "../../mixins/favourite";
export default {
  mixins: [Favourite]
};
</script>
