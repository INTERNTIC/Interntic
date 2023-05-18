<script setup>

import { defineProps,onMounted,ref} from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


onMounted(() => {
  $('.timepicker').timepicker({});
})
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
const value=ref(props.modelValue)
</script>
<template>
  <div class="mb-3">
    <label v-bind:for="label" class="form-label">{{label}}</label>
    <VueDatePicker  :class="{'is-invalid': showError }" v-model="value"  @closed="$emit('update:modelValue', value)"
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