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
            <th>IS DONE</th>
            <th>action</th>
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
            <td>{{(exam.is_done) ? "yes" : "no"}}</td>
            <td v-if="current_user.is_admin">
              <button @click="goto_edit_form(exam)" class="btn btn-warning">EDIT</button>
              <button @click="goto_delete_form(exam)" class="btn btn-danger">DELETE</button>
            </td>
            <td v-if="!current_user.is_admin">
              <form action="/on_exam/on_exam" method="POST">
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="exam_id" :value="exam.id" />
                <input type="hidden" name="quiz_id" :value="exam.quiz_id" />
                <input type="hidden" name="user_id" :value="exam.user_id" />
                <button class="btn btn-warning" type="submit">DO THIS EXAM</button>
              </form>
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
      current_user: window.current_user,
      exams_list: [],
      /** if we need to load exams list using a specified quiz we need */
      quiz_in_reference: this.$route.params.quiz_in_reference,
      /** if we need to load exams list of a specified user we need */
      user_in_reference: this.$route.params.user_in_reference,
      /** this variable will define the table to load done exam or pending exam  */
      load_done_exam: this.$route.params.exams_is_done,
      // variables for Form go to exam
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
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

    // go_to_exam() {
    //   document.body.innerHTML = "<a> FUCK YOU </a>";
    // }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON objec
   */
  async mounted() {
    let controller = new Controller();
    let exams_list = null;
    // console.log(this.quiz_in_reference);
    // load the exams list
    if (window.current_user.is_admin == 1) {
      if (this.quiz_in_reference) {
        exams_list = await controller.loadExamsListByQuizID(
          this.quiz_in_reference.id
        );
      } else if (this.user_in_reference) {
        exams_list = await controller.loadExamsListByUserID(
          this.user_in_reference.id
        );
      } else {
        exams_list = await controller.loadExamsList();
      }
      // now filter exams_list depends on variable "this.exam_is_done"
      let only_done_exam_loaded = this.load_done_exam;
      exams_list = exams_list.filter(exam => {
        return only_done_exam_loaded ? exam.is_done : !exam.is_done;
      });
    } else {
      exams_list = await controller.loadPendingExamsListByUserID(
        window.current_user.id
      );
    }

    // add "user_name" and "quiz_name" fields
    for (let exam of exams_list) {
      let quiz = await controller.readQuizByID(exam.quiz_id);
      let user = await controller.readUserByID(exam.user_id);
      exam["user_name"] = user.name;
      exam["quiz_name"] = quiz.name;
    }

    // now assign value for "this.exam_list"
    this.exams_list = exams_list;
  }
};
</script>

<style>
</style>
