<template>
  <div class="container-fluid">
    <div class="alert alert-danger" v-for="error in formErrors">{{ error }}</div>
    <div class="row pb-2" v-for="products in productRows">
      <div class="col-md-3" v-for="product in products" v-if="product.user_id == user_id || user_id == 0">
        <div class="card">
          <div class="card-header bg-info text-white">{{ product.name }}</div>
          <img v-if="product.img != ''" class="card-img-top img-thumbnail img-fluid" :src="imgSrc + product.img" :alt="product.name">
          <div class="card-body">
            {{ product.description }}
            <hr>
            <p class="text-left">Price</p>
            <p class="text-right">Rp. {{ productPrice(product.price) }}</p>
            <hr>
            <p class="text-left">Discount</p>
            <p class="text-right">{{ product.discount }}%</p>
            <hr v-if="product.user_id == user_id">
          </div>
          <button type="button" class="btn btn-warning text-white" @click="editedProduct = product" data-toggle="modal" data-target="#editModal" v-if="product.user_id == user_id">Edit</button>
          <button type="button" class="btn btn-danger" @click="deletedProduct = product" data-toggle="modal" data-target="#deleteModal" v-if="product.user_id == user_id">Delete</button>
          <div class="card-footer">{{ product.updated_at | ago }}</div>
        </div>
      </div>
    </div>

    <edit-modal :editedProduct="editedProduct" @submitEdit="submitEdit"></edit-modal>
    <delete-modal :deletedProduct="deletedProduct" @confirmDelete="confirmDelete"></delete-modal>

  </div>
</template>

<script>
  import moment from 'moment';
  import EditModal from '../components/EditModalComponent.vue';
  import DeleteModal from '../components/DeleteModalComponent.vue';

  export default {
    components: {
      'edit-modal': EditModal,
      'delete-modal': DeleteModal
    },

    props: {
      api_key: { type: String },
      user_id: { type: Number },
      app_url: { type: String }
    },

    data() {
      return {
        products: [],
        editedProduct: {},
        deletedProduct: {},
        formErrors: [],
        imgSrc: ''
      }
    },

    computed: {
      productRows() {
        var productRows = [];
        var indeks = 0;
        for(var i=0;i<this.products.length;i++) {
          if(productRows[indeks] == null) productRows[indeks] = [];
          if(this.products[i].user_id != this.user_id && this.user_id !== 0) continue;
          productRows[indeks].push(this.products[i]);
          if(productRows[indeks].length === 4) indeks++;
        }
        return productRows;
      }
    },

    methods: {
      productPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      },
      submitEdit(product, id) {
        var vueObject = this;
        product.append("_method", "PATCH");
        axios({
          method: 'POST',
          url: 'edit/' + id,
          data: product,
          headers: { 'Authorization': 'Bearer ' + vueObject.api_key }
        }).then(function(response) {
          if(response.status === 200) {
            for(var i=0;i<vueObject.products.length;i++) {
              if(vueObject.products[i].id === id) {
                Vue.set(vueObject.products, i, response.data);
                vueObject.products[i].img += "?" + new Date().getTime();
                break;
              }
            }
          }
        }).catch(function(error) {
          var errors = error.response.data;
          for(var prop in errors) {
            vueObject.formErrors = [];
            vueObject.formErrors.push((errors[prop]).toString().replace(/^[A-Za-z ]+$/));
          }
        });
      },
      confirmDelete() {
        var vueObject = this;
        var idDelete = vueObject.deletedProduct.id;
        axios({
          method: 'DELETE',
          url: 'delete/' + idDelete,
          headers: { 'Authorization': 'Bearer ' + vueObject.api_key }
        }).then(function(response) {
          if(response.status === 200) {
            for(var i=0;i<vueObject.products.length;i++) {
              if(vueObject.products[i].id === idDelete) {
                Vue.delete(vueObject.products, i);
                break;
              }
            }
          }
        }).catch(function(error) {
          var errors = error.response.data;
          for(var prop in errors) {
            vueObject.formErrors = [];
            vueObject.formErrors.push((errors[prop]).toString().replace(/^[A-Za-z ]+$/));
          }
        });
      }
    },

    filters: {
      ago(data) {
        return moment(data).fromNow();
      }
    },

    created() {
      var vueObject = this;
      axios({
        method: 'GET',
        url: 'show'
      }).then(function(response) {
        vueObject.products = response.data;
      });
      axios({
        method: 'GET',
        url: 'imgSrc'
      }).then(function(response) {
        vueObject.imgSrc = response.data;
      });
    }
  }
</script>
