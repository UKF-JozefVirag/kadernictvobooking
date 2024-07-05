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
                    <option v-for="(item, index) in items" :key="index" :value="item">{{
                            item
                        }}</option>
                </select>
            </v-col>
        </v-row>
        <v-row class="d-flex">
            <v-col
                cols="12"
                md="6"
                lg="4"
                class="d-flex justify-content-start"
                d-flex
                flex-column
            >
                <EarningCard
                    title="Tržby za posledných 24 hodín"
                    :value="[423, 446, 675, 510, 590, 610, 760]"
                    color="green"
                    sparklineColor="success"
                />
            </v-col>
            <v-col
                cols="12"
                md="6"
                lg="4"
                class="d-flex justify-content-lg-center"
                d-flex
                flex-column
                align-self-center
            >
                <EarningCard
                    title="Počet rezervácií za týždeň"
                    :value="[5, 7, 8, 6, 10, 9, 11]"
                    color="blue"
                    sparklineColor="info"
                />
            </v-col>
            <v-col
                cols="12"
                md="6"
                lg="4"
                class="d-flex justify-content-lg-end"
                d-flex
                flex-column
                align-self-end
            >
                <EarningCard
                    title="Noví zákazníci za mesiac"
                    :value="[2, 3, 5, 6, 7, 10, 12]"
                    color="orange"
                    sparklineColor="warning"
                />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="9" lg="8" align-self="start">
                <v-card class="fixed-card">
                    <v-card-title>Latest orders</v-card-title>
                    <v-card-text v-for="(order, index) in orders" :key="index" class="order-text">
                        <a href="#" class="order-link">Order #{{ order.number }}</a> created {{ order.time }}. {{ order.items }} items. <br> {{ order.customer }}
                        <span class="float-right">{{ order.amount }} €</span>
                        <hr />
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="3" lg="4" align-self="start">
                <v-card>
                    <v-card-title>Lorem ipsum dolor sit.</v-card-title>
                    <v-card-text>
                        Lorem ipsum dolor. Lorem ipsum dolor sit amet, consectetur
                        adipisicing elit. Aliquam cumque deleniti dicta rerum, sunt
                        voluptate? A enim laudantium numquam! Aliquid?
                    </v-card-text>
                    <v-card-text>
                        Lorem ipsum dolor. Lorem ipsum dolor sit amet, consectetur
                        adipisicing elit. Aliquam cumque deleniti dicta rerum, sunt
                        voluptate? A enim laudantium numquam! Aliquid?
                    </v-card-text>
                </v-card>
                <v-card class="mt-3">
                    <v-card-title>Lorem ipsum dolor sit.</v-card-title>
                    <v-card-text>
                        Lorem ipsum dolor. Lorem ipsum dolor sit amet, consectetur
                        adipisicing elit. Aliquam cumque deleniti dicta rerum, sunt
                        voluptate? A enim laudantium numquam! Aliquid?
                    </v-card-text>
                    <v-card-text>
                        Lorem ipsum dolor. Lorem ipsum dolor sit amet
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import EarningCard from "@/components/dashboard/EarningCard.vue";
import SideBar from "@/components/dashboard/SideBar.vue";

export default {
    components: { SideBar, EarningCard },
    data() {
        return {
            items: ["day", "week", "month"],
            selectedOption: "day",
            orders: this.generateOrders(),
        };
    },
    methods: {
        generateOrders() {
            const orders = [];
            for (let i = 1; i <= 7; i++) {
                orders.push({
                    number: i,
                    time: (Math.random() * 60).toFixed(0) + " mins ago",
                    items: (Math.random() * 5).toFixed(0),
                    customer: "John Doe",
                    amount: (Math.random() * 100).toFixed(2),
                });
            }
            return orders;
        },
    },
};
</script>

<style scoped>
.fixed-card {
    max-height: 400px;
    overflow-y: auto;
}

.order-link {
    color: #d09c6e;
    text-decoration: none;
}

.float-right {
    float: right;
}

.order-text {
    margin-top: 0;
    padding-top: 0;
}
</style>
