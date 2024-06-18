<template>
    <NavBar class="position-relative bg-black"></NavBar>
    <ReservationEvent @services-selected="handleServicesSelected"></ReservationEvent>
    <ReservationEmployee @employee-selected="handleEmployeeSelected"></ReservationEmployee>
    <ReservationDateTime v-if="canShowDateTime" @date-selected="handleDateSelected" @time-selected="handleTimeSelected"></ReservationDateTime>
    <ReservationContactInfo v-if="canShowContactInfo" @contact-info-submitted="handleContactInfoSubmitted" @open-modal="openModal"></ReservationContactInfo>
    <v-dialog v-model="isModalOpen" max-width="600">
        <v-card>
            <v-card-title>
                <span class="headline">{{$t('reservation_modal.confirmReservation')}}</span>
            </v-card-title>
            <v-card-text>
                <div><strong>{{$t('reservation_modal.services')}}:</strong> {{ selectedServiceNames.join(', ') }}</div>
                <div><strong>{{$t('reservation_modal.employee')}}:</strong> {{ selectedEmployeeName }}</div>
                <div><strong>{{$t('reservation_modal.date')}}:</strong> {{ selectedDate }}</div>
                <div><strong>{{$t('reservation_modal.time')}}:</strong> {{ selectedTime }}</div>
                <div><strong>{{$t('reservation_modal.contactInfo')}}:</strong></div>
                <div>{{$t('reservation.firstName')}}: {{ contactInfo.firstName }}</div>
                <div>{{$t('reservation.lastName')}}: {{ contactInfo.lastName }}</div>
                <div>{{$t('reservation.phoneNumber')}}: {{ contactInfo.phoneNumber }}</div>
                <div>{{$t('reservation.email')}}: {{ contactInfo.email }}</div>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" @click="close">{{$t('buttons.cancel')}}</v-btn>
                <v-btn color="blue darken-1" @click="submitReservation">{{$t('buttons.submit')}}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <FooterComponent></FooterComponent>
</template>

<script>
import axios from 'axios';
import NavBar from '@/components/NavBar.vue';
import ReservationEvent from '@/components/reservation/ReservationEvent.vue';
import ReservationEmployee from '@/components/reservation/ReservationEmployee.vue';
import ReservationDateTime from '@/components/reservation/ReservationDateTime.vue';
import ReservationContactInfo from '@/components/reservation/ReservationContactInfo.vue';
import FooterComponent from '@/components/FooterComponent.vue';

export default {
    name: 'ReservationView',
    components: {
        FooterComponent,
        ReservationContactInfo,
        ReservationDateTime,
        ReservationEmployee,
        ReservationEvent,
        NavBar
    },
    data() {
        return {
            selectedServices: [],
            selectedServiceNames: [],
            selectedEmployee: '',
            selectedEmployeeName: '',
            selectedDate: null,
            selectedTime: null,
            contactInfo: {
                firstName: '',
                lastName: '',
                phoneNumber: '',
                email: ''
            },
            isModalOpen: false
        };
    },
    computed: {
        canShowDateTime() {
            return this.selectedServices.length > 0 && this.selectedEmployee !== '';
        },
        canShowContactInfo() {
            return this.selectedDate !== null && this.selectedTime !== null;
        }
    },
    methods: {
        handleServicesSelected(services) {
            this.selectedServices = services.ids;
            this.selectedServiceNames = services.names;
        },
        handleEmployeeSelected(employee) {
            this.selectedEmployee = employee.id;
            this.selectedEmployeeName = employee.name;
        },
        handleDateSelected(date) {
            this.selectedDate = date;
            this.selectedTime = null;
        },
        handleTimeSelected(time) {
            this.selectedTime = time;
        },
        handleContactInfoSubmitted(contactInfo) {
            this.contactInfo = contactInfo;
        },
        openModal() {
            this.isModalOpen = true;
        },
        submitReservation() {
            const reservationData = {
                services: this.selectedServices,
                employee: this.selectedEmployee,
                date: this.selectedDate,
                time: this.selectedTime,
                contactInfo: this.contactInfo
            };

            console.log(reservationData);
            this.isModalOpen = false;
        }
    }
}
</script>

<style scoped>
</style>
