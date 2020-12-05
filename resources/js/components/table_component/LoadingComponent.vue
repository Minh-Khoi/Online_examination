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
    console.log(this.$route.params.direct_to);
    router.push({
      name: this.$route.params.direct_to,
      params: this.$route.params.other_params
    });
  }
};
</script>

<style>
</style>
