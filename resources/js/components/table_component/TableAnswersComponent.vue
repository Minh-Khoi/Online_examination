<template>
  <div id="table_for_answers" class="module span8" style="width:70%">
    <div class="module-head">
      <h3>Answer 's Table</h3>
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
            <th>Question ---- (ID)</th>
            <th>Edit / Delete</th>
            <th v-if="question_pending">Copy to Question</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="answer in answers_list" :key="answer.id">
            <td>{{answer.answer_content}}</td>
            <td>
              <strong>{{answer.question_name}} ---- (ID: {{answer.question_id}} )</strong>
            </td>
            <td>
              <button @click="goto_edit_form(answer)" class="btn btn-warning">EDIT</button>
              <button @click="goto_delete_form(answer)" class="btn btn-danger">DELETE</button>
            </td>
            <td
              v-if="question_pending"
              class="btn btn-block"
              style="background-color: #7FFFD4"
            >Copy this Answer to Question: {{question_pending.name}} (ID: {{question_pending.id}} ) )</td>
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
      answers_list: [],
      /** this variables will by loaded when user want to copy an answer of this question to another question */
      question_pending: this.$route.params.for_question,
      question_in_reference: this.$route.params.question_in_reference
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
      let input = document.querySelector("#table_for_answers #myInput");
      let table = document.querySelector("#table_for_answers #myTable");
      helper.filterTable(input, table);
    },

    /**
     * Event handler for button "edit".
     */
    goto_edit_form(answer) {
      console.log(answer);
      router.push({
        name: "edit_answer",
        params: { id: answer.id, answer: answer }
      });
    },

    /**
     * Event handler for button "delete".
     */
    goto_delete_form(answer) {
      console.log(answer);
      router.push({
        name: "delete_answer",
        params: { id: answer.id, answer: answer }
      });
    }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON objec
   */
  async mounted() {
    let controller = new Controller();
    answers_list = null;

    if (!this.question_in_reference) {
      answers_list = await controller.loadAnswersList();
    } else {
      // answers_list = await controller.lo
    }

    // add the attribute "question_name" for each answer object of answers_list array
    for (let answer of answers_list) {
      let question = await controller.readQuestionByID(answer.question_id);
      //   console.log(question);
      answer["question_name"] = question.name;
    }
    this.answers_list = answers_list;
  }
};
</script>

<style>
</style>
