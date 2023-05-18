<script setup>
import { defineProps } from 'vue';
const props = defineProps({
    modalId: {
        type: String,
        default: "fill-danger-modal"
    },
    modal_heading: {
        type: String,
        default: "Modal Heading"
    },
})
</script>
<template >
    <div :id="modalId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fill-danger-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-filled bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title" id="fill-danger-modalLabel">{{modal_heading}}</h4>
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
</div><!-- /.modal --></template>