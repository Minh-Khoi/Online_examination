<template>
  <div style="margin-left: 1em">
    <div class="alert alert-error" v-if="errors">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Oh snap!</strong>
      {{errors}}
    </div>

    <h3>You are going to delete the answer with ID {{answer.id}}</h3>
    <p class="content_of_question">
      <b>For Question:</b>
      <br />
      {{question.question_content}}
    </p>

    <p class="content_of_answer">
      <b>Answer content:</b>
      <br />
      {{answer.answer_content}}
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
      answer: this.$route.params.answer,
      errors: "",
      question: {}
    };
  },

  methods: {
    /** Submit the form check deleting above */
    async agree_deleting() {
      let controller = new Controller();
      let form_datas = new FormData();
      form_datas.append("id", this.question.id);
      let submit_result = await controller.sendAPI(
        "/action/delete_answer",
        form_datas,
        "POST"
      );
      if (isNaN(submit_result)) {
        alert("deleted 01 answer successfully");
        setTimeout(() => {
          router.push({ name: "answers" });
        }, 1200);
      } else {
        this.error = "Something wrong!! deleting failed";
      }
    }
  },

  async mounted() {
    let controller = new Controller();
    this.question = await controller.readQuestionByID(this.answer.question_id);
  }
};
</script>

<style scoped>
p.content_of_answer,
p.content_of_question {
  background-color: azure;
}
</style>
