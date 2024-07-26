<template>
    <NavBar class="position-relative bg-black"></NavBar>
    <ReservationEvent @services-selected="handleServicesSelected"></ReservationEvent>
    <ReservationEmployee @employee-selected="handleEmployeeSelected"></ReservationEmployee>
    <ReservationDateTime
        v-if="canShowDateTime"
        :employee-id="selectedEmployee"
        @date-selected="handleDateSelected"
        @time-selected="handleTimeSelected"
    ></ReservationDateTime>
    <ReservationContactInfo
        v-if="canShowContactInfo"
        @contact-info-submitted="handleContactInfoSubmitted"
        @open-modal="openModal"
    ></ReservationContactInfo>
    <v-dialog v-model="isModalOpen" max-width="600">
        <v-card>
            <v-card-title>
                <span class="headline">{{$t('reservation_modal.confirmReservation')}}</span>
            </v-card-title>
            <v-card-text>
                <div><strong>{{$t('reservation_modal.services')}}:</strong> {{ selectedServiceNames.join(', ') }}</div>
                <div><strong>{{$t('reservation_modal.employee')}}:</strong> {{ selectedEmployeeName }}</div>
                <div><strong>{{$t('reservation_modal.date')}}:</strong> {{ selectedDate }}</div>
                <div><strong>{{$t('reservation_modal.time')}}:</strong> {{ selectedTime }} - {{ endTime }}</div>
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
    <SnackComponent :color="snackColor" :snack-open="snackOpen" :text="snackText"></SnackComponent>
    <FooterComponent></FooterComponent>
</template>

<script>
import NavBar from '@/components/NavBar.vue';
import ReservationEvent from '@/components/reservation/ReservationEvent.vue';
import ReservationEmployee from '@/components/reservation/ReservationEmployee.vue';
import ReservationDateTime from '@/components/reservation/ReservationDateTime.vue';
import ReservationContactInfo from '@/components/reservation/ReservationContactInfo.vue';
import FooterComponent from '@/components/FooterComponent.vue';
import SnackComponent from "@/components/common/SnackComponent.vue";
import axiosInstance from '@/axios.js'

export default {
    name: 'ReservationView',
    components: {
        FooterComponent,
        ReservationContactInfo,
        ReservationDateTime,
        ReservationEmployee,
        ReservationEvent,
        NavBar,
        SnackComponent
    },
    data() {
        return {
            selectedServices: [],
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
            isModalOpen: false,
            endTime: '',
            snackText: '',
            snackColor: 'danger',
            snackOpen: false,
        };
    },
    computed: {
        canShowDateTime() {
            return this.selectedServices.length > 0 && this.selectedEmployee !== '';
        },
        canShowContactInfo() {
            return this.selectedDate !== null && this.selectedTime !== null;
        },
        selectedServiceNames() {
            return this.selectedServices.map(service => service.name);
        }
    },
    methods: {
        handleServicesSelected({ services }) {
            this.selectedServices = services;
            this.calculateEndTime();
        },
        handleEmployeeSelected(employee) {
            this.selectedEmployee = employee.id;
            this.selectedEmployeeName = employee.first_name;
        },
        handleDateSelected(date) {
            this.selectedDate = date;
            this.selectedTime = null;
            this.endTime = '';
        },
        handleTimeSelected(time) {
            this.selectedTime = time;
            this.calculateEndTime();
        },
        handleContactInfoSubmitted(contactInfo) {
            this.contactInfo = contactInfo;
        },
        openModal() {
            if (this.validateForm()) {
                this.isModalOpen = true;
            }
        },
        validateForm() {
            if (!this.selectedServices.length) {
                this.showSnackbar(this.$t("reservation_errors.servicesNotSelected"));
                return false;
            }
            if (!this.selectedEmployee) {
                this.showSnackbar(this.$t("reservation_errors.employeeNotSelected"));
                return false;
            }
            if (!this.selectedDate) {
                this.showSnackbar(this.$t("reservation_errors.dateNotSelected"));
                return false;
            }
            if (!this.selectedTime) {
                this.showSnackbar(this.$t("reservation_errors.timeNotSelected"));
                return false;
            }
            if (!this.contactInfo.firstName) {
                this.showSnackbar(this.$t("reservation_errors.firstNameNotEntered"));
                return false;
            }
            if (!this.contactInfo.lastName) {
                this.showSnackbar(this.$t("reservation_errors.lastNameNotEntered"));
                return false;
            }
            if (!this.validatePhoneNumber(this.contactInfo.phoneNumber)) {
                this.showSnackbar(this.$t("reservation_errors.phoneNotValid"));
                return false;
            }
            if (!this.validateEmail(this.contactInfo.email)) {
                this.showSnackbar(this.$t("reservation_errors.emailNotValid"));
                return false;
            }
            return true;
        },
        validatePhoneNumber(phoneNumber) {
            const phoneRegex = /^09\d{2} \d{3} \d{3}$|^09\d{8}$/;
            return phoneRegex.test(phoneNumber);
        },
        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },
        async showSnackbar(message, color) {
            this.snackOpen = true;
            this.snackText = message;
            this.snackColor = color;

            await this.sleep(2000);
            this.snackOpen = false;
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        calculateEndTime() {
            if (!this.selectedTime || !this.selectedServices.length) {
                this.endTime = '';
                return;
            }

            const totalDuration = this.selectedServices.reduce((acc, service) => acc + service.duration, 0);

            const [hours, minutes] = this.selectedTime.split(':').map(Number);
            const startDateTime = new Date(this.selectedDate);
            startDateTime.setHours(hours, minutes);

            const endDateTime = new Date(startDateTime.getTime() + totalDuration * 60000);
            const endHours = endDateTime.getHours().toString().padStart(2, '0');
            const endMinutes = endDateTime.getMinutes().toString().padStart(2, '0');

            this.endTime = `${endHours}:${endMinutes}`;
        },
        async submitReservation()
        {
            const totalDuration = this.selectedServices.reduce((acc, service) => acc + service.duration, 0);
            const [hours, minutes] = this.selectedTime.split(':').map(Number);
            const startDateTime = new Date(this.selectedDate);
            startDateTime.setHours(hours, minutes);
            const endDateTime = new Date(startDateTime.getTime() + totalDuration * 60000);

            const reservationData = {
                services: this.selectedServices.map(service => service.id),
                employee_id: this.selectedEmployee,
                datetime_from: `${this.selectedDate} ${this.selectedTime}`,
                datetime_to: `${endDateTime.toISOString().slice(0, 10)} ${endDateTime.toTimeString().slice(0, 5)}`,
                first_name: this.contactInfo.firstName,
                last_name: this.contactInfo.lastName,
                phone_number: this.contactInfo.phoneNumber,
                email: this.contactInfo.email
            };

            try {
                await axiosInstance.post('/orders', reservationData, {})

                this.$router.push({
                    name: 'reservation-complete',
                    query: {
                        email: this.contactInfo.email
                    }
                });
                this.isModalOpen = false;
            } catch (error) {
                await this.showSnackbar("Error creating order: " + error, "red");
            }
        }
,
        close() {
            this.isModalOpen = false;
            this.snackColor = "danger";
        }
    }
}
</script>

<style scoped>
</style>
