<template>
  <div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header bg-info text-white">
          <h4 class="modal-title">Login User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="log_email" v-model="form.email" v-validate="'required|email|min:2|max:255'" name="email" maxlength="255">
              <p class="alert alert-danger small" v-if="checkError('email')">{{ checkError('email') }}</p>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="log_password" v-model="form.password" v-validate="'required|min:6|max:255'" name="password" maxlength="255">
              <p class="alert alert-danger small" v-if="checkError('password')">{{ checkError('password') }}</p>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info" @click="submitData" :data-dismiss="this.errors.items.length === 0 ? 'modal' : false" :disabled="this.errors.items.length != 0">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          form: {
            email: '',
            password: ''
          }
        }
      },

      methods: {
        checkError(field) {
          var errors = this.errors.items;
          if(errors.length === 0) return false;
          else {
            for(var i=0;i<errors.length;i++) {
              if(errors[i].field === field) return errors[i].msg;
            }
            return false;
          }
        },
        submitData(event) {
          var formData = new FormData();
          for(var prop in this._data.form) {
            formData.append(prop, this._data.form[prop]);
          }
          this.$emit('login', formData);
          this.resetForm();
        },
        resetForm() {
          var vueObject = this;
          for(var prop in this.form) {
            this.form[prop] = '';
          }
          setTimeout(function() {
            vueObject.errors.clear();
          }, 1000);
        }
      }
    }
</script>
