<script setup>
import { computed, onUpdated, onMounted, ref } from 'vue';
import { useAuthStore, } from '@/stores/AuthStore';
import { useStudentStore, } from '@/stores/StudentStore';
import useCompanyCause from "@/composables/CompanyCause.js";
import useDepartmentCause from "@/composables/DepartmentCause.js";
import CustomTextAria from '@/components/form/CustomTextAria.vue';
import StandardModal from '@/components/modal/StandardModal.vue';
import { Notify, getErrorText } from "@/newShared";
import {
  generalErrorMsg,
  generalSuccessMsg,
  errors
} from "@/axiosClient";



const authStore = useAuthStore()
const studentStore = authStore.is_student ? useStudentStore() : null;




const { get_company_causes,
  store_company_cause,
  update_company_cause,
  destroy_company_cause,
  company_causes,
  company_causes_pagination } = useCompanyCause();
const { get_department_causes,
  store_department_cause,
  update_department_cause,
  destroy_department_cause,
  department_causes,
  department_causes_pagination } = useDepartmentCause();
const causes = ref([]);
const pagination = ref({})


const get_right_data_for_right_user = async (page_index) => {
  edited_cause_index.value = null;
  switch (true) {
    case authStore.is_department_head:
      await get_department_causes(page_index);
      causes.value = department_causes.value;
      pagination.value = department_causes_pagination.value;
      break;
    case authStore.is_internship_responsible:
      await get_company_causes(page_index);
      causes.value = company_causes.value;
      pagination.value = company_causes_pagination.value;
      break;
  }
}
const get_causes = async (page_index) => {
  await get_right_data_for_right_user(page_index)
}
const call_api = async (_new_cause) => {
  switch (true) {
    case authStore.is_department_head:
      if (_new_cause.id) {
        await update_department_cause(_new_cause.id, _new_cause)
      } else {
        await store_department_cause(current_cause.value)
      }
      break;
    case authStore.is_internship_responsible:
      if (_new_cause.id) {
        await update_company_cause(_new_cause.id, _new_cause)
      } else {
        await store_company_cause(current_cause.value)
      }
      break;

  }
}
onMounted(async () => {
  await get_right_data_for_right_user();
})


const edited_cause_index = ref(null)


const isActive = computed(
  () => function (page_index) {
    return pagination.value.meta?.current_page == page_index;
  }
)
const isPaginationActive = computed(
  () => {
    return pagination.value.links?.next != pagination.value.links?.prev;
  }
)
const nextLink = computed(
  () => {
    const last_opage = pagination.value.meta?.last_page;
    const next_value = pagination.value.meta?.current_page + 1;
    return next_value > last_opage ? null : next_value;
  }
)
const prevLink = computed(
  () => {
    const prev_value = pagination.value.meta?.current_page - 1;
    return prev_value < 1 ? null : prev_value;

  }
)
const cause_exemple = {
  id: "",
  cause: ""
}

const current_cause = ref(Object.create(cause_exemple))
const save_cause = async (_new_cause) => {
  await call_api(_new_cause);
  Notify(generalSuccessMsg.value, generalErrorMsg.value)
  if (generalErrorMsg.value == '') {
    await get_right_data_for_right_user();
    current_cause.value = Object.create(cause_exemple);
    $("#add-cause-modal").modal("hide");
    $("#cause-modal").modal("show")
  }
}
const delete_cause = async (_cause_id) => {
  switch (true) {
    case authStore.is_department_head:
      destroy_department_cause(_cause_id)
      break;
    case authStore.is_internship_responsible:
      destroy_company_cause(_cause_id)
      break;
  }
  Notify(generalSuccessMsg.value, generalErrorMsg.value)
  if (generalErrorMsg.value == '') {
    await get_right_data_for_right_user();
  }
}
const show_manage_modal = async () => {
  await get_right_data_for_right_user();
  $("#cause-modal").modal("show")
}
const show_add_modal = async () => {
  $("#add-cause-modal").modal("show")
}





</script>
<template>
  <div class="leftside-menu">

    <!-- LOGO -->
    <router-link :to="{ name: 'statistiques' }" class="logo text-center logo-light">
      <span class="logo-lg">
      <svg xmlns:mydata="http://www.w3.org/2000/svg" mydata:contrastcolor="ffffff" mydata:template="BlackAndHighlightColorHex1" mydata:presentation="2.5" mydata:layouttype="undefined" mydata:specialfontid="undefined" mydata:id1="005" mydata:id2="171" mydata:companyname="INTERNTIC" mydata:companytagline="NTIC" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-150 100 900 350"><g fill="#5c88da" fill-rule="none" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g data-paper-data="{&quot;isGlobalGroup&quot;:true,&quot;bounds&quot;:{&quot;x&quot;:65,&quot;y&quot;:120.01241632516981,&quot;width&quot;:420,&quot;height&quot;:229.97516734966035}}"><g data-paper-data="{&quot;isSecondaryText&quot;:true}" fill-rule="nonzero"><path d="M216.33927,333.02718v12.75613l-9.55516,-12.75613v0h-2.38879v16.72152h2.38879v-12.73225l9.55516,12.73225h2.38879v-16.72152z" data-paper-data="{&quot;glyphName&quot;:&quot;N&quot;,&quot;glyphIndex&quot;:0,&quot;firstGlyphOfWord&quot;:true,&quot;word&quot;:1}"></path><path d="M269.02668,333.02718h-4.77758h-2.38879h-4.77758v2.38879h4.77758v14.33274h2.38879v-14.33274h4.77758z" data-paper-data="{&quot;glyphName&quot;:&quot;T&quot;,&quot;glyphIndex&quot;:1,&quot;word&quot;:1}"></path><path d="M299.51533,349.7487v-16.72152h-2.38879v16.72152z" data-paper-data="{&quot;glyphName&quot;:&quot;I&quot;,&quot;glyphIndex&quot;:2,&quot;word&quot;:1}"></path><path d="M343.00089,345.23389c-0.88385,1.36161 -2.31713,2.14991 -3.98928,2.14991c-3.00987,0 -5.1359,-2.53212 -5.1359,-5.99586c0,-3.48763 2.12602,-6.01975 5.1359,-6.01975c1.67215,0 3.10543,0.81219 3.98928,2.14991h2.60378c-1.21828,-2.81877 -3.72651,-4.7298 -6.59306,-4.7298c-4.08483,0 -7.38136,3.82206 -7.38136,8.59964c0,4.7298 3.29653,8.59964 7.38136,8.59964c2.86655,0 5.35089,-1.93492 6.56917,-4.75369z" data-paper-data="{&quot;glyphName&quot;:&quot;C&quot;,&quot;glyphIndex&quot;:3,&quot;lastGlyphOfWord&quot;:true,&quot;word&quot;:1}"></path></g><g data-paper-data="{&quot;isPrimaryText&quot;:true}" fill-rule="nonzero"><path d="M74.02554,318.38473h-9.02554v-49.77932h9.02554z" data-paper-data="{&quot;glyphName&quot;:&quot;I&quot;,&quot;glyphIndex&quot;:0,&quot;firstGlyphOfWord&quot;:true,&quot;word&quot;:1}"></path><path d="M134.32308,314.53152c0,0.64799 -0.1215,1.24969 -0.36449,1.80511c-0.243,0.55542 -0.56699,1.03562 -0.97198,1.44061c-0.40499,0.40499 -0.8852,0.7232 -1.44061,0.95462c-0.55542,0.23142 -1.14555,0.34714 -1.77039,0.34714c-0.55542,0 -1.11662,-0.10414 -1.68361,-0.31242c-0.56699,-0.20828 -1.07034,-0.54385 -1.51004,-1.00669l-32.97793,-34.4359v35.06075h-9.02554v-45.92611c0,-0.9257 0.26035,-1.76461 0.78106,-2.51674c0.5207,-0.75213 1.18605,-1.31333 1.99603,-1.68361c0.85627,-0.34714 1.73568,-0.43392 2.63823,-0.26035c0.90255,0.17357 1.67782,0.59592 2.32581,1.26705l32.97793,34.40119v-35.06075h9.02554z" data-paper-data="{&quot;glyphName&quot;:&quot;N&quot;,&quot;glyphIndex&quot;:1,&quot;word&quot;:1}"></path><path d="M189.79544,277.63095h-19.8909v40.75378h-9.02554v-40.75378h-19.92561v-9.02554h48.84205z" data-paper-data="{&quot;glyphName&quot;:&quot;T&quot;,&quot;glyphIndex&quot;:2,&quot;word&quot;:1}"></path><path d="M237.35309,298.04255h-28.49988v-9.09497h28.49988zM241.41458,318.38473h-32.56137c-1.24969,0 -2.61509,-0.21985 -4.09621,-0.65956c-1.48111,-0.43971 -2.8523,-1.16291 -4.11356,-2.1696c-1.26126,-1.00669 -2.31424,-2.31424 -3.15894,-3.92264c-0.8447,-1.6084 -1.26705,-3.58129 -1.26705,-5.91867v-32.56137c0,-0.62485 0.11571,-1.21498 0.34714,-1.77039c0.23142,-0.55542 0.54963,-1.04141 0.95462,-1.45797c0.40499,-0.41656 0.8852,-0.74056 1.44061,-0.97198c0.55542,-0.23142 1.15712,-0.34714 1.80511,-0.34714h40.64964v9.02554h-36.17158v28.08331c0,1.18026 0.31242,2.08282 0.93727,2.70766c0.62485,0.62485 1.53897,0.93727 2.74238,0.93727h32.49194z" data-paper-data="{&quot;glyphName&quot;:&quot;E&quot;,&quot;glyphIndex&quot;:3,&quot;word&quot;:1}"></path><path d="M299.8723,285.33737c0,2.05967 -0.25457,3.8995 -0.7637,5.51946c-0.50913,1.61997 -1.19762,3.04901 -2.06546,4.28713c-0.86784,1.23812 -1.86875,2.29688 -3.00273,3.1763c-1.13398,0.87941 -2.32003,1.60261 -3.55815,2.1696c-1.23812,0.56699 -2.48781,0.97777 -3.74907,1.23233c-1.26126,0.25457 -2.44731,0.38185 -3.55815,0.38185l18.84949,16.28068h-13.95487l-18.81478,-16.28068h-6.49145v-9.02554h20.4116c1.13398,-0.09257 2.1696,-0.32978 3.10687,-0.71163c0.93727,-0.38185 1.74725,-0.89677 2.42995,-1.54476c0.6827,-0.64799 1.20919,-1.42904 1.57947,-2.34317c0.37028,-0.91413 0.55542,-1.96132 0.55542,-3.14158v-5.69303c0,-0.50913 -0.06364,-0.89677 -0.19092,-1.16291c-0.12728,-0.26614 -0.28928,-0.46285 -0.48599,-0.59013c-0.19671,-0.12728 -0.40499,-0.2025 -0.62485,-0.22564c-0.21985,-0.02314 -0.42235,-0.03471 -0.60749,-0.03471h-29.78428v40.75378h-9.02554v-45.23184c0,-0.62485 0.11571,-1.21498 0.34714,-1.77039c0.23142,-0.55542 0.54963,-1.04141 0.95462,-1.45797c0.40499,-0.41656 0.8852,-0.74056 1.44061,-0.97198c0.55542,-0.23142 1.15712,-0.34714 1.80511,-0.34714h34.26234c2.01339,0 3.71436,0.36449 5.1029,1.09348c1.38854,0.72899 2.51674,1.64311 3.38458,2.74238c0.86784,1.09926 1.49269,2.28531 1.87454,3.55815c0.38185,1.27283 0.57277,2.46467 0.57277,3.5755z" data-paper-data="{&quot;glyphName&quot;:&quot;R&quot;,&quot;glyphIndex&quot;:4,&quot;word&quot;:1}"></path><path d="M358.67716,314.53152c0,0.64799 -0.1215,1.24969 -0.36449,1.80511c-0.243,0.55542 -0.56699,1.03562 -0.97198,1.44061c-0.40499,0.40499 -0.8852,0.7232 -1.44061,0.95462c-0.55542,0.23142 -1.14555,0.34714 -1.77039,0.34714c-0.55542,0 -1.11662,-0.10414 -1.68361,-0.31242c-0.56699,-0.20828 -1.07034,-0.54385 -1.51004,-1.00669l-32.97793,-34.4359v35.06075h-9.02554v-45.92611c0,-0.9257 0.26035,-1.76461 0.78106,-2.51674c0.5207,-0.75213 1.18605,-1.31333 1.99603,-1.68361c0.85627,-0.34714 1.73568,-0.43392 2.63823,-0.26035c0.90255,0.17357 1.67782,0.59592 2.32581,1.26705l32.97793,34.40119v-35.06075h9.02554z" data-paper-data="{&quot;glyphName&quot;:&quot;N&quot;,&quot;glyphIndex&quot;:5,&quot;word&quot;:1}"></path><path d="M414.14952,277.63095h-19.8909v40.75378h-9.02554v-40.75378h-19.92561v-9.02554h48.84205z" data-paper-data="{&quot;glyphName&quot;:&quot;T&quot;,&quot;glyphIndex&quot;:6,&quot;word&quot;:1}"></path><path d="M429.87478,318.38473h-9.02554v-49.77932h9.02554z" data-paper-data="{&quot;glyphName&quot;:&quot;I&quot;,&quot;glyphIndex&quot;:7,&quot;word&quot;:1}"></path><path d="M485,318.38473h-32.56137c-0.83313,0 -1.7299,-0.09836 -2.6903,-0.29507c-0.96041,-0.19671 -1.90925,-0.50335 -2.84652,-0.91991c-0.93727,-0.41656 -1.83404,-0.95462 -2.6903,-1.61418c-0.85627,-0.65956 -1.61418,-1.45797 -2.27374,-2.39524c-0.65956,-0.93727 -1.18605,-2.02496 -1.57947,-3.26308c-0.39342,-1.23812 -0.59013,-2.63245 -0.59013,-4.18299v-24.43838c0,-0.83313 0.09836,-1.7299 0.29507,-2.6903c0.19671,-0.96041 0.50335,-1.90925 0.91991,-2.84652c0.41656,-0.93727 0.96041,-1.83404 1.63154,-2.6903c0.67113,-0.85627 1.47533,-1.61418 2.4126,-2.27374c0.93727,-0.65956 2.01918,-1.18605 3.24572,-1.57947c1.22655,-0.39342 2.61509,-0.59013 4.16563,-0.59013h32.56137v9.02554h-32.56137c-1.18026,0 -2.08282,0.31242 -2.70766,0.93727c-0.62485,0.62485 -0.93727,1.55054 -0.93727,2.77709v24.36896c0,1.15712 0.31821,2.05389 0.95462,2.6903c0.63642,0.63642 1.53318,0.95462 2.6903,0.95462h32.56137z" data-paper-data="{&quot;glyphName&quot;:&quot;C&quot;,&quot;glyphIndex&quot;:8,&quot;lastGlyphOfWord&quot;:true,&quot;word&quot;:1}"></path></g><g data-paper-data="{&quot;fillRule&quot;:&quot;evenodd&quot;,&quot;fillRuleOriginal&quot;:&quot;evenodd&quot;,&quot;isIcon&quot;:true,&quot;iconStyle&quot;:&quot;standalone&quot;,&quot;selectedEffects&quot;:{&quot;container&quot;:&quot;&quot;,&quot;transformation&quot;:&quot;&quot;,&quot;pattern&quot;:&quot;&quot;},&quot;bounds&quot;:{&quot;x&quot;:207.79333063023637,&quot;y&quot;:120.01241632516981,&quot;width&quot;:134.41333873952726,&quot;height&quot;:121.9335110468868},&quot;iconType&quot;:&quot;icon&quot;,&quot;rawIconId&quot;:&quot;801309&quot;,&quot;combineTerms&quot;:&quot;education&quot;,&quot;suitableAsStandaloneIcon&quot;:true}" fill-rule="evenodd"><path d="M293.35957,125.42294c1.25256,-1.00022 1.51492,-2.22814 0.78706,-3.68376c-0.70615,-1.41251 -1.86021,-1.95844 -3.46221,-1.63777l-46.50904,10.2655c-0.5949,0.06714 -1.12527,0.33364 -1.59114,0.7995l-33.83601,33.41577c-0.07398,0.07299 -0.14216,0.15111 -0.20454,0.23433c-0.82349,1.09803 -0.96917,2.22351 -0.43705,3.37646c0.64815,1.4043 1.78645,1.94344 3.4149,1.61741l18.01291,-4.00296c0.11152,3.32812 0.80058,6.62059 2.06715,9.8774c1.32192,3.30459 3.78712,4.79288 7.3956,4.46489c0.09555,-0.00869 0.18999,-0.02382 0.2833,-0.0454c0.50047,0.46194 1.04815,0.82475 1.64305,1.08843l3.34767,10.229v28.03686c0,3.36259 1.6813,5.04389 5.04389,5.04389h26.27024v5.88454h-4.62356c-0.13801,0 -0.27468,0.01345 -0.41003,0.04035c-0.13535,0.0269 -0.26676,0.06676 -0.39426,0.11958c-0.1275,0.05282 -0.24862,0.11755 -0.36337,0.19419c-0.11475,0.07664 -0.22088,0.16379 -0.3184,0.26144c-0.09766,0.09752 -0.1848,0.20365 -0.26144,0.3184c-0.07664,0.11475 -0.14137,0.23587 -0.19419,0.36337c-0.05282,0.1275 -0.09268,0.25892 -0.11958,0.39426c-0.0269,0.13535 -0.04035,0.27202 -0.04035,0.41003v7.35567c0,0.13801 0.01345,0.27468 0.04035,0.41003c0.0269,0.13535 0.06676,0.26676 0.11958,0.39426c0.05282,0.1275 0.11755,0.24862 0.19419,0.36337c0.07664,0.11475 0.16379,0.22088 0.26144,0.3184c0.09752,0.09766 0.20365,0.1848 0.3184,0.26144c0.11475,0.07664 0.23587,0.14137 0.36337,0.19419c0.1275,0.05282 0.25892,0.09268 0.39426,0.11958c0.13535,0.0269 0.27202,0.04035 0.41003,0.04035h44.55432c0.13801,0 0.27468,-0.01345 0.41003,-0.04035c0.13535,-0.0269 0.26676,-0.06676 0.39426,-0.11958c0.1275,-0.05282 0.24862,-0.11755 0.36337,-0.19419c0.11475,-0.07664 0.22088,-0.16379 0.3184,-0.26144c0.09766,-0.09752 0.1848,-0.20365 0.26144,-0.3184c0.07664,-0.11475 0.14137,-0.23587 0.19419,-0.36337c0.05282,-0.1275 0.09268,-0.25892 0.11958,-0.39426c0.0269,-0.13535 0.04035,-0.27202 0.04035,-0.41003v-7.35567c0,-0.13801 -0.01345,-0.27468 -0.04035,-0.41003c-0.0269,-0.13535 -0.06676,-0.26676 -0.11958,-0.39426c-0.05282,-0.1275 -0.11755,-0.24862 -0.19419,-0.36337c-0.07664,-0.11475 -0.16379,-0.22088 -0.26144,-0.3184c-0.09752,-0.09766 -0.20365,-0.1848 -0.3184,-0.26144c-0.11475,-0.07664 -0.23587,-0.14137 -0.36337,-0.19419c-0.1275,-0.05282 -0.25892,-0.09268 -0.39426,-0.11958c-0.13535,-0.0269 -0.27202,-0.04035 -0.41003,-0.04035h-4.62356v-5.88454h26.27024c3.36259,0 5.04389,-1.6813 5.04389,-5.04389v-65.57052c0,-3.36259 -1.75135,-5.04389 -5.25405,-5.04389h-48.31496c-0.09793,-1.17452 -0.5528,-2.19122 -1.36458,-3.05008c-2.0523,-2.71249 -4.54468,-5.10554 -7.47714,-7.17913zM241.29616,158.7588l4.40247,-1.03589l10.82943,-2.45196l6.24832,-6.04678l12.39451,-11.97439l12.52838,-12.18508l-42.43989,9.36744l-30.80307,30.42031l16.93407,-3.76295l3.02213,-0.71119c0.01934,-0.02508 0.0393,-0.04974 0.05989,-0.07397l10.64239,-12.54288c-0.43588,-0.94895 -0.58397,-1.85097 -0.44428,-2.70604c0.26789,-1.64066 1.59548,-3.10829 3.98278,-4.40289c2.3873,-1.29445 4.34152,-1.60647 5.86268,-0.93606c0.91182,0.40183 1.66812,1.15659 2.26891,2.26429c0.60064,1.10783 0.82068,2.15346 0.66012,3.13688c-0.26803,1.64066 -1.59562,3.10829 -3.98278,4.40289c-2.09839,1.13782 -3.86229,1.5166 -5.29166,1.13634zM250.51113,174.59597c1.10097,-0.17388 2.38408,-0.40729 3.84932,-0.70026l24.02382,-15.88887c0.01709,-0.02046 0.03454,-0.04063 0.05233,-0.06053l0.00084,-0.00084l0.00946,-0.01051c1.73075,-1.92382 3.42431,-4.02341 5.08066,-6.29876c0.21843,-0.32869 0.35959,-0.55686 0.42348,-0.6845l0.04077,-0.00589c0,-0.23188 0.03734,-0.45752 0.11201,-0.67693c0.07468,-0.21941 0.1827,-0.42096 0.32407,-0.60464c0.0496,-0.46656 -0.03069,-0.80499 -0.24085,-1.01529c-0.07047,-0.07033 -0.13556,-0.14536 -0.19524,-0.22508c-1.8647,-2.48622 -4.16296,-4.67526 -6.89478,-6.56714l-11.18881,10.80947l-6.49043,6.28069c-0.46866,0.46866 -0.99897,0.73781 -1.59092,0.80744l-11.01375,2.49357l-7.06943,1.51485l2.92041,4.97579c0.29437,-0.05955 0.59189,-0.0957 0.89256,-0.10844c2.02484,-0.23202 3.74782,0.50278 5.16893,2.20439c0.35307,0.39706 0.66762,0.84583 0.94363,1.3463c0.23006,0.39076 0.4115,0.81088 0.54432,1.26034c0.13478,0.39244 0.23398,0.77739 0.29759,1.15484zM253.09003,143.98441c-0.26719,-0.49262 -1.0782,-0.37157 -2.43304,0.36316c-1.35485,0.73459 -1.89868,1.34826 -1.63149,1.84102c0.03124,0.05744 0.06984,0.10655 0.1158,0.14732c0.34817,0.30852 1.12058,0.13836 2.31725,-0.51048c1.3547,-0.73459 1.89853,-1.34826 1.63149,-1.84102zM248.47445,219.4586v-21.05864c0.07145,-0.01457 0.14193,-0.03286 0.21143,-0.05485c0.00294,-0.00084 0.00589,-0.00175 0.00882,-0.00274c0.10452,-0.03349 0.20582,-0.07489 0.3039,-0.1242c0.01401,-0.007 0.02788,-0.01415 0.04161,-0.02144l3.63748,-1.93244v13.10654c0,0.13801 0.01345,0.27468 0.04035,0.41003c0.0269,0.13535 0.06676,0.26676 0.11958,0.39426c0.05282,0.1275 0.11755,0.24862 0.19419,0.36337c0.07678,0.11475 0.16392,0.22088 0.26144,0.3184c0.09752,0.09766 0.20365,0.1848 0.3184,0.26144c0.11475,0.07664 0.23587,0.14137 0.36337,0.19419c0.1275,0.05282 0.25892,0.09268 0.39426,0.11958c0.13535,0.0269 0.27202,0.04035 0.41003,0.04035h76.91926c0.13801,0 0.27468,-0.01345 0.41003,-0.04035c0.13535,-0.0269 0.26676,-0.06676 0.39426,-0.11958c0.1275,-0.05282 0.24862,-0.11755 0.36337,-0.19419c0.11475,-0.07664 0.22088,-0.16379 0.3184,-0.26144c0.09766,-0.09752 0.1848,-0.20365 0.26144,-0.3184c0.07664,-0.11475 0.14137,-0.23587 0.19419,-0.36337c0.05282,-0.1275 0.09268,-0.25892 0.11958,-0.39426c0.0269,-0.13535 0.04035,-0.27202 0.04035,-0.41003v-50.01854c0,-0.13801 -0.01345,-0.27468 -0.04035,-0.41003c-0.0269,-0.13535 -0.06676,-0.26676 -0.11958,-0.39426c-0.05282,-0.1275 -0.11755,-0.24862 -0.19419,-0.36337c-0.07664,-0.11475 -0.16379,-0.22088 -0.26144,-0.3184c-0.09752,-0.09766 -0.20365,-0.1848 -0.3184,-0.26144c-0.11475,-0.07664 -0.23587,-0.14137 -0.36337,-0.19419c-0.1275,-0.05282 -0.25892,-0.09268 -0.39426,-0.11958c-0.13535,-0.0269 -0.27202,-0.04035 -0.41003,-0.04035h-47.03066c1.07981,-1.31618 1.91135,-2.37525 2.49462,-3.17723c0.01682,-0.02312 0.03321,-0.04659 0.04918,-0.07041c0.1799,-0.26999 0.35497,-0.58852 0.52519,-0.9556h49.21572c0.70054,0 1.05081,0.28022 1.05081,0.84065v65.57052c0,0.56043 -0.28022,0.84065 -0.84065,0.84065h-87.84768c-0.56043,0 -0.84065,-0.28022 -0.84065,-0.84065zM256.29016,155.50129c-0.01023,0.00939 -0.02024,0.01905 -0.03005,0.029zM256.88093,194.19777l3.34872,-1.91352l0.00358,-0.0021l0.0021,-0.00126c0.00407,-0.00224 0.00813,-0.00456 0.01219,-0.00694l0.00231,-0.00126c0.07804,-0.0454 0.15279,-0.09562 0.22424,-0.15068c0.00546,-0.0042 0.01086,-0.00841 0.01618,-0.01261c0.21647,-0.16981 0.39279,-0.3743 0.52898,-0.61346c0.13605,-0.23903 0.22186,-0.495 0.25745,-0.76793c0.00294,-0.02298 0.00553,-0.04602 0.00778,-0.06914c0.04035,-0.41542 -0.03636,-0.80801 -0.23013,-1.17775l-0.00294,-0.00567c-0.01093,-0.02087 -0.02228,-0.04147 -0.03405,-0.06179l-0.00358,-0.0063c-0.00308,-0.00561 -0.0063,-0.01114 -0.00966,-0.0166c-0.04399,-0.07496 -0.09254,-0.1469 -0.14564,-0.21583l-0.00231,-0.00294l-0.00042,-0.00084l-3.97479,-5.16704v-6.24706c3.41373,-0.62881 6.50745,-1.40549 9.28117,-2.33006c0.09443,-0.03153 0.1862,-0.06957 0.27531,-0.11412c0.03909,-0.01948 0.12091,-0.05709 0.24547,-0.11286c0.73753,-0.32982 1.30378,-0.68002 1.69874,-1.0506c4.26362,-3.65864 8.52269,-7.89046 12.77721,-12.69546h48.43812v45.8153h-72.71602zM235.41436,164.69041l3.57423,6.08965c-1.43569,1.35526 -2.04642,2.96819 -1.83219,4.83877c0.00294,0.06908 0.00708,0.13793 0.0124,0.20659c-0.75827,-0.25569 -1.31309,-0.82293 -1.66448,-1.70168c-1.16206,-2.98808 -1.75604,-6.01161 -1.78196,-9.07059zM248.37441,190.44617l-0.00882,-0.02669l-3.77829,-11.54525c-0.05786,-0.1771 -0.13787,-0.34347 -0.24,-0.49914c-0.10228,-0.15566 -0.22305,-0.29535 -0.36232,-0.41906c-0.13927,-0.12357 -0.29227,-0.22684 -0.45899,-0.30978c-0.16673,-0.08295 -0.34138,-0.1427 -0.52394,-0.17927c-0.39006,-0.07804 -0.74726,-0.29808 -1.07162,-0.66012c-0.05282,-0.10522 -0.11433,-0.20736 -0.18452,-0.30642c-0.61311,-1.39645 -0.28554,-2.49778 0.98272,-3.30395c1.3837,-0.58677 2.47445,-0.23987 3.27222,1.04072c0.08295,0.17079 0.15258,0.33289 0.2089,0.48631c0.1076,0.42873 0.10179,1.00233 -0.01744,1.72081l-0.00105,0.00589c-0.02494,0.14921 -0.03356,0.29941 -0.02585,0.45059c-0.01303,0.25976 0.02102,0.51328 0.10214,0.76058c0.08113,0.24715 0.20386,0.47146 0.36821,0.67294l6.50872,7.97816l2.80335,3.47104l-2.14365,1.1229l-0.01093,0.00567l-4.50398,2.39269zM252.67769,178.52999v0.30369l-0.21689,-0.26606c0.07215,-0.01247 0.14445,-0.02501 0.21689,-0.03762zM293.23894,218.82812c0.09639,0 0.19251,-0.00469 0.28834,-0.01408c0.09597,-0.00953 0.19118,-0.02368 0.28561,-0.04245c0.09457,-0.01878 0.18796,-0.04217 0.28014,-0.0702c0.09219,-0.02788 0.18284,-0.06032 0.27195,-0.0973c0.08897,-0.03685 0.17597,-0.07797 0.26102,-0.12336c0.0849,-0.0454 0.16743,-0.09486 0.24757,-0.14837c0.08014,-0.05366 0.15748,-0.11104 0.23202,-0.17212c0.0744,-0.06108 0.14571,-0.12568 0.21395,-0.19377c0.06809,-0.06823 0.13268,-0.13955 0.19377,-0.21395c0.06108,-0.07454 0.11846,-0.15188 0.17212,-0.23202c0.05352,-0.08014 0.10298,-0.16267 0.14837,-0.24757c0.0454,-0.08504 0.08652,-0.17206 0.12336,-0.26102c0.03699,-0.08911 0.06942,-0.17976 0.0973,-0.27195c0.02802,-0.09219 0.05142,-0.18557 0.0702,-0.28014c0.01878,-0.09443 0.03292,-0.18964 0.04245,-0.28561c0.00939,-0.09584 0.01408,-0.19195 0.01408,-0.28834c0,-0.09639 -0.00469,-0.19251 -0.01408,-0.28834c-0.00953,-0.09597 -0.02368,-0.19118 -0.04245,-0.28561c-0.01878,-0.09457 -0.04217,-0.18796 -0.0702,-0.28014c-0.02788,-0.09219 -0.06032,-0.18284 -0.0973,-0.27195c-0.03685,-0.08897 -0.07797,-0.17597 -0.12336,-0.26102c-0.0454,-0.0849 -0.09486,-0.16743 -0.14837,-0.24757c-0.05366,-0.08014 -0.11104,-0.15748 -0.17212,-0.23202c-0.06108,-0.0744 -0.12568,-0.14571 -0.19377,-0.21395c-0.06823,-0.06809 -0.13955,-0.13268 -0.21395,-0.19377c-0.07454,-0.06108 -0.15188,-0.11846 -0.23202,-0.17212c-0.08014,-0.05352 -0.16267,-0.10298 -0.24757,-0.14837c-0.08504,-0.0454 -0.17206,-0.08652 -0.26102,-0.12336c-0.08911,-0.03699 -0.17976,-0.06942 -0.27195,-0.0973c-0.09219,-0.02802 -0.18557,-0.05142 -0.28014,-0.0702c-0.09443,-0.01878 -0.18964,-0.03292 -0.28561,-0.04245c-0.09584,-0.00939 -0.19195,-0.01408 -0.28834,-0.01408c-0.09639,0 -0.19251,0.00469 -0.28834,0.01408c-0.09597,0.00953 -0.19118,0.02368 -0.28561,0.04245c-0.09457,0.01878 -0.18796,0.04217 -0.28014,0.0702c-0.09219,0.02788 -0.18284,0.06032 -0.27195,0.0973c-0.08897,0.03685 -0.17597,0.07797 -0.26102,0.12336c-0.0849,0.0454 -0.16743,0.09486 -0.24757,0.14837c-0.08014,0.05366 -0.15748,0.11104 -0.23202,0.17212c-0.0744,0.06108 -0.14571,0.12568 -0.21395,0.19377c-0.06809,0.06823 -0.13268,0.13955 -0.19377,0.21395c-0.06108,0.07454 -0.11846,0.15188 -0.17212,0.23202c-0.05352,0.08014 -0.10298,0.16267 -0.14837,0.24757c-0.0454,0.08504 -0.08652,0.17206 -0.12336,0.26102c-0.03699,0.08911 -0.06942,0.17976 -0.0973,0.27195c-0.02802,0.09219 -0.05142,0.18557 -0.0702,0.28014c-0.01878,0.09443 -0.03292,0.18964 -0.04245,0.28561c-0.00939,0.09584 -0.01408,0.19195 -0.01408,0.28834c0,0.09639 0.00469,0.19251 0.01408,0.28834c0.00953,0.09597 0.02368,0.19118 0.04245,0.28561c0.01878,0.09457 0.04217,0.18796 0.0702,0.28014c0.02788,0.09219 0.06032,0.18284 0.0973,0.27195c0.03685,0.08897 0.07797,0.17597 0.12336,0.26102c0.0454,0.0849 0.09486,0.16743 0.14837,0.24757c0.05366,0.08014 0.11104,0.15748 0.17212,0.23202c0.06108,0.0744 0.12568,0.14571 0.19377,0.21395c0.06823,0.06809 0.13955,0.13268 0.21395,0.19377c0.07454,0.06108 0.15188,0.11846 0.23202,0.17212c0.08014,0.05352 0.16267,0.10298 0.24757,0.14837c0.08504,0.0454 0.17206,0.08652 0.26102,0.12336c0.08911,0.03699 0.17976,0.06942 0.27195,0.0973c0.09219,0.02802 0.18557,0.05142 0.28014,0.0702c0.09443,0.01878 0.18964,0.03292 0.28561,0.04245c0.09584,0.00939 0.19195,0.01408 0.28834,0.01408zM279.78858,230.38702v-5.88454h26.90073v5.88454zM313.41448,237.74269v-3.15243h-40.35109v3.15243z" data-paper-data="{&quot;isPathIcon&quot;:true}"></path></g></g></g></svg>
        
      </span>
      <span class="logo-sm">
        <img src="/assets/images/logo_sm.png" alt="" height="16">
      </span>
    </router-link>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
      <span class="logo-lg">
        <img src="/assets/images/logo-dark.png" alt="" height="16">
      </span>
      <span class="logo-sm">
        <img src="/assets/images/logo_sm_dark.png" alt="" height="16">
      </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

      <!--- Sidemenu -->
      <ul class="side-nav">

        <li class="side-nav-title side-nav-item">Pages</li>


        <li class="side-nav-item">
          <router-link class="side-nav-link " :to="{ name: 'statistiques' }">
            <i class="dripicons-home"></i>
            <span> Dashboards </span>
          </router-link>
        </li>

        <li class="side-nav-title side-nav-item">Services</li>

        <template v-if="authStore.is_super_admin">
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'manage_department_head_account' }">
              <i class="dripicons-graduation"></i>
              <span>
                Manage department head acccount
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'manage_department' }">
              <i class="dripicons-store"></i>
              <span>
                Manage department 
              </span>
            </router-link>
          </li>


      
        </template>
        <template v-if="authStore.is_department_head">
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'manageStudentsAccounts' }">

              <i class="dripicons-graduation"></i>
              <span>
                Manage Students Information
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">

            <router-link class="side-nav-link d-flex align-items-center"
              :to="{ name: 'departmentHeadManageInternshipRequests' }">

              <i class="uil-package"></i>
              <span>
                Manage Internship Requests
              </span>
            </router-link>
          </li>


          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center"
              :to="{ name: 'manageInternshipResponsibleAccounts' }">

              <i class="dripicons-briefcase"></i>
              <span>
                Manage Internship Head Accounts
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <div role="button" @click="show_manage_modal()" class="side-nav-link d-flex align-items-center">
              <i class="dripicons-document-delete"></i>
              <span>Manage Causes</span>
            </div>
          </li>

        </template>




        <template v-if="authStore.is_internship_responsible">
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'offers' }">
              <i class="uil-package"></i>
              <span>
                Manage Offers
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">

            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'marks' }">
              <i class="dripicons-document-edit"></i>
              <span>
                Manage Marks
              </span>
            </router-link>
          </li>


          <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#assessment_items" aria-expanded="false" aria-controls="assessment_items"
              class="side-nav-link collapsed">
              <i class="dripicons-calendar"></i>
              <span> Assessments </span>
              <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="assessment_items" style="">
              <ul class="side-nav-second-level">

                <li class="side-nav-item">
                  <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'assessments' }">
                    <i class="dripicons-checkmark"></i>
                    <span>
                      Manage Assessments
                    </span>
                  </router-link>
                </li>

                <li class="side-nav-item">
                  <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'assessStudents' }">

                    <i class="dripicons-graduation"></i>
                    <span>
                      Assess Students
                    </span>
                  </router-link>
                </li>

              </ul>
            </div>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center"
              :to="{ name: 'internshipResponsibleManageInternshipRequests' }">

              <i class="dripicons-briefcase"></i>
              <span>
                Manage Internship Requests
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'allStudents' }">
              <i class="dripicons-user"></i>
              <span>
                All Students
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <div role="button" @click="show_manage_modal()" class="side-nav-link d-flex align-items-center">
              <i class="dripicons-document-delete"></i>
              <span>Manage Causes</span>
            </div>
          </li>

        </template>




        <template v-if="authStore.is_student">

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentInternshipRequests' }">
              <i class="uil-package"></i>
              <span>My Requests</span>
              <span class="badge bg-success ms-auto">{{ studentStore.requested_internships }}</span>
            </router-link>
          </li>
          <li class="side-nav-item">

            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentOffers' }">
              <i class="dripicons-to-do"></i>
              <span>
              Companies's Offers
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'studentCv' }">
              <i class="uil-folder-plus"></i>
              <span>
              My cv
              </span>
            </router-link>
          </li>

          <li class="side-nav-item">
            <router-link class="side-nav-link d-flex align-items-center" :to="{ name: 'passedInternships' }">

              <i class="dripicons-checkmark"></i>
              <span>
                Passed / Current Internships
              </span>
              <span class="badge bg-success float-end">{{ studentStore.passed_internships }}</span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link " :to="{ name: 'acceptedInternships' }">

              <i class="dripicons-clock"></i>
              <span class="badge bg-success float-end">{{ studentStore.accepted_internships }}</span>
              <span>
                Waiting for validation
              </span>
            </router-link>
          </li>
          <li class="side-nav-item">
            <router-link class="side-nav-link " :to="{ name: 'refusedInternships' }">

              <i class="dripicons-cross"></i>
              <span class="badge bg-danger text-white float-end">{{ studentStore.refused_internships }}</span>
              <span>
                Refused Internship
              </span>
            </router-link>
          </li>

        </template>


      </ul>
      <!-- End Sidebar -->

      <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

  </div>
  <FullWidthModal modalId="cause-modal" v-if="authStore.is_department_head || authStore.is_internship_responsible">
    <template v-slot:body>
      <div class="row">
        <template v-for="cause, index in causes" :key="index">
          <div class="col-md-6">

            <CustomTextAria v-model="cause.cause" :errorText="getErrorText(errors, 'note')"
              :showError="errors.hasOwnProperty('note')" label="Enter a Note" placeholder="Enter a Note"
              :readonly="edited_cause_index != index" />

            <button v-if="edited_cause_index == index" type="button" @click="save_cause(cause)"
              class="btn btn-light me-2 mb-1 ">Save</button>
            <button v-else type="button" @click="edited_cause_index = index"
              class="btn btn-light me-2 mb-1 ">Edit</button>
            <button type="button" @click="delete_cause(cause.id)" class="btn btn-light mb-2 mt-1">Delete</button>
          </div>

          <hr v-if="index % 2 == 1">
        </template>
        <nav v-if="isPaginationActive">
          <ul class="pagination pagination-rounded mb-0 justify-content-center">
            <li class="page-item">
              <button :disabled="prevLink == null" class="page-link" @click="get_causes(prevLink)" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </button>
            </li>
            <li v-for="page_index in pagination.meta?.last_page" class="page-item"
              :class="{ 'active': isActive(page_index) }"><a class="page-link" @click="get_causes(page_index)"
                role="button">{{ page_index }}</a>
            </li>
            <li class="page-item">
              <button :disabled="nextLink == null" class="page-link" @click="get_causes(nextLink)" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </button>
            </li>
          </ul>
        </nav>

      </div>
    </template>
    <template v-slot:buttons>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      <button type="button" @click="show_add_modal" class="btn btn-light" data-bs-dismiss="modal">Add new Cause</button>
    </template>
  </FullWidthModal>

  <StandardModal id="add-cause-modal" modal-header="Add New Cause" v-if="authStore.is_department_head || authStore.is_internship_responsible">
    <template v-slot:body>
      <div class="row">
        <div class="col">
          <CustomTextAria v-model="current_cause.cause" :errorText="getErrorText(errors, 'cause')"
            :showError="errors.hasOwnProperty('cause')" label="Enter a Cause" placeholder="Enter a Cause" />
        </div>
      </div>
    </template>
    <template v-slot:buttons>
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      <button type="button" @click="save_cause" class="btn btn-light">Save</button>
    </template>
  </StandardModal>
</template>