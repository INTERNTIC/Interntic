<script setup>

import { defineProps} from 'vue';
const props = defineProps({
  modelValue: {
  },
  errorText: {
    type: String,

  },
  showError: {
    type: Boolean,

  },
  label: {
    type: String,

  },
  placeholder: {
    type: String,

  },
  inputType: {
    type: String,
    default: "text",
  },
  readonly: {
    type: Boolean,
    default: false,
  }
})
</script>
<template>
  <div class="mb-3">
    <label v-bind:for="label" class="form-label">{{label}}</label>
    <input class="form-control"
    :readonly="readonly"
    :id="label"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :class="{'is-invalid': showError }"
    :type="inputType"
    :placeholder="placeholder"
    >
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
  </div>
</div>
</template>