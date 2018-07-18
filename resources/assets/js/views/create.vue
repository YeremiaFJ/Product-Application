<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header bg-info text-white">Add Product Form</div>

          <flash-message class="fixed-top shadow-sm"></flash-message>
          <div class="card-body">
            <p class="alert alert-danger small" v-for="error in formErrors">{{ error }}</p>
            <form @submit.prevent="submitData($validator)" ref="formInput">
              <div class="form-group">
                <label for="productImage">Product Image:</label>
                <input type="file" accept="image/*" class="form-control-file border" name="image" ref="imageUp" v-validate="'image|mimes:jpg,png,jpeg'">
                <p class="alert alert-danger small" v-if="checkError('image')">{{ checkError('image') }}</p>
              </div>
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" v-model="form.name" v-validate="'required|min:2|max:255'" name="name" maxlength="255">
                <p class="alert alert-danger small" v-if="checkError('name')">{{ checkError('name') }}</p>
              </div>
              <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" class="form-control" id="category" v-model="form.category" v-validate="'required|min:2|max:255'" name="category" maxlength="255">
                <p class="alert alert-danger small" v-if="checkError('category')">{{ checkError('category') }}</p>
              </div>
              <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" v-model="form.price" v-validate="'required|numeric'" name="price">
                <p class="alert alert-danger small" v-if="checkError('price')">{{ checkError('price') }}</p>
              </div>
              <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="number" class="form-control" id="discount" v-model="form.discount" v-validate="'required|numeric'" name="discount">
                <p class="alert alert-danger small" v-if="checkError('discount')">{{ checkError('discount') }}</p>
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" rows="4" class="form-control" v-model="form.description" v-validate="'required|min:2'" name="description"></textarea>
                <p class="alert alert-danger small" v-if="checkError('description')">{{ checkError('description') }}</p>
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
      api_key: { type: String },
      user_id: { type: Number },
      app_url: { type: String }
    },
    data() {
      return {
        form: {
          name: '',
          category: '',
          price: '0',
          discount: '0',
          description: ''
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
            var imgFiles = vueObject.$refs.imageUp.files;
            var formData = new FormData();
            if(imgFiles.length > 0) {
              formData.append('image', imgFiles[0]);
            }
            for(var prop in vueObject._data.form) {
              formData.append(prop, vueObject._data.form[prop]);
            }
            axios({
              method: 'POST',
              url: '/',
              data: formData,
              headers: { 'Authorization': 'Bearer ' + vueObject.api_key }
            }).then(function(response) {
              if(response.status === 200) {
                vueObject.allowSubmit = false;
                vueObject.flashMessage('Product ' + vueObject.form.name + ' is Added!', 'success');
                vueObject.reload();
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
      reload() {
         this.form.name = '';
         this.form.category = '';
         this.form.price = '0';
         this.form.discount =  '0';
         this.form.description = '';
         this.$refs.imageUp.type = 'text';
         this.$refs.imageUp.type = 'file';
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
    }
  }
</script>
