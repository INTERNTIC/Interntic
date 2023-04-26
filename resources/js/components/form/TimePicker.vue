<script setup>

import { defineProps} from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


const props = defineProps({
  modelValue: {
  },
  errorText: {
    type: String,

  },
  showError: {
    type: Boolean,
    default: true,

  },
  label: {
    type: String,

  },
  placeholder: {
    type: String,

  },
  mark: {
    type: String,

  },
})
</script>
<template>
  <div class="mb-3">
    <label v-bind:for="label" class="form-label">{{label}}</label>
    <VueDatePicker  :class="{'is-invalid': showError }" v-model="modelValue"  @closed="$emit('update:modelValue', modelValue)"
    
    time-picker disable-time-range-validation range :placeholder="placeholder" />

    <div v-if="showError" class="text-danger">
    {{ errorText }}
  </div>
  <label >{{mark}}</label>
</div>
</template>
<style >
input.dp__pointer.dp__input_readonly.dp__input.dp__input_icon_pad.dp__input_reg{
  color: gray !important;
  font-size: 0.9rem !important;
}
.dp__main.dp__theme_light.is-invalid{
  border: 1px solid red;
}
</style>