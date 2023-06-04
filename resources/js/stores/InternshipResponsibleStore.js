import { defineStore } from 'pinia';
import useInternshipRequest from '@/composables/InternshipRequests.js';

import useOffer from '@/composables/Offer.js';

const {
    getInternshipsAcceptedByInternshipResponsible,
    getInternshipsAcceptedByStudent,
    internshipsAcceptedByInternshipResponsible,
    studentsRequests } = useInternshipRequest();
    const {
        getOffers,
    } = useOffer();

export const useInternshipResponsibleStore = defineStore('internship_responsible', {

    state: () => ({
        all_students: 0,
        wating_internship_requests :0,
        offers_number: 0,
    }),
    actions: {
        async count_all_students() {
            await getInternshipsAcceptedByInternshipResponsible()
            await getInternshipsAcceptedByStudent()
            this.all_students = studentsRequests.value.length + internshipsAcceptedByInternshipResponsible.value.length
        },
        async count_wating_internship_requests() {
            await getInternshipRequests()
            this.wating_internship_requests = studentsRequests.value.length;
        },
        async count_offers() {
            await getOffers()
            this.offers_number = offers.value.length

        },
    },
})