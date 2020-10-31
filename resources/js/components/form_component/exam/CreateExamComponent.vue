<template>
  <div class="module span9" style="width: 70%; display: inline">
    <div class="module-head">
      <h3>Forms</h3>
    </div>
    <div class="module-body">
      <!-- <div class="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Warning!</strong> Something fishy here!
      </div>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Oh snap!</strong> Whats wrong with you?
      </div>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Well done!</strong> Now you are listening me :)
      </div>-->

      <br />

      <form class="form-horizontal row-fluid">
        <div class="control-group">
          <label class="control-label" for="name">Name of Quiz</label>
          <div class="controls">
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Type the quiz 's name here..."
              class="span8"
            />
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="description">Description</label>
          <div class="controls">
            <input
              type="text"
              id="description"
              name="description"
              placeholder="Description"
              class="span8"
            />
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="basicinput">Time</label>
          <div class="controls">
            <div class="input-prepend">
              <span class="add-on">minutes</span>
              <input class="span8" type="number" placeholder="minutes" name="minutes" id="minutes" />
            </div>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn">Submit Form</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  //
};
</script>

<style>
</style>
