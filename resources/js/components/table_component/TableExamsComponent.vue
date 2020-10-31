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
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
            <th>Engine version</th>
            <th>CSS grade</th>
          </tr>
        </thead>
        <tbody>
          <!--  -->
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { Controller } from "../../controllers/controllers.js";

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
    }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON objec
   */
  async mounted() {
    let helper = new Controller();
    this.exams_list = await helper.loadExamsList();
    console.log(this.exams_list);
  }
};
</script>

<style>
</style>
