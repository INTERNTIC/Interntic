<script setup>
import { defineProps, ref, watch, defineEmits, onMounted, onUpdated } from 'vue';
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
  modelValue: {
  }, errorText: {
    type: String,
  }, showError: {
    type: Boolean,
  }, label: {
    type: String,
  }, placeholder: {
    type: String,
  }, options: {
    type: Array,
  }, floatingTheme: {
    type: Boolean,
    default: false
  }, propertyOfValue: {
    type: String,
  }, propertyOfShow: {
    type: String,
  }, addedClasses: {
    type: String,
  }
})
</script>
<template>
  <label v-if="!floatingTheme" v-bind:for="label">{{ label }}</label>
  <div :class="{ 'form-group col-md-6': !floatingTheme, 'form-floating': floatingTheme }">
    <select @change="emit('update:modelValue', $event.target.value)" :value="modelValue" class="form-select"
      :class="{ 'is-invalid': showError }">
      <option selected value=""> {{ placeholder }} </option>
      <option v-for="option in options" :value="option[propertyOfValue]">{{ option[propertyOfShow] }}</option>
    </select>
    <label v-if="floatingTheme" v-bind:for="label">{{ label }}</label>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div>
  </div>
</template>