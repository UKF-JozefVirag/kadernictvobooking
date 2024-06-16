<template>
    <NavBar class="position-relative bg-black"></NavBar>
    <ReservationEvent @services-selected="handleServicesSelected"></ReservationEvent>
    <ReservationEmployee @employee-selected="handleEmployeeSelected"></ReservationEmployee>
    <ReservationDateTime v-if="canShowDateTime" @date-selected="handleDateSelected" @time-selected="handleTimeSelected"></ReservationDateTime>
    <ReservationContactInfo v-if="canShowContactInfo"></ReservationContactInfo>
    <FooterComponent></FooterComponent>
</template>

<script>
import NavBar from '@/components/NavBar.vue';
import ReservationEvent from '@/components/reservation/ReservationEvent.vue';
import ReservationEmployee from '@/components/reservation/ReservationEmployee.vue';
import ReservationDateTime from '@/components/reservation/ReservationDateTime.vue';
import TimePicker from '@/components/reservation/TimePicker.vue'
import ReservationContactInfo from '@/components/reservation/ReservationContactInfo.vue'
import FooterComponent from '@/components/FooterComponent.vue'

export default {
    name: 'ReservationView',
    components: {
        FooterComponent,
        ReservationContactInfo,
        TimePicker,
        ReservationDateTime,
        ReservationEmployee,
        ReservationEvent,
        NavBar
    },
    data() {
        return {
            selectedServices: [],
            selectedEmployee: '',
            selectedDate: null,
            selectedTime: null
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
            this.selectedServices = services;
        },
        handleEmployeeSelected(employee) {
            this.selectedEmployee = employee;
        },
        handleDateSelected(date) {
            this.selectedDate = date;
        },
        handleTimeSelected(time) {
            this.selectedTime = time;
        }
    }
}
</script>

<style scoped>
</style>
