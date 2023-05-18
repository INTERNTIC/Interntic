<script setup>
import { onMounted, ref, onBeforeUnmount } from 'vue';
import DangerModalOutline from '../modal/DangerModalOutline.vue';


import useInternshipRequest from '@/composables/InternshipRequests.js';
import SelectInput from '../form/SelectInput.vue';
// import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { Notify, getErrorText, refreshTable } from "@/newShared";
import {
    generalErrorMsg,
    generalSuccessMsg,
    errors
} from "@/axiosClient";

import useCv_item from '@/composables/Cv_Item';

const ckConfig = ref({
    toolbar: {
        items: [
            'selectAll', '|',
            'heading', '|',
            'bold', 'italic', '|',
            'bulletedList', 'numberedList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|'
        ],
        shouldNotGroupWhenFull: true
    }
});

const {
    getCvItems,
    storeCvItem,
    updateCvItem,
    destroyCvItem,
    cvItems,
} = useCv_item();

const cv_itemObject = {
    id: "",
    details: `
    <h3><span class="ql-size-large">Hello World!</span></h3><p><br></p><h3>This is an simple editable area.</h3> <p><br></p><ul>    <li>        Select a text to reveal the toolbar.    </li>    <li>        Edit rich document on-the-fly, so elastic!    </li></ul><p><br></p><p>    End of simple area</p>
    `,
}


const currentCv_item = ref(_.cloneDeep(cv_itemObject))

let formData = new FormData();


const onFileChange = async (event) => {
    formData = new FormData();
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        formData.append('image[]', files[i]);
    }

};
const saveCvItem = async () => {
    formData.append("details", currentCv_item.value.details)
    if (currentCv_item.value.id != "") {
        await updateCvItem(currentCv_item.value.id, formData)
    } else {
        await storeCvItem(formData);
    }

    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getCvItems();
        currentCv_item.value = _.cloneDeep(cv_itemObject);
        formData = new FormData();
        $("#full-width-modal").modal("hide");
    }
}
const openEditModal = async (cvItem) => {
    currentCv_item.value = cvItem
    $('#full-width-modal').modal('show')

}
const openDeleteModal = async (cvItemId) => {
    currentCv_item.value.id = cvItemId
    $("#danger-header-modal").modal("show");
}
const deleteCvItem = async () => {
    await destroyCvItem(currentCv_item.value.id);
    Notify(generalSuccessMsg.value, generalErrorMsg.value)
    if (generalErrorMsg.value == "") {
        await getCvItems();
        currentCv_item.value = _.cloneDeep(cv_itemObject);
        $("#danger-header-modal").modal("hide");
    }
}


const editor = ClassicEditor;
onMounted(async () => {
    await getCvItems()
    window.addEventListener('keydown', handleKeyDown);

});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeyDown);
})
// in the ckEditor plugin there is an error when trying to delete an empty text 
// so i disable the delete button effect on this component
function handleKeyDown(event) {
    if (event.keyCode === 46) { // 46 is the key code for the delete key
        event.preventDefault(); // Prevent the default behavior of the delete key
    }
}
const selectedFile = ref(null);





</script>
<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Manage Students</h4>
                <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#full-width-modal">Add a New Post</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-for="cvItem in cvItems" :key="cvItem.id">
            <div class="card">

                <!-- <button type="button" class="btn btn-success" >Add a Request</button> -->
                <div class="card-body position-relative">

                    <div class="menu-icon-container" role="button">

                        <div class="dropdown">
                            <div role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="dripicons-menu lead"></i>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div @click="openEditModal(cvItem)" class="dropdown-item" role="bttun">Edit</div>
                                <div @click="openDeleteModal(cvItem.id)" class="dropdown-item" role="buttn">Delete</div>
                            </div>
                        </div>
                    </div>
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
    <!-- Full width modal -->
    <FullWidthModal>
        <template v-slot:body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Internship Offer</h4>
                            <p class="text-muted font-14">
                                Enter Internship offer Details
                            </p>
                            <div class="row">
                                <div>
                                    <ckeditor :editor="editor" v-model="currentCv_item.details" :config="ckConfig">
                                    </ckeditor>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <input type="file" @change="onFileChange" class="form-control" multiple>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:buttons>

            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="saveCvItem" type="button" class="btn btn-success">Save</button>
            <!-- <button @click="applyAnImage" type="button" class="btn btn-success">Apply an Image</button> -->

        </template>
    </FullWidthModal>

    <DangerModalOutline>
        <template v-slot:body>
            are you sure you want to continue?
        </template>
        <template v-slot:buttons>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button @click="deleteCvItem" type="button" class="btn btn-danger" data-bs-dismiss="modal">Continue</button>
        </template>
    </DangerModalOutline>
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





