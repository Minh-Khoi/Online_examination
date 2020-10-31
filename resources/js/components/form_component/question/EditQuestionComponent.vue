<template>
  <div class="module span9" style="width: 70%;">
    <div class="module-head">
      <h3>Forms</h3>
    </div>
    <div class="module-body">
      <div class="alert" v-if="note_content.warning">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Warning!</strong>
        {{note_content.warning}}
      </div>
      <div class="alert alert-error" v-if="note_content.error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Oh snap!</strong>
        {{note_content.error}}
      </div>
      <div class="alert alert-success" v-if="note_content.success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Well done!</strong>
        {{note_content.success}}
      </div>

      <br />

      <!--
          We should avoid changing the built code of the theme (use <form> tag instead of <div>)
          (Changing it might make it gotten some unwanted effects from CSS selectors);
          in the other hand, using <form> tag will make the work contructing  object FormData become easier
      -->
      <form class="form-horizontal row-fluid" id="form_edit_question" @submit.prevent="onSummit()">
        <div class="control-group">
          <label class="control-label" for="quiz_id">Choose a quiz</label>
          <div class="controls">
            <select name="quiz_id" id="quiz_id" size="10" v-model="current_question.quiz_id">
              <option v-for="quiz in quizzes_list" :key="quiz.id" :value="quiz.id">
                {{quiz.name}} ----
                <strong>(ID: {{quiz.id}} )</strong>
              </option>
            </select>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="question_content">Question 's Content</label>
          <div class="controls">
            <textarea
              type="text"
              rows="5"
              style="width: 100%"
              id="question_content"
              name="question_content"
              placeholder="Content"
              class="span8"
              v-model="current_question.question_content"
            ></textarea>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-success">Submit Form</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Controller } from "../../../controllers/controllers";
import { router } from "../../../routes/routes";

export default {
  data() {
    return {
      /** This attributes is used for show (or hide) the ".alert" elements */
      note_content: {
        warning: "",
        error: "",
        success: ""
      },
      quizzes_list: [],
      current_question: null
    };
  },

  methods: {
    /**
     * This function use to handle the event onSubmit.
     * The function e.preventDefault() DO NOT WORK with Vue.js framework.
     * To prevent default handling, we @Submit.prevent on the HTML template above
     */
    async onSummit() {
      let submit_form = document.querySelector("#form_edit_question");
      let form_datas = new FormData(submit_form);
      form_datas.append("id", this.current_question.id);
      let controller = new Controller();
      if (!form_datas.get("quiz_id") || !form_datas.get("question_content")) {
        this.note_content.warning =
          "You HAVE NOT fill all the blanks yet!! And It will make errors";
        return;
      }
      let submit_result = await controller.sendAPI(
        "/action/edit_question",
        form_datas,
        "POST"
      );
      if (!isNaN(submit_result)) {
        this.note_content.error = "something wrong!! Summission failed";
      } else {
        this.note_content.success = submit_result;
        setTimeout(() => {
          router.push({ name: "questions" });
        }, 1200);
      }
    }
  },

  async mounted() {
    // we must render the quizzes_list to "select" tag by method controller.loadQuizzesList()
    let controller = new Controller();
    this.quizzes_list = await controller.loadQuizzesList();
    this.current_question = this.$route.params.question;
  }
};
</script>

<style scope>
</style>
