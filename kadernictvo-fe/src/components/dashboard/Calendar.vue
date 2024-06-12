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
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'

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
            customDaySplitLabels: [
                { id: 1, label: 'John', color: '#0000FF', class: 'split1' },
                { id: 2, label: 'Tom', color: '#008000', class: 'split2' },
                { id: 3, label: 'Kate', color: '#FFA500', class: 'split3' },
                { id: 4, label: 'Jess', color: '#FF0000', class: 'split4' },
                { id: 5, label: 'Martin', color: '#000000', class: 'split5' },
                { id: 6, label: 'Jonathan', color: '#4a7300', class: 'split6' },
                { id: 7, label: 'Michelle', color: '#f900ff', class: 'split7' },
                { id: 8, label: 'Nicole', color: '#5b2c00', class: 'split8' }
            ],
            events: [
                {
                    start: todayDate + ' 9:30',
                    end: todayDate + ' 10:00',
                    title: 'Shopping with princess Diana',
                    icon: 'account',
                    contentFull: 'Aliquam rutrum nisi eget dignissim ultricies. Suspendisse sapien est, tempus faucibus nunc ut, efficitur fermentum est. Aliquam consequat velit risus',
                    class: 'leisure',
                    split: 1,
                    price: 25
                },
                {
                    start: todayDate + ' 14:30',
                    end: todayDate + ' 15:00',
                    title: 'Golf with Mario Kart characters',
                    icon: 'triangle',
                    contentFull: 'Okay. It will be an 18 hole golf course.',
                    class: 'sport',
                    split: 2,
                    price: 15.50
                },
                {
                    start: todayDate + ' 14:30',
                    end: todayDate + ' 15:00',
                    title: 'Miro pele repovanie',
                    icon: 'circle',
                    contentFull: 'Okay. It will be an 18 hole golf course.',
                    class: 'sport',
                    split: 4,
                    price: 32.5
                }
            ]
        }
    },
    methods: {
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
    color: black !important;;
}

</style>
