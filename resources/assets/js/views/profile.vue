<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header bg-info text-white">Edit Profile</div>

          <flash-message class="fixed-top shadow-sm"></flash-message>
          <div class="card-body">
            <p class="alert alert-danger small" v-for="error in formErrors">{{ error }}</p>
            <form @submit.prevent="submitData($validator)" ref="formInput">
              <div class="form-group">
                <label for="age">Age: {{ age }}</label>
                <input type="number" class="form-control" id="age" v-model="form.age" v-validate="'required|numeric'" name="age">
                <p class="alert alert-danger small" v-if="checkError('age')">{{ checkError('age') }}</p>
              </div>
              <div class="form-group">
                <label for="name">Name: {{ name }}</label>
                <input type="text" class="form-control" id="name" v-model="form.name" v-validate="'required|min:2|max:255'" name="name">
                <p class="alert alert-danger small" v-if="checkError('name')">{{ checkError('name') }}</p>
              </div>
              <div class="form-group">
                <label for="gender">Gender: {{ gender }}</label><br>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" v-model="form.gender" value="male">Male
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" v-model="form.gender" value="female">Female
                  </label>
                </div>
                <p class="alert alert-danger small" v-if="checkError('gender')">{{ checkError('gender') }}</p>
              </div>
              <div class="form-group">
                <button class="btn btn-info">Submit</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  require('vue-flash-message/dist/vue-flash-message.min.css');
  export default {
    props: {
      user_id: { type: Number },
      age: { type: String },
      gender: { type: String },
      name: { type: String }
    },
    data() {
      return {
        form: {
          age: '',
          gender: '',
          name: ''
        },
        formErrors: [],
        allowSubmit: true
      }
    },
    methods: {
      checkError(field) {
        if(this.allowSubmit === false) return false;
        var errors = this.errors.items;
        if(errors.length === 0) return false;
        else {
          for(var i=0;i<errors.length;i++) {
            if(errors[i].field === field) return errors[i].msg;
          }
          return false;
        }
      },
      submitData(validator) {
        var vueObject = this;
        validator.validateAll().then(function() {
          if(vueObject.errors.items.length === 0 && vueObject.allowSubmit) {
            var formData = new FormData();
            for(var prop in vueObject._data.form) {
              formData.append(prop, vueObject._data.form[prop]);
            }
            axios({
              method: 'POST',
              url: '/edit_profile',
              data: formData
            }).then(function(response) {
              if(response.status === 200) {
                vueObject.$emit('profile-updated', response.data);
                vueObject.allowSubmit = false;
                vueObject.flashMessage('Profile Updated Successful!', 'success');
              }
            }).catch(function(error) {
              var errors = error.response.data;
              for(var prop in errors) {
                vueObject.formErrors.push((errors[prop]).toString().replace(/^[A-Za-z ]+$/));
              }
            });
          }
        });
      },
      flashMessage(message, type) {
        var vueObject = this;
        this.flash(message, type, {
          timeout: 3000,
          beforeDestroy() {
            vueObject.allowSubmit = true;
            vueObject.errors.clear();
          }
        });
      }
    },
    watch: {
      age() {
        this.form.age = this.age;
      },
      gender() {
        this.form.gender = this.gender;
      },
      name() {
        this.form.name = this.name;
      }
    }
  }
</script>
