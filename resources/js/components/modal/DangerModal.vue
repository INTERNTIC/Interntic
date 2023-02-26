<script setup>
import { defineProps } from 'vue';
const {deleteEvent,deletedObject,deleteMsg,firstProperty,secondProperty} = defineProps(['deleteEvent','deletedObject','deleteMsg','firstProperty','secondProperty'])
</script>
<template>
    <div id="fill-danger-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fill-danger-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-filled bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title" id="fill-danger-modalLabel">Danger Filled Modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    {{ deleteMsg }} <b> {{ deletedObject[firstProperty] }} {{ deletedObject[secondProperty] }}</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button @click="deleteEvent(deletedObject)" type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Delete</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>