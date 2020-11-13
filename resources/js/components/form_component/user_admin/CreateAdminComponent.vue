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
            -----------------------
      -->

      <!-- This form is unset the admin (set is_admin == 0) -->
      <form
        class="form-horizontal row-fluid"
        id="form_unset_admin"
        @submit.prevent="onSummit('unset_user_admin','#form_unset_admin')"
      >
        <h2>Unset an admin</h2>
        <div class="control-group">
          <label class="control-label" for="user_id">Choose an user</label>
          <div class="controls">
            <select name="user_id[]" id="user_id" size="10" multiple>
              <option v-for="user in users_is_admin()" :key="user.id" :value="user.id">
                <span>
                  {{user.name}} ----
                  <strong>(ID: {{user.id}} )</strong>
                </span>
              </option>
            </select>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-success">Unset this/these admin</button>
          </div>
        </div>
      </form>

      <!-- This form is set an user as admin (set is_admin == 1) -->
      <form
        class="form-horizontal row-fluid"
        id="form_create_admin"
        @submit.prevent="onSummit('create_user_admin','#form_create_admin')"
      >
        <h2>Create an admin</h2>
        <div class="control-group">
          <label class="control-label" for="user_id">Choose an user</label>
          <div class="controls">
            <select name="user_id[]" id="user_id" size="10" multiple>
              <option v-for="user in users_is_not_admin()" :key="user.id" :value="user.id">
                <span>
                  {{user.name}} ----
                  <strong>(ID: {{user.id}} )</strong>
                </span>
              </option>
            </select>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-success">Set this/these user(s) as admin</button>
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
      users_list: []
    };
  },
  computed: {},

  methods: {
    /**
     * This function use to handle the event onSubmit.
     * The function e.preventDefault() DO NOT WORK with Vue.js framework.
     * To prevent default handling, we @Submit.prevent on the HTML template above
     */
    async onSummit(string_in_path, domSelector) {
      let submit_form = document.querySelector(domSelector);
      let form_datas = new FormData(submit_form);
      let controller = new Controller();
      if (!form_datas.get("user_id[]")) {
        this.note_content.warning =
          "You HAVE NOT complete the form yet!! And It will make errors";
        return;
      }
      let submit_result = await controller.sendAPI(
        "/action/" + string_in_path,
        form_datas,
        "POST"
      );
      if (!isNaN(submit_result)) {
        this.note_content.error = "something wrong!! Summission failed";
      } else {
        this.note_content.success = submit_result;
        setTimeout(() => {
          router.push({ name: "users" });
        }, 1200);
      }
    },

    /** Filter the admins in the users_list */
    users_is_admin() {
      return this.users_list.filter(user => user.is_admin == 1);
    },

    /** Filter the user who is not admin in the users_list */
    users_is_not_admin() {
      return this.users_list.filter(user => user.is_admin == 0);
    }
  },

  async mounted() {
    // we must render the quizzes_list to "select" tag by method controller.loadQuizzesList()
    let controller = new Controller();
    this.users_list = await controller.loadUsersList();
  }
};
</script>

<style>
</style>
