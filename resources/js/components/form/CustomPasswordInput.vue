<script setup>

import { defineProps, ref } from 'vue';
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
  readonly: {
    type: Boolean,
    default: false,
  }
})
const type = ref("password")
const toggle_password = () => {
  if (type.value == "password") {
    type.value = "text"
  } else {
    type.value = "password"
  }
}
</script>
<template>
  <div class="mb-3">
    <label v-bind:for="label" class="form-label">{{$props.label}}</label>
    <div class="input-group input-group-merge">
      <input class="form-control" :type="type" id="password" :readonly="readonly" :id="label" :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" :class="{ 'is-invalid': showError }"
        :placeholder="placeholder">
      <div @click="toggle_password" role="button" class="input-group-text" data-password="false">
        <span class="password-eye"></span>
      </div>
      <div v-if="showError" class="invalid-feedback">
        {{ errorText }}
      </div>
    </div>
  </div>
</template>