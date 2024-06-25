<template>
    <v-container>
        <v-row>
            <v-col>
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
                    <v-btn variant="text" size="regular" prepend-icon="mdi-pencil" :ripple="false" color="success"></v-btn>
                    <v-btn variant="text" size="regular" prepend-icon="mdi-delete" :ripple="false" color="danger"></v-btn>
                </div>
            </v-card-title>
            <v-card-text>
                <p v-html="selectedEvent.contentFull"/>
                <v-list tag='ul'>
                    <template v-for="(item) in 3">
                        <v-list-item tag='li'>
                            {{ item }}
                        </v-list-item>
                    </template>
                </v-list>

                <strong>{{$t('calendar.orderDetail')}}</strong>
                <v-list>
                    <v-list-item :title="$t('calendar.orderFrom')" :subtitle="selectedEvent.start && selectedEvent.start.formatTime()"></v-list-item>
                    <v-list-item :title="$t('calendar.orderTo')" :subtitle="selectedEvent.end && selectedEvent.end.formatTime()"></v-list-item>
                    <v-list-item :title="$t('calendar.price')" :subtitle="selectedEvent.price + ' €'"></v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import axios from 'axios';

let todayDate = new Date().toISOString().slice(0, 10);

export default {
    name: 'Calendar',
    components: {
        VueCal
    },
    data() {
        return {
            selectedEvent: {},
            showDialog: false,
            customDaySplitLabels: [],
            events: [],
            employeesMap: {}
        };
    },
    created() {
        this.fetchEmployeesAndOrders();
    },
    methods: {
        async fetchEmployeesAndOrders() {
            const token = localStorage.getItem('token'); // Získajte token z localStorage
            try {
                const employeesResponse = await axios.get('http://localhost:8000/api/employees', {
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

                // Vytvoríme mapu zamestnancov
                this.employeesMap = employees.reduce((map, employee) => {
                    map[employee.id] = employee;
                    return map;
                }, {});

                const ordersResponse = await axios.get('http://localhost:8000/api/orders', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                this.events = ordersResponse.data.map(order => {
                    const employee = this.employeesMap[order.employee_id];
                    console.log(order);
                    return {
                        start: order.datetime_from,
                        end: order.datetime_to,
                        title: `Order with ${employee ? employee.first_name : 'Unknown'}`,
                        icon: 'event',
                        contentFull: `Order details for ${employee ? employee.first_name : 'Unknown'}`,
                        class: 'order',
                        split: order.employee_id,
                        price: order.total_price
                    };
                });
            } catch (error) {
                console.error('Error fetching employees or orders:', error);
            }
        },
        onEventClick(event, e) {
            this.selectedEvent = event;
            this.showDialog = true;
            e.stopPropagation();
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
    display: flex;
    align-items: center;
    height: 100%;
    color: white;
    padding: 0 5px;
}

.event-text {
    display: inline;
    margin-left: 10px;
}

@media (max-width: 600px) {
    .event-text {
        display: none;
    }
}

.v-list-item:hover {
    color: black !important;
}
</style>
