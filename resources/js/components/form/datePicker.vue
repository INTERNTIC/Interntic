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
    <input class="form-control"
    :value="modelValue"  @input="$emit('update:modelValue', $event.target.value)"
    :class="{ 'is-invalid': showError }"
    :placeholder="placeholder"
    type="date" >
    <!-- <span class="font-13 text-muted">{{placeholder}}</span> -->
    <label v-bind:for="label">{{ label }}</label>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div> 
  </div>

  <!-- Normal one   -->
  <!-- <div class="mb-3 position-relative " id="datepicker1">
    <label v-bind:for="label" class="form-label">{{ label }}</label>
    <input class="form-control"
      :value="modelValue"  @input="$emit('update:modelValue', $event.target.value)"
      
      :class="{ 'is-invalid': showError }"
      type="date" >
      <span class="font-13 text-muted">{{placeholder}}</span>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div> 
  </div>
   -->
</template>
