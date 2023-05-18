<script setup>
import { defineProps } from 'vue';
const props = defineProps({
    modalId: {
        type: String,
        default: "standard-modal"
    },
    modal_heading: {
        type: String,
        default: "Modal Heading"
    },
})
</script>
<template>
<div :id="modalId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">{{modal_heading}}</h4>
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