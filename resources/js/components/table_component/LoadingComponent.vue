<template>
  <p>
    <br />
    <b>LOADING ....</b>
  </p>
</template>

<script>
import { router } from "../../routes/routes";

export default {
  mounted() {
    // console.log(this.$route.params);
    router.push({
      name: this.$route.params.direct_to,
      params: this.$route.params.other_params
        ? this.$route.params.other_params
        : null
    });
  }
};
</script>

<style>
</style>
