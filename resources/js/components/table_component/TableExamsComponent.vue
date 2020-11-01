<template>
  <div id="table_for_exams" class="module span8" style="width:70%">
    <div class="module-head">
      <h3>Exams 's Table</h3>
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
            <th>EXAM ID</th>
            <th>QUIZ --- (ID)</th>
            <th>USER --- (ID)</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="exam in exams_list" :key="exam.id">
            <td>{{exam.id}}</td>
            <td>
              {{exam.quiz_name}} ---
              <b>(ID: {{exam.quiz_id}} )</b>
            </td>
            <td>
              {{exam.user_name}} ---
              <b>(ID: {{exam.user_id}} )</b>
            </td>
            <td>
              <button @click="goto_edit_form(exam)" class="btn btn-warning">EDIT</button>
              <button @click="goto_delete_form(exam)" class="btn btn-danger">DELETE</button>
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
      exams_list: []
    };
  },

  methods: {
    /**  *
     * This function will filter the rows of table
     * which have content relatively matched the value of "#myInput"
     */
    filterTable() {
      let helper = new Controller();
      let input = document.querySelector("#table_for_exams #myInput");
      let table = document.querySelector("#table_for_exams #myTable");
      helper.filterTable(input, table);
    },

    /**
     * Event handler for button "edit".
     * @param array exam
     */
    goto_edit_form(exam) {
      console.log(exam);
      router.push({
        name: "edit_exam",
        params: { id: exam.id, exam: exam }
      });
    },

    /**
     * Event handler for button "delete".
     * @param array exam
     */
    goto_delete_form(exam) {
      console.log(exam);
      router.push({
        name: "delete_exam",
        params: { id: exam.id, exam: exam }
      });
    }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON objec
   */
  async mounted() {
    let controller = new Controller();
    let exams_list = await controller.loadExamsList();

    for (let exam of exams_list) {
      let quiz = await controller.readQuizByID(exam.quiz_id);
      let user = await controller.readUserByID(exam.user_id);
      exam["user_name"] = user.name;
      exam["quiz_name"] = quiz.name;
    }
    this.exams_list = exams_list;
  }
};
</script>

<style>
</style>
