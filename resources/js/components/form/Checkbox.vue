<script setup>

import { defineProps } from 'vue';
import { defineEmits ,watch,ref} from 'vue';
const emit=defineEmits();
const inputValue = ref(modelValue)

const emitChageCheckBox = () => {
  emit('update:modelValue', inputValue);
}
watch(
  inputValue, () => {
    emitChageCheckBox();
  }
)

const { modelValue, label } = defineProps(['modelValue', 'label'])
</script>
<template>
  <div class="mb-3 mb-3">
    <div class="form-check">
      <input :id="label" v-model="inputValue" type="checkbox"
        class="form-check-input">
      <label v-bind:for="label" class="form-check-label">{{ label }}</label>
    </div>
  </div>
</template>