<template>
    <SideBar></SideBar>
    <v-container class="d-flex flex-column">
        <v-row class="mb-2 d-flex justify-end">
            <v-spacer></v-spacer>
            <v-col cols="auto">
                <select
                    class="form-select form-select-sm"
                    id="select"
                    aria-label="Default select example"
                    v-model="selectedOption"
                >
                    <option v-for="(item, index) in items" :key="index" :value="item.value">{{ item.text }}</option>
                </select>
            </v-col>
        </v-row>
        <v-row class="d-flex">
            <v-col
                cols="12"
                md="6"
                lg="3"
                class="d-flex justify-content-start"
                d-flex
                flex-column
            >
                <EarningCard
                    :title="$t('earning_cards.orders')"
                    :value="ordersCount"
                    :labels="ordersLabels"
                    color="green"
                    sparklineColor="success"
                >{{ $t('earning_cards.orders') }}</EarningCard>
            </v-col>
            <v-col
                cols="12"
                md="6"
                lg="3"
                class="d-flex justify-content-lg-center"
                d-flex
                flex-column
                align-self-center
            >
                <EarningCard
                    :title="$t('earning_cards.revenue')"
                    :value="revenuesCount"
                    :labels="revenuesLabels"
                    color="blue"
                    sparklineColor="info"
                ></EarningCard>
            </v-col>
            <v-col
                cols="12"
                md="6"
                lg="3"
                class="d-flex justify-content-lg-center"
                d-flex
                flex-column
                align-self-center
            >
                <EarningCard
                    :title="$t('earning_cards.new_customers')"
                    :value="newCustomersCount"
                    :labels="newCustomersLabels"
                    color="blue"
                    sparklineColor="info"
                />
            </v-col>
            <v-col
                cols="12"
                md="6"
                lg="3"
                class="d-flex justify-content-lg-end"
                d-flex
                flex-column
                align-self-end
            >
                <EarningCard
                    :title="$t('earning_cards.retention')"
                    :value="[2, 3, 5, 6, 7, 10, 12]"
                    color="orange"
                    sparklineColor="warning"
                />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="9" lg="8" align-self="start">
                <v-card class="fixed-card shadow-lg">
                    <v-card-title>{{$t('latest_orders.latestOrder')}}</v-card-title>
                    <v-virtual-scroll :items="orders" max-height="400">
                        <template v-slot:default="{ item: order }">
                            <v-card-text :key="order.id" class="order-text">
                                <div class="order-details">
                                    <a href="#" @click="onEventClick(order, $event)" class="order-link me-1">
                                        {{ $t('latest_orders.order') }} #{{ order.id }}
                                    </a>
                                    - {{ $t('latest_orders.created') }}: {{ order.formattedMinutesAgo }}. {{ $t('latest_orders.minutesAgo') }}.
                                    {{ order.items }} {{ $t('latest_orders.items') }}.
                                    <span class="customer">{{ order.customer }}</span>
                                    <span class="amount">{{ order.total_price }} €</span>
                                </div>
                                <hr />
                            </v-card-text>
                        </template>
                    </v-virtual-scroll>
                </v-card>

            </v-col>
            <v-col cols="12" md="3" lg="4" align-self="start">
                <AppointmentsStats></AppointmentsStats>
            </v-col>
        </v-row>

        <v-dialog v-model="showDialog" max-width="500" variant="flat">
            <v-card>
                <v-card-title>
                    <p class="text-center">{{ $t('latest_orders.order')}} #{{ selectedEvent.id }}</p>
                </v-card-title>
                <v-card-text>
                    <v-list>
                        <strong>{{$t('calendar.orderDetail')}}</strong>
                        <v-list-item :title="$t('calendar.employee')" :subtitle="selectedEvent.employee ? selectedEvent.employee.first_name + ' ' + selectedEvent.employee.last_name : 'Unknown'"></v-list-item>
                        <v-list-item :title="$t('calendar.orderFrom')" :subtitle="formatDateTime(selectedEvent.datetime_from)"></v-list-item>
                        <v-list-item :title="$t('calendar.orderTo')" :subtitle="formatDateTime(selectedEvent.datetime_to)"></v-list-item>
                        <v-list-item :title="$t('calendar.price')" :subtitle="selectedEvent.total_price + ' €'"></v-list-item>
                        <strong>{{$t('calendar.services')}}</strong>
                        <div v-for="(service, index) in selectedEvent.services" :key="index">
                            <v-list-item :title="`${service.name} - ${service.price} €`"></v-list-item>
                        </div>
                    </v-list>

                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import { format, parseISO, differenceInMinutes } from 'date-fns';
import AppointmentsStats from '@/components/dashboard/AppointmentsStats.vue';
import SideBar from '@/components/dashboard/SideBar.vue';
import EarningCard from '@/components/dashboard/EarningCard.vue';
import axios from 'axios';

export default {
    components: { AppointmentsStats, SideBar, EarningCard },
    data() {
        return {
            selectedOption: '1',
            orders: [],
            ordersCount: [],
            ordersLabels: [],
            revenuesCount: [],
            revenuesLabels: [],
            newCustomersCount: [],
            newCustomersLabels: [],
            selectedEvent: {},
            showDialog: false,
        };
    },
    computed: {
        items() {
            return [
                { value: '1', text: this.$t('dashboard.day') },
                { value: '2', text: this.$t('dashboard.week') },
                { value: '3', text: this.$t('dashboard.month') }
            ];
        }
    },
    methods: {
        onEventClick(order, e) {
            this.selectedEvent = order;
            this.showDialog = true;
            e.preventDefault();
            e.stopPropagation();
        },
        formatDateTime(datetime) {
            const parsedDateTime = parseISO(datetime);
            return format(parsedDateTime, 'dd/MM/yyyy HH:mm:ss');
        },

        async getOrders() {
            const response = await axios.get('http://localhost:8000/api/stats/latest-orders', {
                headers: {
                    Authorization: 'Bearer ' + decodeURIComponent($cookies.get('token'))
                }
            });
            const now = new Date();
            this.orders = response.data.map(order => {
                const createdAt = parseISO(order.created_at);
                const minutesAgo = differenceInMinutes(now, createdAt);
                return {
                    ...order,
                    time: format(createdAt, 'HH:mm'),
                    minutesAgo: minutesAgo,
                    formattedMinutesAgo: this.formatMinutes(minutesAgo),
                    items: order.services.length,
                    customer: `${order.employee.first_name} ${order.employee.last_name}`
                };
            });

            this.orders.sort((a, b) => b.id - a.id);
        },
        async getRevenues() {
            const response = await axios.get('http://localhost:8000/api/stats/revenue?range=' + this.selectedOption, {
                headers: {
                    Authorization: 'Bearer ' + decodeURIComponent($cookies.get('token'))
                }
            });
            const data = response.data.data;

            this.revenuesLabels = Object.keys(data).map(dateString => {
                const date = parseISO(dateString);
                if (this.selectedOption === '2') { // Weekly
                    return format(date, 'dd/MM');
                } else if (this.selectedOption === '3') { // Monthly
                    return format(date, 'dd/MM');
                }
                return dateString;
            });

            this.revenuesCount = Object.values(data);
        },

        async getOrdersCount() {
            const response = await axios.get('http://localhost:8000/api/stats/orders?range=' + this.selectedOption, {
                headers: {
                    Authorization: 'Bearer ' + decodeURIComponent($cookies.get('token'))
                }
            });
            const data = response.data.data;

            this.ordersLabels = Object.keys(data).map(dateString => {
                const date = parseISO(dateString);
                if (this.selectedOption === '2') { // Weekly
                    return format(date, 'dd/MM');
                } else if (this.selectedOption === '3') { // Monthly
                    return format(date, 'dd/MM');
                }
                return dateString;
            });

            this.ordersCount = Object.values(data);
        },

        async getNewCustomers() {
            console.log("TBA");
            // const response = await axios.get('http://localhost:8000/api/stats/new-customers?range=' + this.selectedOption, {
            //     headers: {
            //         Authorization: 'Bearer ' + decodeURIComponent($cookies.get('token'))
            //     }
            // });
            // const data = response.data.data;
            //
            // this.newCustomersLabels = Object.keys(data).map(dateString => {
            //     const date = parseISO(dateString);
            //     if (this.selectedOption === '2') { // Weekly
            //         return format(date, 'dd/MM');
            //     } else if (this.selectedOption === '3') { // Monthly
            //         return format(date, 'dd/MM');
            //     }
            //     return dateString;
            // });
            //
            // this.newCustomersCount = Object.values(data);
            // console.log(this.newCustomersCount);
        },

        formatMinutes(minutes) {
            if (minutes < 60) {
                return `${minutes}m`;
            } else if (minutes < 1440) { // less than 24 hours
                const hours = Math.floor(minutes / 60);
                const remainingMinutes = minutes % 60;
                if (remainingMinutes === 0) {
                    return `${hours}h`;
                } else {
                    return `${hours}h ${remainingMinutes}m`;
                }
            } else { // 24 hours or more
                const days = Math.floor(minutes / 1440);
                const remainingHours = Math.floor((minutes % 1440) / 60);
                const remainingMinutes = minutes % 60;
                if (remainingHours === 0 && remainingMinutes === 0) {
                    return `${days}d`;
                } else if (remainingHours === 0) {
                    return `${days}d ${remainingMinutes}m`;
                } else if (remainingMinutes === 0) {
                    return `${days}d ${remainingHours}h`;
                } else {
                    return `${days}d ${remainingHours}h ${remainingMinutes}m`;
                }
            }
        }
    },
    watch: {
        selectedOption() {
            this.getOrdersCount();
            this.getOrders();
            this.getRevenues();
            this.getNewCustomers();
        }
    },
    mounted() {
        this.getOrdersCount();
        this.getOrders();
        this.getRevenues();
        this.getNewCustomers();
    }
};
</script>

<style scoped>
.order-link {
    color: #d09c6e;
    text-decoration: none;
}

.order-text {
    margin-top: 0;
    padding-top: 0;
}

.order-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.customer {
    margin-left: auto;
    margin-right: auto;
}

.amount {
    float: right;
}

.v-list-item:hover {
    color: black !important;
}
</style>
