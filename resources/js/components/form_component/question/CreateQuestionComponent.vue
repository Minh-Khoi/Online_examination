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
      <form
        class="form-horizontal row-fluid"
        id="form_create_question"
        @submit.prevent="onSummit()"
      >
        <div class="control-group">
          <label class="control-label" for="quiz_id">Choose a quiz</label>
          <div class="controls">
            <select name="quiz_id" id="quiz_id" size="10">
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
            ></textarea>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-success">Submit Form</button>
            <button
              @click.prevent="onSummit($event)"
              id="submit_and_go_copy"
              class="btn btn-primary"
            >Submit Form and go copying answers</button>
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
      next_ID: null
    };
  },

  methods: {
    /**
     * This function use to handle the event onSubmit.
     * The function e.preventDefault() DO NOT WORK with Vue.js framework.
     * To prevent default handling, we @Submit.prevent on the HTML template above
     */
    async onSummit(event = null) {
      let submit_form = document.querySelector("#form_create_question");
      let form_datas = new FormData(submit_form);
      let controller = new Controller();
      if (!form_datas.get("quiz_id") || !form_datas.get("question_content")) {
        this.note_content.warning =
          "You HAVE NOT fill all the blanks yet!! And It will make errors";
        return;
      }
      // if the submission was clicked by the button "#submit_and_go_copy",
      // we set the value going_copy is true. And add value to attribute next_ID
      let going_copy = event ? true : false;
      if (event) {
        this.next_ID = await controller.find_next_id("questions");
      }
      // now let 's submit the form
      let submit_result = await controller.sendAPI(
        "/action/create_question",
        form_datas,
        "POST"
      );
      if (!isNaN(submit_result)) {
        this.note_content.error = "something wrong!! Summission failed";
      } else {
        this.note_content.success = submit_result;
        let next_question = {
          id: this.next_ID,
          question_content: form_datas.get("question_content"),
          quiz_id: form_datas.get("quiz_id")
        };
        let route_parameters = going_copy
          ? { for_question: next_question }
          : {};
        setTimeout(() => {
          if (going_copy) {
            router.push({ name: "answers", params: route_parameters });
          } else {
            router.push({ name: "questions" });
          }
        }, 1200);
      }
    }
  },

  async mounted() {
    // we must render the quizzes_list to "select" tag by method controller.loadQuizzesList()
    let controller = new Controller();
    this.quizzes_list = await controller.loadQuizzesList();
  }
};
</script>

<style scope>
</style>
