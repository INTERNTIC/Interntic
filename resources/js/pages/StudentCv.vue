<script setup>
import { onMounted, computed, watch, } from 'vue';
import useCv_item from '@/composables/Cv_Item';
import useStudent from '@/composables/Student';
import { useRoute } from 'vue-router';

const route = useRoute();
const student_id = route.params.student_id;

const {
    getCvItems,
    cvItems,
} = useCv_item();
const {
    get_student,
    student,
} = useStudent();

onMounted(async () => {
    await getCvItems(student_id)
    await get_student(student_id)
});


const full_name = computed(() => {
    if (student.value) {
        return `${student?.value?.first_name} ${student?.value?.last_name} `;
    }
}
)
</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">{{ full_name }} Cv </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="cvItem in cvItems" :key="cvItem.id">
            <div class="card">

                <!-- <button type="button" class="btn btn-success" >Add a Request</button> -->
                <div class="card-body position-relative">

                    <div v-html="cvItem.details">
                    </div>


                    <div v-if="cvItem.image" :id="`carouselExampleFade_${cvItem.id}`" class="carousel slide carousel-fade"
                        data-bs-ride="carousel">
                        <div class="carousel-inner">

                            <div v-for="(image, index) in cvItem.image.split('|')" :class="{ 'active': index == 0 }"
                                class="carousel-item">

                                <img style="height: 300px;object-fit: contain;" class="rounded mx-auto d-block img-fluid"
                                    :src="`/uploads/${image}`" alt="First slide">
                            </div>

                        </div>
                        <a class="carousel-control-prev" :href="`#carouselExampleFade_${cvItem.id}`" role="button"
                            data-bs-slide="prev">
                            <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
                            <ul class="pagination pagination-rounded mb-0 justify-content-center">
                                <li class="page-item">
                                    <button class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </button>
                                </li>
                            </ul>


                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" :href="`#carouselExampleFade_${cvItem.id}`" role="button"
                            data-bs-slide="next">
                            <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                            <ul class="pagination pagination-rounded mb-0 justify-content-center">
                                <li class="page-item">
                                    <button class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </button>
                                </li>
                            </ul>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>


                </div> <!-- end card-body -->
            </div>
        </div>
    </div> <!-- end row-->
</template>
<style scoped>
.carousel-control-next-icon,
.carousel-control-prev-icon {
    width: 3rem;
    height: 3rem;
}

.carousel-inner {

    border-radius: 0.3rem;
}

.menu-icon-container {
    position: absolute;
    right: 1rem;
    top: 0.5rem;
}

.page-link {
    background: unset;
    border: 1px solid black;
}

.page-link span {
    font-size: 2rem;
    padding: inherit;
}
</style>



<!-- background: black; -->





