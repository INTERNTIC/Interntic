<script setup>
import { defineProps } from 'vue';
const props = defineProps({
  modalId: {
    type: String,
    default :"info-header-modal"
  },
  modal_heading: {
    type: String,
    default :"Modal Heading"
  },
})
</script>
<template>
<!-- Info Header Modal -->
<div :id="modalId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="info-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-info">
                <h4 class="modal-title" id="info-header-modalLabel">{{modal_heading}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <slot name="body"></slot>
            </div>
            <div class="modal-footer">
                
                <slot name="buttons"></slot>
               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</template>