<template>
    <v-container>
        <v-row class="mt-5">
            <v-col>
                <SectionDescriber :section-name="$t('reservation.thirdSectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="12" md="6">
                <vue-cal
                    class="vuecal--date-picker shadow-lg"
                    :disable-views="['years', 'year', 'week', 'day']"
                    hide-view-selector
                    active-view="month"
                    :locale="$i18n.locale"
                    :transitions="false"
                    :min-date="minDate"
                    style="height: 400px"
                    @cell-click="onDateClick">
                </vue-cal>
            </v-col>
            <v-col cols="12" sm="12" md="6" v-if="selectedDate">
                <TimePicker
                    :selected-date="selectedDate"
                    :unavailable-times="getUnavailableTimesForSelectedDate"
                    :employee-id="employeeId"
                    @time-selected="onTimeSelected"
                ></TimePicker>
            </v-col>
        </v-row>
        <div class="mt-3" style="border-bottom: 1px solid #ececec;"></div>
    </v-container>
    <SnackComponent color="warning" :text="snackText" :snackOpen="snackOpen"></SnackComponent>
</template>

<script>
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import SectionDescriber from '@/components/home/SectionDescriber.vue';
import TimePicker from '@/components/reservation/TimePicker.vue';
import axiosInstance from '@/axios.js'
import SnackComponent from '@/components/common/SnackComponent.vue'

export default {
    name: 'ReservationDateTime',
    components: {
        SnackComponent,
        TimePicker,
        SectionDescriber,
        VueCal,
    },
    props: {
        employeeId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            selectedDate: null,
            minDate: new Date().toISOString().split('T')[0],
            orders: [],
            snackText: "",
            snackOpen: false
        }
    },
    computed: {
        getUnavailableTimesForSelectedDate() {
            if (!this.selectedDate) return [];

            const formattedDate = this.formatDate(this.selectedDate);

            return this.orders
                .filter(order => this.formatDate(new Date(order.datetime_from)) === formattedDate)
                .map(order => ({
                    fromTime: new Date(order.datetime_from).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }),
                    toTime: new Date(order.datetime_to).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                }));
        }
    },
    methods: {
        onDateClick(date) {
            this.selectedDate = new Date(date);
            this.fetchOrdersForDate(this.formatDate(this.selectedDate));
            this.$emit('date-selected', this.formatDate(this.selectedDate));
        },
        async fetchOrdersForDate(formattedDate) {
            const token = decodeURIComponent(this.$cookies.get('token'));
            try {
                const response = await axiosInstance.get(`/getEmployeeOrders?date=${formattedDate}&employee_id=${this.employeeId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.orders = response.data;
            } catch (error) {
                this.snackOpen = true;
                this.snackText = 'Error fetching orders: ' + error;
            }
        },
        formatDate(date) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${year}-${month}-${day}`;
        },
        onTimeSelected(time) {
            this.$emit('time-selected', time);
        }
    },
    emits: ['date-selected', 'time-selected']
}
</script>

<style scoped>
</style>
