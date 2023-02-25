<script setup>

import { defineProps} from 'vue';
const {modelValue,errorText,showError,label,placeholder,inputType}=defineProps(['modelValue','errorText','showError','label','placeholder','inputType'])
</script>
<template>
  <div class="mb-3">
    <label v-bind:for="label" class="form-label">{{label}}</label>
    <input class="form-control"
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