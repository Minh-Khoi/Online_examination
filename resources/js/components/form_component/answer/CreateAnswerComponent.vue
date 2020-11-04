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
      <form class="form-horizontal row-fluid" id="form_create_answer" @submit.prevent="onSummit()">
        <div class="control-group">
          <label class="control-label" for="question_id">Choose a question</label>
          <div class="controls">
            <select name="question_id" id="question_id" size="10">
              <option
                v-for="question in questions_list"
                :key="question.id"
                :value="question.id"
                @click="onQuestionChoosen(question.id)"
              >(ID: {{question.id}} )</option>
            </select>
          </div>
        </div>

        <div class="control-group">
          <label for="question_content" class="control-label"></label>
          <div class="controls">
            <textarea
              name="question_content"
              id="question_content"
              style="width: 100%"
              rows="5"
              v-model="question_selected.question_content"
              disabled
            ></textarea>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="answer_content">Answer 's Content</label>
          <div class="controls">
            <textarea
              type="text"
              rows="5"
              style="width: 100%"
              id="answer_content"
              name="answer_content"
              placeholder="Content"
              class="span8"
            ></textarea>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label">Correct Answer??</label>
          <div class="controls">
            <input type="radio" name="is_correct" class="text-info" value="1" /> YES
            <input type="radio" name="is_correct" class="text-danger" value="0" /> NO
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
      questions_list: [],
      question_selected: {}
    };
  },

  methods: {
    /**
     * This function use to handle the event onSubmit.
     * The function e.preventDefault() DO NOT WORK with Vue.js framework.
     * To prevent default handling, we @Submit.prevent on the HTML template above
     */
    async onSummit() {
      let submit_form = document.querySelector("#form_create_answer");
      let form_datas = new FormData(submit_form);
      let controller = new Controller();
      if (!form_datas.get("question_id") || !form_datas.get("answer_content")) {
        this.note_content.warning =
          "You HAVE NOT fill all the blanks yet!! And It will make errors";
        return;
      }
      let submit_result = await controller.sendAPI(
        "/action/create_answer",
        form_datas,
        "POST"
      );
      if (!isNaN(submit_result)) {
        this.note_content.error = "something wrong!! Summission failed";
      } else {
        this.note_content.success = submit_result;
        setTimeout(() => {
          router.push({ name: "answers" });
        }, 1200);
      }
    },

    /**
     * This fuction handle the onchange event of the select #question id
     * it will find the question content by question id
     * @param number question_id
     */
    async onQuestionChoosen(id) {
      let controller = new Controller();
      let question = await controller.readQuestionByID(id);
      this.question_selected = question;
      //   console.log("question choosen");
    }
  },

  async mounted() {
    // we must render the questions_list to "select" tag by method controller.loadQuestionsList()
    let controller = new Controller();
    this.questions_list = await controller.loadQuestionsList();
  }
};
</script>

<style scoped>
</style>
