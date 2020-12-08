<template>
  <div class="dashboard">
    <div class="alert alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <h4>Announce</h4>
      {{announce}}
    </div>
    <div class="btn-controls">
      <div class="btn-box-row row-fluid">
        <span @click="showUserTable()" class="btn-box big span2" style="margin-left: 3.2vw">
          <i class="icon-random"></i>
          <b>SEE Users</b>
        </span>
        <span
          @click="showQuizzesTable()"
          class="btn-box big span2"
          style="margin-left: 3.2vw"
          v-if="current_user.is_admin"
        >
          <i class="icon-user"></i>
          <b>SEE Quizzes</b>
        </span>
        <span
          v-if="!current_user.is_admin"
          @click="showExamsTable()"
          class="btn-box bg-success big span2"
          style="margin-left: 3.2vw; background-color: #FF7F50"
        >
          <i class="icon-money"></i>
          <b>DO An Exam (you have)</b>
        </span>
        <span
          @click="showQuestionsTable()"
          class="btn-box big span2"
          style="margin-left: 3.2vw"
          v-if="current_user.is_admin"
        >
          <i class="icon-money"></i>
          <b>See Question</b>
        </span>

        <span class="btn-box big span2" style="margin-left: 3.2vw" @click="showExamsTable(true)">
          <i class="icon-money"></i>
          <b v-if="current_user.is_admin">See all Results</b>
          <b v-if="!current_user.is_admin">See your Results</b>
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
  data() {
    return {
      /** User who are logging in */
      announce: document.querySelector("span[data-role=alert]").innerHTML,
      current_user: window.current_user,
      keep_direct_to: this.$route.params.direct_to
    };
  },
  methods: {
    /** show the TableUsersComponent by calling routes */
    showUserTable() {
      router.push({ name: "loading", params: { direct_to: "exams" } });
    },

    /** show the TableQuizzesComponent by calling routes */
    showQuizzesTable() {
      router.push({ name: "loading", params: { direct_to: "quizzes" } });
    },

    /** show the TableExamsComponent by calling routes */
    showExamsTable(exams_is_done = false) {
      let params = null;
      if (!this.current_user.is_admin) {
        params = {
          user_in_reference: this.current_user,
          exams_is_done: exams_is_done
        };
      }
      router.push({
        name: "loading",
        params: { direct_to: "exams", other_params: params }
      });
    },

    /** show the TableQuestionsComponent by calling routes */
    showQuestionsTable() {
      router.push({ name: "loading", params: { direct_to: "questions" } });
    }
  },

  mounted() {
    //
  }
};
</script>

<style scoped>
</style>
