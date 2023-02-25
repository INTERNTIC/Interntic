<script setup>
import { defineProps, ref, watch,defineEmits } from 'vue';
const emit=defineEmits();
const { modelValue, errorText, showError, label,placeholder, options,floatingTheme,propertyOfValue,propertyOfShow } = defineProps(['modelValue', 'errorText', 'showError', 'label','placeholder','options','defaultTheme','floatingTheme','propertyOfValue','propertyOfShow'])
const inputValue = ref([])

const emitSelectedOptions = () => {
  emit('update:modelValue', inputValue);
}
watch(
  inputValue, () => {
    emitSelectedOptions();
  }
)
</script>
<template>
  <label v-if="!floatingTheme" v-bind:for="label">{{label}}</label>
  <div :class="{'form-group col-md-6':!floatingTheme,'form-floating':floatingTheme }">
    <select v-model="inputValue" 
    class="form-select"
    :class="{'is-invalid':showError}">
    <option value=""> {{ placeholder }} </option>
    <option v-for="option in options" :value="option[propertyOfValue]">{{ option[propertyOfShow] }}</option>
  </select>
  <label v-if="floatingTheme" v-bind:for="label">{{label}}</label>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div>
  </div>
  <!-- <div class="form-group col-md-6">
    <label v-bind:for="label">{{label}}</label>
    <select multiple="false" v-model="inputValue" 
    :class="{'is-invalid': showError }"
    class="custom-select">
      <option v-for="type in options" :value="type.type_id">{{ type.type }}</option>
    </select>
    <div v-if="showError" class="invalid-feedback">
      {{ errorText }}
    </div>
  </div> -->
</template>