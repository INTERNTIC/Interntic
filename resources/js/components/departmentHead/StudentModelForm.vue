<script setup>
import { defineProps } from 'vue';
import DatePicker from '../form/datePicker.vue';
import FloatingInput from '../form/FloatingInput.vue';
import SelectInput from '../form/SelectInput.vue';
import {getErrorText} from "@/newShared";
const props = defineProps({ studentModel:Object, errors:Object, majors:Array, levels:Array })
</script>
<template>
    <form class="row">
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.first_name" :errorText="getErrorText(errors, 'first_name')"
                :showError="errors.hasOwnProperty('first_name')" label="First Name" placeholder="Enter First Name"
                 />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.last_name" :errorText="getErrorText(errors, 'last_name')"
                :showError="errors.hasOwnProperty('last_name')" label="Last Name" placeholder="Enter Last Name"
                 />
        </div>

        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.phone" :errorText="getErrorText(errors, 'phone')"
                :showError="errors.hasOwnProperty('phone')" label="Phone Number" placeholder="Enter Phone Number"
                inputType="number" />
        </div>        
        <div class="col-lg-6">
            <DatePicker v-model="studentModel.birthday" :errorText="getErrorText(errors, 'birthday')"
                :showError="errors.hasOwnProperty('birthday')" label="Birthday" placeholder="Enter Birthday"
                 />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.place_of_birth" :errorText="getErrorText(errors, 'place_of_birth')"
                :showError="errors.hasOwnProperty('place_of_birth')" label="Place Of Birth"
                placeholder="Enter Place Oof Birth"  />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.student_card"
                :errorText="getErrorText(errors, 'student_card')"
                :showError="errors.hasOwnProperty('student_card')" label="Student Card Number"
                placeholder="Enter Student Card Number"  />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.social_security_num"
                :errorText="getErrorText(errors, 'social_security_num')"
                :showError="errors.hasOwnProperty('social_security_num')" label="Social Security Number"
                placeholder="Enter Social Security Number"  />
        </div>
        <div class="col-lg-6 ">
            <SelectInput propertyOfValue="id" property-of-show="name" placeholder="Select Student Level"
                :floatingTheme="true" v-model="studentModel.level_id" :errorText="getErrorText(errors, 'level_id')"
                :showError="errors.hasOwnProperty('level_id')" label="Select Student Level" :options="levels">
            </SelectInput>
        </div>

        <div class="col-lg-6">
            <SelectInput propertyOfValue="id" property-of-show="name" placeholder="Select Student Major"
                :floatingTheme="true" v-model="studentModel.major_id" :errorText="getErrorText(errors, 'major_id')"
                :showError="errors.hasOwnProperty('major_id')" label="Select Student Major" :options="majors" >
            </SelectInput>
        </div>
        
    </form>
</template>


