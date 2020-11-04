<template>
  <div class="dashboard">
    <div class="btn-controls">
      <div class="btn-box-row row-fluid">
        <span @click="showUserTable()" class="btn-box big span2" style="margin-left: 3.2vw">
          <i class="icon-random"></i>
          <b>SEE Users</b>
        </span>
        <span @click="showQuizzesTable()" class="btn-box big span2" style="margin-left: 3.2vw">
          <i class="icon-user"></i>
          <b>SEE Quizzes</b>
        </span>
        <span
          @click="showExamsTable()"
          class="btn-box bg-success big span2"
          style="margin-left: 3.2vw; background-color: #FF7F50"
        >
          <i class="icon-money"></i>
          <b>DO An Exam</b>
        </span>
        <span @click="showQuestionsTable()" class="btn-box big span2" style="margin-left: 3.2vw">
          <i class="icon-money"></i>
          <b>See Results</b>
        </span>

        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import { router } from "../routes/routes.js";
import { Controller } from "../controllers/controllers.js";

export default {
  //
  methods: {
    /** show the TableUsersComponent by calling routes */
    showUserTable() {
      router.push({ name: "users" });
    },

    /** show the TableQuizzesComponent by calling routes */
    showQuizzesTable() {
      router.push({ name: "quizzes" });
    },

    /** show the TableExamsComponent by calling routes */
    showExamsTable() {
      router.push({ name: "exams" });
    },

    /** show the TableQuestionsComponent by calling routes */
    showQuestionsTable() {
      router.push({ name: "questions" });
    }
  }
};
</script>

<style scoped>
</style>
