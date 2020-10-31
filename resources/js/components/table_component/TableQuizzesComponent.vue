<template>
  <div id="table_for_quizzes" class="module span8" style="width:70%">
    <div class="module-head">
      <h3>Quizzes 's Table</h3>
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
            <th>Name</th>
            <th>Description</th>
            <th>Minutes</th>
            <th>Edit / Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(quiz) in quizzes_list" :key="quiz.id">
            <td>{{quiz.name}}</td>
            <td>{{quiz.description}}</td>
            <td>{{quiz.minutes}}</td>
            <td>
              <button @click="goto_edit_form(quiz)" class="btn btn-warning">EDIT</button>
              <button @click="goto_delete_form(quiz)" class="btn btn-danger">DELETE</button>
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
      quizzes_list: []
    };
  },

  methods: {
    /**  *
     * This function will filter the rows of table
     * which have content relatively matched the value of "#myInput"
     */
    filterTable() {
      let helper = new Controller();
      let input = document.querySelector("#table_for_quizzes #myInput");
      let table = document.querySelector("#table_for_quizzes #myTable");
      helper.filterTable(input, table);
    },

    /**
     * Event handler for button "edit".
     */
    goto_edit_form(quiz) {
      console.log(quiz);
      router.push({ name: "edit_quiz", params: { id: quiz.id, quiz: quiz } });
    },

    /**
     * Event handler for button "delete".
     */
    goto_delete_form(quiz) {
      console.log(quiz);
      router.push({ name: "delete_quiz", params: { id: quiz.id, quiz: quiz } });
    }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON objec
   */
  async mounted() {
    let helper = new Controller();
    this.quizzes_list = await helper.loadQuizzesList();
    console.log(this.quizzes_list);
  }
};
</script>

<style>
</style>
