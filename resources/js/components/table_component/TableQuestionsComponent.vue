<template>
  <div id="table_for_questions" class="module span8" style="width:70%">
    <div class="module-head">
      <h3>Questions 's Table</h3>
    </div>
    <div class="module-body table">
      <div class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
        <div class="dataTables_filter" id="DataTables_Table_0_filter">
          <label>
            Search:
            <input
              type="text"
              aria-controls="DataTables_Table_0"
              id="myInput"
              @keyup="filterTable()"
            />
          </label>
        </div>
      </div>
      <table
        id="myTable"
        cellpadding="0"
        cellspacing="0"
        border="0"
        class="datatable-1 table table-bordered table-striped display"
        width="100%"
      >
        <!--  -->
        <thead>
          <tr>
            <th>Content</th>
            <th>Quiz ---- (ID)</th>
            <th>Edit / Delete</th>
            <th v-if="quiz_pending">Copy to Quiz</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="question in questions_list" :key="question.id">
            <td>{{question.question_content}}</td>
            <td>
              <strong>{{question.quiz_name}} ---- (ID: {{question.quiz_id}} )</strong>
            </td>
            <td>
              <button @click="goto_edit_form(question)" class="btn btn-warning">EDIT</button>
              <button @click="goto_delete_form(question)" class="btn btn-danger">DELETE</button>
            </td>
            <td v-if="quiz_pending">
              <button
                class="btn btn-block"
                style="width: 100%; background-color: #7FFFD4;"
                @click="copy_question_to_quiz(question,quiz_pending)"
              >
                Copy this question to Quiz:
                <br />
                {{quiz_pending.name}} (ID: {{quiz_pending.id}} ) )
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { Controller } from "../../controllers/controllers.js";
import { router } from "../../routes/routes";

export default {
  //
  data() {
    return {
      questions_list: [],

      /**
       *  this variables will by loaded when user want to copy a question of this quiz to another quiz
       */
      quiz_pending: this.$route.params.for_quiz,

      /**
       *  This variables used for filtering the question which have the same specified quiz_id attributes
       * (which is passed through vue router)
       */
      quiz_in_reference: this.$route.params.quiz_in_reference
    };
  },

  computed: {},

  methods: {
    /**  *
     * This function will filter the rows of table
     * which have content relatively matched the value of "#myInput"
     */
    filterTable() {
      let helper = new Controller();
      let input = document.querySelector("#table_for_questions #myInput");
      let table = document.querySelector("#table_for_questions #myTable");
      helper.filterTable(input, table);
    },

    /**
     * Event handler for button "edit".
     */
    goto_edit_form(question) {
      console.log(question);
      router.push({
        name: "edit_question",
        params: { id: question.id, question: question }
      });
    },

    /**
     * Event handler for button "delete".
     */
    goto_delete_form(question) {
      console.log(question);
      router.push({
        name: "delete_question",
        params: { id: question.id, question: question }
      });
    },

    /**
     * Copy an exiting question to a new one for "quiz_pending"
     */
    async copy_question_to_quiz(question, quiz) {
      let controller = new Controller();
      // get answers list of question
      let answers_list = await controller.readAnswersByQuestionID(question.id);
      let next_question_id = await controller.find_next_id("questions");
      // Create FormData object
      let form_datas = new FormData();
      form_datas.append("id", next_question_id);
      form_datas.append("question_content", question.question_content);
      form_datas.append("quiz_id", quiz.id);
      form_datas.append("answers_list", answers_list);
      let submit_result = await controller.sendAPI(
        "/action/copy_question",
        form_datas,
        "POST"
      );
      if (!isNaN(submit_result)) {
        controller.tempAlert("copied 01 question successfully", 1200);
      }
    }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON objec
   */
  async mounted() {
    let controller = new Controller();
    let questions_list = null;
    if (!this.quiz_in_reference) {
      questions_list = await controller.loadQuestionsList();
    } else {
      questions_list = await controller.loadQuestionsListByQuizID(
        this.quiz_in_reference.id
      );
    }
    console.log(questions_list);
    // add the attribute "quiz_name" for each question object of questions_list array
    for (let question of questions_list) {
      let quiz = await controller.readQuizByID(question.quiz_id);
      //   console.log(quiz);
      question["quiz_name"] = quiz.name;
    }
    this.questions_list = questions_list;
  }
};
</script>

<style scoped>
table td,
table th {
  width: 70%;
}
</style>
