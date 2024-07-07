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
                    :value="[423, 446, 675, 510, 590, 610, 760]"
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
                    :value="[5, 7, 8, 6, 10, 9, 11]"
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
                    :title="$t('earning_cards.customers')"
                    :value="[5, 7, 8, 6, 10, 9, 11]"
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
                        <v-card-text v-for="(order, index) in orders" :key="index" class="order-text">
                            <div class="order-details">
                                <a href="#" class="order-link me-1">{{ $t('latest_orders.order') }} #{{ order.number }}.</a>
                                {{ $t('latest_orders.created') }}: {{ order.time }} {{ $t('latest_orders.minutesAgo') }}. {{ order.items }} {{ $t('latest_orders.items') }}.
                                <span class="customer">{{ order.customer }}</span>
                                <span class="amount">{{ order.amount }} €</span>
                            </div>
                            <hr />
                        </v-card-text>
                    </v-virtual-scroll>
                </v-card>
            </v-col>
            <v-col cols="12" md="3" lg="4" align-self="start">
                <AppointmentsStats></AppointmentsStats>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import EarningCard from "@/components/dashboard/EarningCard.vue";
import SideBar from "@/components/dashboard/SideBar.vue";
import AppointmentsStats from '@/components/dashboard/AppointmentsStats.vue'

export default {
    components: { AppointmentsStats, SideBar, EarningCard },
    data() {
        return {
            selectedOption: '1',
            orders: this.generateOrders(),
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
        generateOrders() {
            const orders = [];
            for (let i = 1; i <= 7; i++) {
                orders.push({
                    number: i,
                    time: (Math.random() * 60).toFixed(0),
                    items: (Math.random() * 5).toFixed(0),
                    customer: "John Doe",
                    amount: (Math.random() * 100).toFixed(2),
                });
            }
            return orders;
        },
    },
    created() {
        this.selectedOption = '1';
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

body {
    scrollbar-width: thin;
}
</style>
