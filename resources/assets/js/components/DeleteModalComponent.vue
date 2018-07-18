<template>
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">

        <div class="modal-header bg-info text-white">
          <h4 class="modal-title">Delete {{ deletedProduct.name }}?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" @click="$emit('confirmDelete')" data-dismiss="modal">Delete</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
    export default {
      props: {
        deletedProduct: { type: Object }
      }
    }
</script>
