<template>
  <span
    v-if="getPlace == 'header'"
    id="saveCount-sp"
    ref="saveCountSp"
    class="saveCount"
  >{{ showCount}}</span>
  <p
    v-else-if="getPlace == 'hamburger'"
    id="hamburgerLogoutClipJobCount"
    class="hamburgerLogoutClipJobCount"
  >{{ showCount }}</p>
</template>

<script>
import FavouriteCount from "../../mixins/favouriteCount";
export default {
  mixins: [FavouriteCount]
};
</script>
