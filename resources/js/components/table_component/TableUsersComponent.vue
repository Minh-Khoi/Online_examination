<template>
  <div id="table_for_users" class="module span8" style="width:70%">
    <div class="module-head">
      <h3>Users 's Table</h3>
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
            <th>Email</th>
            <th>Occupation</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Is Admin</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user) in users_list" :key="user.id">
            <td>{{user.name}}</td>
            <td>{{user.email}}</td>
            <td>{{user.occupation}}</td>
            <td>{{user.address}}</td>
            <td>{{user.phone}}</td>
            <td>{{(user.is_admin==1) ? "Admin" : ""}}</td>
          </tr>
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
      users_list: []
    };
  },

  methods: {
    /**  *
     * This function will filter the rows of table
     * which have content relatively matched the value of "#myInput"
     */
    filterTable() {
      let helper = new Controller();
      let input = document.querySelector("#table_for_users #myInput");
      let table = document.querySelector("#table_for_users #myTable");
      helper.filterTable(input, table);
    }
  },

  /** *
   * when this component is mounted. A list of all User instances will be loaded in JSON object
   * always use "async - await" with the functioc which have use asynchronous loading
   */
  async mounted() {
    let helper = new Controller();
    this.users_list = await helper.loadUsersList();
    // console.log(this.users_list);
  }
};
</script>

<style>
</style>
