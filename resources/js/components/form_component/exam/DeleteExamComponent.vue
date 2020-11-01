<template>
  <div style="margin-left: 1em">
    <div class="alert alert-error" v-if="errors">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Oh snap!</strong>
      {{errors}}
    </div>

    <h3>You are going to delete the exam with ID {{exam.id}}</h3>
    <p class="content_of_exam">
      <b>User:</b>
      <br />
      {{exam.user_name}}
      <br />
      <b>Quiz:</b>
      <br />
      {{exam.quiz_name}}
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
      exam: this.$route.params.exam,
      errors: ""
    };
  },

  methods: {
    /** Submit the form check deleting above */
    async agree_deleting() {
      let controller = new Controller();
      let form_datas = new FormData();
      form_datas.append("id", this.exam.id);
      let submit_result = await controller.sendAPI(
        "/action/delete_quiz_user",
        form_datas,
        "POST"
      );
      if (isNaN(submit_result)) {
        alert("deleted 01 exam successfully");
        setTimeout(() => {
          router.push({ name: "exams" });
        }, 1200);
      } else {
        this.error = "Something wrong!! deleting failed";
      }
    }
  },

  /** we need to add attributes "quiz_name" and "user_name" for current exam */
  async mounted() {
    let controller = new Controller();
    let quiz = await controller.readQuizByID(this.exam.quiz_id);
    let user = await controller.readUserByID(this.exam.user_id);
    this.exam["user_name"] = user.name;
    this.exam["quiz_name"] = quiz.name;
  }
};
</script>

<style scoped>
p.content_of_question {
  background-color: azure;
}
</style>
