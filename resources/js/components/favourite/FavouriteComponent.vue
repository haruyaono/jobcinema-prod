<template>
  <div class="entrybtn-item">
    <button
      v-if="showFlag"
      @click.prevent="unsave()"
      class="entry-btn favourite-btn"
      type="submit"
    >お気に入りリストから削除</button>
    <button v-else @click.prevent="save()" class="entry-btn favourite-btn" type="submit">お気に入りリストに追加</button>
  </div>
</template>

<script>
import Favourite from "../../mixins/favourite";
export default {
  mixins: [Favourite]
};
</script>
