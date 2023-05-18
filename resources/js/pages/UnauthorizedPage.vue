<template>
  <h1>403 Page</h1>
  <p>{{generalErrorMsg}}</p>
</template>
<script setup>
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
}from "@/axiosClient";
</script>