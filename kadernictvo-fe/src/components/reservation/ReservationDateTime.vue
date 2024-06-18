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
                    style="height: 400px"
                    @cell-click="onDateClick">
                </vue-cal>
            </v-col>
            <v-col cols="12" sm="12" md="6" v-if="selectedDate">
                <TimePicker @time-selected="onTimeSelected"></TimePicker>
            </v-col>
        </v-row>
        <div class="mt-3" style="border-bottom: 1px solid #ececec;"></div>
    </v-container>
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import SectionDescriber from '@/components/home/SectionDescriber.vue'
import TimePicker from '@/components/reservation/TimePicker.vue'

export default {
    name: 'ReservationDateTime',
    components: {
        TimePicker,
        SectionDescriber,
        VueCal,
    },
    data() {
        return {
            selectedDate: null,
            selectedTime: null
        }
    },
    computed: {
        formattedDate() {
            if (!this.selectedDate) return '';
            const day = String(this.selectedDate.getDate()).padStart(2, '0');
            const month = String(this.selectedDate.getMonth() + 1).padStart(2, '0');
            const year = this.selectedDate.getFullYear();
            return `${day}/${month}/${year}`;
        }
    },
    methods: {
        onDateClick(date) {
            this.selectedDate = new Date(date);
            this.selectedDate = this.formattedDate;
            this.$emit('date-selected', this.selectedDate);
        },
        onTimeSelected(time) {
            this.selectedTime = time;
            this.$emit('time-selected', this.selectedTime);
        }
    }
}
</script>

<style scoped>
</style>
