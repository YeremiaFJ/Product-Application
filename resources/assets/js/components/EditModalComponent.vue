<template>
  <div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header bg-info text-white">
          <h4 class="modal-title">Edit {{ editedProduct.name }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <form>
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
      props: {
        editedProduct: { type: Object }
      },

      data() {
        return {
          form: {
            name: '',
            category: '',
            price: '0',
            discount: '0',
            description: ''
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
          var imgFiles = this.$refs.imageUp.files;
          var formData = new FormData();
          if(imgFiles.length > 0) {
            formData.append('image', imgFiles[0]);
          }
          for(var prop in this._data.form) {
            formData.append(prop, this._data.form[prop]);
          }
          this.$emit('submitEdit', formData, this.editedProduct.id);
        }
      },

      watch: {
        editedProduct() {
          this.form.name = this.editedProduct.name,
          this.form.category = this.editedProduct.category,
          this.form.price = this.editedProduct.price,
          this.form.discount = this.editedProduct.discount,
          this.form.description = this.editedProduct.description
        }
      }
    }
</script>
