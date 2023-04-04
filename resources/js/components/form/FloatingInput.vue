<script setup>

import { defineProps } from 'vue';
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
  },
  readonly: {
    type: Boolean,
    default: false,
  }
})
</script>
<template>
  <div class="form-floating mb-3">
    <input :readonly="readonly" :id="label" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
      :class="{ 'is-invalid': showError }" :type="inputType" :placeholder="placeholder" class="form-control">
    <label v-bind:for="label">{{ label }}</label>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div>
  </div>
</template>