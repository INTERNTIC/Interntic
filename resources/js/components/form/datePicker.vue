<script setup>
import { defineProps, defineEmits } from 'vue';
const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
  },
  errorText: {

  }, showError: {

  }, label: {

  }, placeholder: {
  },
 
})


</script>
<template>
  <div class="mb-3 position-relative form-floating" id="datepicker1">
    <input class="form-control" data-provide="datepicker"  data-date-container="#datepicker1"  
      :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :class="{ 'is-invalid': showError }"
      type="text" >
      <span class="font-13 text-muted">{{placeholder}}</span>
    <label v-bind:for="label" class="form-label">{{ label }}</label>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div> 
  </div>
</template>
<!-- :id="label" -->