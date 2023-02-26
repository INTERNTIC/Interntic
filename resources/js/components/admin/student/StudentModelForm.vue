<script setup>
import { defineProps } from 'vue';
import shared from '../../../shared';
import FloatingInput from '../../form/FloatingInput.vue';
import SelectInput from '../../form/SelectInput.vue';
const {studentModel,errors,majors,levels} = defineProps(['studentModel', 'errors','majors','levels'])
</script>
<template>
    <form class="row">
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.first_name"
                :errorText="shared.getErrorText(errors, 'first_name')"
                :showError="errors.hasOwnProperty('first_name')" label="First Name"
                placeholder="Enter First Name" inputType="text" />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.last_name"
                :errorText="shared.getErrorText(errors, 'last_name')"
                :showError="errors.hasOwnProperty('last_name')" label="Last Name"
                placeholder="Enter Last Name" inputType="text" />
        </div>
       
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.phone_number"
                :errorText="shared.getErrorText(errors, 'phone_number')"
                :showError="errors.hasOwnProperty('phone_number')"
                label="Phone Number" placeholder="Enter Phone Number"
                inputType="text" />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.birthday"
                :errorText="shared.getErrorText(errors, 'birthday')"
                :showError="errors.hasOwnProperty('birthday')"
                label="Birthday" placeholder="Enter Birthday"
                inputType="text" />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.place_of_birth"
                :errorText="shared.getErrorText(errors, 'place_of_birth')"
                :showError="errors.hasOwnProperty('place_of_birth')"
                label="Place Of Birth" placeholder="Enter Place Oof Birth"
                inputType="text" />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.student_card_number"
                :errorText="shared.getErrorText(errors, '.student_card_number')"
                :showError="errors.hasOwnProperty('.student_card_number')"
                label="Student Card Number" placeholder="Enter Student Card Number"
                inputType="text" />
        </div>
        <div class="col-lg-6">
            <FloatingInput v-model="studentModel.social_security_num"
                :errorText="shared.getErrorText(errors, 'social_security_num')"
                :showError="errors.hasOwnProperty('social_security_num')"
                label="Social Security Number"
                placeholder="Enter Social Security Number" inputType="text" />
        </div>
        <div class="col-lg-6 mb-3">
            <SelectInput propertyOfValue="id" property-of-show="name"
                placeholder="Select Student Level" :floatingTheme="true"
                v-model="studentModel.level_id"
                :errorText="shared.getErrorText(errors, 'major_id')"
                :showError="errors.hasOwnProperty('major_id')"
                label="Select Student Level" :options="levels" />
        </div>

        <div class="col-lg-6 mb-3">
            <SelectInput propertyOfValue="id" property-of-show="name"
                placeholder="Select Student Major" :floatingTheme="true"
                v-model="studentModel.major_id"
                :errorText="shared.getErrorText(errors, 'major_id')"
                :showError="errors.hasOwnProperty('major_id')"
                label="Select Student Major" :options="majors" />
        </div>
    </form>
</template>


