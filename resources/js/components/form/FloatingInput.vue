<script setup>

import { defineProps} from 'vue';
const {modelValue,errorText,showError,label,placeholder,inputType}=defineProps(['modelValue','errorText','showError','label','placeholder','inputType'])
</script>
<template>
<div class="form-floating mb-3">
  <input 
  :id="label"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :class="{'is-invalid': showError }"
    :type="inputType"
    :placeholder="placeholder"
   class="form-control">
  <label v-bind:for="label">{{ label }}</label>
  <div v-if="showError" class="invalid-feedback">
    {{ errorText }}
</div>
</div>
</template>