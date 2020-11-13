<template>
  <div style="margin-left: 1em">
    <div class="alert alert-error" v-if="errors">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Oh snap!</strong>
      {{errors}}
    </div>

    <h3>You are going to delete the user with ID {{user.id}}</h3>
    <p class="content_of_user">
      <b>{{(user.is_admin ==1) ? "ADMIN:" : "USER:"}}</b>
      <br />
      {{user.name}}
      <br />
      <b>Email:</b>
      <br />
      {{user.email}}
    </p>
    <button class="btn btn-danger" @click="agree_deleting()">AGREE</button>
  </div>
</template>

<script>
import { Controller } from "../../../controllers/controllers";
import { router } from "../../../routes/routes";

export default {
  data() {
    return {
      user: this.$route.params.user,
      errors: ""
    };
  },

  methods: {
    /** Submit the form check deleting above */
    async agree_deleting() {
      let controller = new Controller();
      let form_datas = new FormData();
      form_datas.append("user_id", this.user.id);
      let submit_result = await controller.sendAPI(
        "/action/delete_user",
        form_datas,
        "POST"
      );
      if (isNaN(submit_result)) {
        alert("deleted 01 user successfully");
        setTimeout(() => {
          router.push({ name: "users" });
        }, 1200);
      } else {
        this.error = "Something wrong!! deleting failed";
      }
    }
  },

  async mounted() {}
};
</script>

<style scoped>
p.content_of_user {
  background-color: azure;
}
</style>
