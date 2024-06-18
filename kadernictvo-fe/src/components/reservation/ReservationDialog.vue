<template>
    <v-dialog v-model="isOpen" max-width="600">
        <v-card>
            <v-card-title>
                <span class="headline">{{$t('reservation_modal.confirmReservation')}}</span>
            </v-card-title>
            <v-card-text>
                <div><strong>{{$t('reservation_modal.services')}}:</strong> {{ services.join(', ') }}</div>
                <div><strong>{{$t('reservation_modal.employee')}}:</strong> {{ employeeName }}</div>
                <div><strong>{{$t('reservation_modal.date')}}:</strong> {{ formattedDate }}</div>
                <div><strong>{{$t('reservation_modal.time')}}:</strong> {{ time }}</div>
                <div><strong>{{$t('reservation_modal.contactInfo')}}:</strong></div>
                <div>{{$t('reservation.firstName')}}: {{ contactInfo.firstName }}</div>
                <div>{{$t('reservation.lastName')}}: {{ contactInfo.lastName }}</div>
                <div>{{$t('reservation.phoneNumber')}}: {{ contactInfo.phoneNumber }}</div>
                <div>{{$t('reservation.email')}}: {{ contactInfo.email }}</div>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" @click="close">{{$t('buttons.cancel')}}</v-btn>
                <v-btn color="blue darken-1" @click="submit">{{$t('buttons.submit')}}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'ReservationDialog',
    props: {
        isOpen: {
            type: Boolean,
            required: true
        },
        services: {
            type: Array,
            required: true
        },
        employeeName: {
            type: String,
            required: true
        },
        date: {
            type: Date,
            required: true
        },
        time: {
            type: String,
            required: true
        },
        contactInfo: {
            type: Object,
            required: true
        }
    },
    computed: {
        formattedDate() {
            if (!this.date) return '';
            const day = String(this.date.getDate()).padStart(2, '0');
            const month = String(this.date.getMonth() + 1).padStart(2, '0');
            const year = this.date.getFullYear();
            return `${day}/${month}/${year}`;
        }
    },
    methods: {
        close() {
            this.$emit('update:isOpen', false);
        },
        submit() {
            this.$emit('submit');
            this.close();
        }
    }
}
</script>

<style scoped>
</style>
