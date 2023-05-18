import { defineStore } from 'pinia';
import useInternshipRequest from '@/composables/InternshipRequests.js';


const {
    getInternshipsAcceptedByDepartmentHead,
    getInternshipsAcceptedByInternshipResponsible,
    getInternshipRequests,
    getMyPassedInternships,
    getRefusedInternships,
    internshipsAcceptedByDepartmentHead,
    internshipsAcceptedByInternshipResponsible,
    studentsRequests,
    passedInternships,
    refusedRequests,
} = useInternshipRequest();

export const useStudentStore = defineStore('student', {

    state: () => ({
        refused_internships: 0,
        accepted_internships: 0,
        passed_internships: 0,
        requested_internships: 0,
    }),
    actions: {
       async count_refused_internships() {

            await getRefusedInternships();
            this.refused_internships = refusedRequests.value.length
        },
        async count_accepted_internships() {
            await getInternshipsAcceptedByDepartmentHead();
            await getInternshipsAcceptedByInternshipResponsible();
            this.accepted_internships = internshipsAcceptedByDepartmentHead.value.length +
            internshipsAcceptedByInternshipResponsible.value.length ;
        },
        async count_passed_internships() {
            await getMyPassedInternships();
            this.passed_internships = passedInternships.value.length

        },
        async count_requested_internships() {
            await getInternshipRequests();
            this.requested_internships = studentsRequests.value.length
        },

    },
})