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
      <form class="form-horizontal row-fluid" id="form_create_exam" @submit.prevent="onSummit()">
        <div class="control-group">
          <label class="control-label" for="quiz_id">Choose a quiz</label>
          <div class="controls">
            <select name="quiz_id" id="quiz_id" size="10" v-model="current_exam.quiz_id">
              <option v-for="quiz in quizzes_list" :key="quiz.id" :value="quiz.id">
                {{quiz.name}} ----
                <strong>(ID: {{quiz.id}} )</strong>
              </option>
            </select>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="user_id">Choose an user</label>
          <div class="controls">
            <select name="user_id" id="user_id" size="10" v-model="current_exam.user_id">
              <option v-for="user in users_list" :key="user.id" :value="user.id">
                {{user.name}} ----
                <strong>(ID: {{user.id}} )</strong>
              </option>
            </select>
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
      users_list: [],
      current_exam: this.$route.params.exam
    };
  },

  methods: {
    /**
     * This function use to handle the event onSubmit.
     * The function e.preventDefault() DO NOT WORK with Vue.js framework.
     * To prevent default handling, we @Submit.prevent on the HTML template above
     */
    async onSummit() {
      let submit_form = document.querySelector("#form_create_exam");
      let form_datas = new FormData(submit_form);
      form_datas.append("id", this.current_exam.id);
      let controller = new Controller();
      if (!form_datas.get("quiz_id") || !form_datas.get("user_id")) {
        this.note_content.warning =
          "You HAVE NOT complete the form yet!! And It will make errors";
        return;
      }
      let submit_result = await controller.sendAPI(
        "/action/edit_quiz_user",
        form_datas,
        "POST"
      );
      if (!isNaN(submit_result)) {
        this.note_content.error = "something wrong!! Summission failed";
      } else {
        this.note_content.success = submit_result;
        setTimeout(() => {
          router.push({ name: "exams" });
        }, 1200);
      }
    }
  },

  async mounted() {
    // we must render the quizzes_list to "select" tag by method controller.loadQuizzesList()
    let controller = new Controller();
    this.quizzes_list = await controller.loadQuizzesList();
    this.users_list = await controller.loadUsersList();
  }
};
</script>

<style scope>
</style>
