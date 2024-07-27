<template>
    <v-container>
        <v-row>
            <v-col v-if="loading" class="loader-container">
                <v-progress-circular
                    indeterminate
                    color="black"
                    size="100"
                ></v-progress-circular>
            </v-col>
            <v-col v-else>
                <vue-cal
                    :disable-views="['years', 'year', 'month']"
                    active-view="day"
                    :split-days="customDaySplitLabels"
                    :hide-weekdays="[6, 7]"
                    :locale="$i18n.locale"
                    :time-from="8 * 60"
                    :time-to="19 * 60"
                    :events="events"
                    :on-event-click="onEventClick"
                    :time-cell-height="100"
                    sticky-split-labels>
                    <template #split-label="{ split, view }">
                        <strong :style="`color: ${split.color}`">{{ split.label }}</strong>
                    </template>
                    <template #event="{ event, view }">
                        <div :style="getEventStyle(event)" class="event-card">
                            <v-icon :icon="'mdi-' + event.icon"></v-icon>
                            <span class="event-text">{{ getShortTitle(event.title) }}</span>
                        </div>
                    </template>
                </vue-cal>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog v-model="showDialog" max-width="500" variant="flat">
        <v-card>
            <v-card-title>
                <p class="text-center">{{ selectedEvent.title }}</p>
                <div class="d-flex justify-content-end">
                    <v-btn variant="text" size="regular" prepend-icon="mdi-delete" :ripple="false" color="danger" @click="deleteEvent"></v-btn>
                </div>
            </v-card-title>
            <v-card-text>
                <v-list>
                    <strong>{{$t('calendar.orderDetail')}}</strong>
                    <v-list-item :title="$t('calendar.employee')" :subtitle="selectedEvent.employee ? selectedEvent.employee.first_name + ' ' + selectedEvent.employee.last_name : 'Unknown'"></v-list-item>
                    <v-list-item :title="$t('calendar.orderFrom')" :subtitle="selectedEvent.start && selectedEvent.start.formatTime()"></v-list-item>
                    <v-list-item :title="$t('calendar.orderTo')" :subtitle="selectedEvent.end && selectedEvent.end.formatTime()"></v-list-item>
                    <v-list-item :title="$t('calendar.price')" :subtitle="selectedEvent.price + ' €'"></v-list-item>
                    <strong>{{$t('calendar.services')}}</strong>
                    <div v-for="(service, index) in selectedEvent.services" :key="index">
                        <v-list-item :title="`${service.name} - ${service.price} €`"></v-list-item>
                    </div>
                </v-list>

            </v-card-text>
        </v-card>
    </v-dialog>
    <SnackComponent color="warning" :text="snackText" :snackOpen="snackOpen"></SnackComponent>
</template>

<script>
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import axiosInstance from '@/axios.js'
import SnackComponent from '@/components/common/SnackComponent.vue'

export default {
    name: 'Calendar',
    components: {
        SnackComponent,
        VueCal
    },
    data() {
        return {
            selectedEvent: {},
            showDialog: false,
            customDaySplitLabels: [],
            events: [],
            employeesMap: {},
            loading: false,
            snackText: "",
            snackOpen: false,
        };
    },
    created() {
        this.fetchEmployeesAndOrders();
    },
    methods: {
        async fetchEmployeesAndOrders() {
            this.loading = true;
            const token = decodeURIComponent($cookies.get('token'));
            this.loading = true;
            try {
                const employeesResponse = await axiosInstance.get('/employees', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                const employees = employeesResponse.data;
                this.customDaySplitLabels = employees.map(employee => ({
                    id: employee.id,
                    label: employee.first_name,
                    color: this.assignColor(employee.id),
                    class: 'split' + employee.id
                }));

                this.employeesMap = employees.reduce((map, employee) => {
                    map[employee.id] = employee;
                    return map;
                }, {});

                const ordersResponse = await axiosInstance.get('/orders', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                this.events = ordersResponse.data.map(order => {
                    const employee = this.employeesMap[order.employee_id];
                    return {
                        id: order.id,
                        start: order.datetime_from,
                        end: order.datetime_to,
                        title: this.$t('calendar.orderTitle', {
                            employee: employee ? `${employee.first_name} ${employee.last_name}` : 'Unknown'
                        }),
                        icon: 'event',
                        contentFull: this.$t('calendar.orderDetail', {
                            employee: employee ? `${employee.first_name} ${employee.last_name}` : 'Unknown'
                        }),
                        class: 'order',
                        services: order.services,
                        split: order.employee_id,
                        price: order.total_price,
                        employee: employee
                    };
                });
            } catch (error) {
                this.snackOpen = true;
                this.snackText = 'Error fetching employees or orders: ' + error;
            } finally {
                this.loading = false;
            }
        },

        onEventClick(event, e) {
            this.selectedEvent = event;
            this.showDialog = true;
            e.stopPropagation();
        },

        async deleteEvent() {
            const token = decodeURIComponent($cookies.get('token'));
            try {
                await axiosInstance.delete(`/orders/${this.selectedEvent.id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                this.events = this.events.filter(event => event.id !== this.selectedEvent.id);
                this.showDialog = false;
            } catch (error) {
                this.snackOpen = true;
                this.snackText = 'Error deleting order: ' + error;
            }
        },

        getEventStyle(event) {
            const split = this.customDaySplitLabels.find(label => label.id === event.split);
            const backgroundColor = split ? split.color : 'transparent';

            const hexToRgba = (hex, alpha) => {
                const [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16));
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            };

            return {
                backgroundColor: hexToRgba(backgroundColor, 0.65),
            };
        },

        getShortTitle(title) {
            return title.length > 20 ? title.slice(0, 20) + '...' : title;
        },

        assignColor(id) {
            const colors = ['#0000FF', '#008000', '#FFA500', '#FF0000', '#000000', '#4a7300', '#f900ff', '#5b2c00'];
            return colors[id % colors.length];
        }
    }
};
</script>

<style lang="scss" scoped>
.event-card {
    color: white;
    width: 100%;
    height: 100%;
}

.event-text {
}

@media (max-width: 600px) {
    .event-text {
        display: none;
    }
}

.v-list-item:hover {
    color: black !important;
}

.loader-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60vh;
}
</style>
