<template>
  <div>
    <div class="alert alert-error" v-if="errors">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Oh snap!</strong>
      {{errors}}
    </div>

    <h3>You are going to delete the quiz {{quiz.name}} with ID {{quiz.id}}</h3>
    <button class="btn btn-danger" @click="agree_deleting()">AGREE</button>
  </div>
</template>

<script>
import { Controller } from "../../../controllers/controllers";
import { router } from "../../../routes/routes";
export default {
  data() {
    return {
      quiz: this.$route.params.quiz,
      errors: ""
    };
  },

  methods: {
    /** Submit the form check deleting above */
    async agree_deleting() {
      let controller = new Controller();
      let form_datas = new FormData();
      form_datas.append("id", this.quiz.id);
      let submit_result = await controller.sendAPI(
        "/action/delete_quiz",
        form_datas,
        "POST"
      );
      if (isNaN(submit_result)) {
        alert(
          "delete quiz " +
            this.quiz.name +
            "(ID: " +
            this.quiz.id +
            ") successfully"
        );
        setTimeout(() => {
          router.push({ name: "quizzes" });
        }, 1200);
      } else {
        this.error = "Something wrong!! deleting failed";
      }
    }
  }
};
</script>

<style>
</style>
