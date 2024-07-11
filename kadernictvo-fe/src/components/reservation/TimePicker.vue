<template>
    <v-container>
        <v-row>
            <v-col>
                <h5 class="text-center">{{ $t('reservation.morning') }}</h5>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-start mb-3">
            <v-col
                v-for="time in timesBeforeNoon"
                :key="time"
                cols="auto"
                class="d-flex justify-start"
            >
                <v-btn
                    :class="{'selected': selectedTime === time}"
                    @click="selectTime(time)"
                    :disabled="isTimeDisabled(time)"
                    :ripple="false"
                >
                    {{ time }}
                </v-btn>
            </v-col>
        </v-row>
        <div style="border-bottom: 1px solid #ececec;"></div>
        <v-row>
            <v-col>
                <h5 class="text-center mt-3">{{ $t('reservation.afternoon') }}</h5>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-start">
            <v-col
                v-for="time in timesAfterNoon"
                :key="time"
                cols="auto"
                class="d-flex justify-start"
            >
                <v-btn
                    :class="{'selected': selectedTime === time}"
                    @click="selectTime(time)"
                    :disabled="isTimeDisabled(time)"
                    :ripple="false"
                >
                    {{ time }}
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'TimePicker',
    props: {
        selectedDate: {
            type: Date,
            required: true
        },
        unavailableTimes: {
            type: Array,
            required: true,
            default: () => []
        },
        employeeId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            times: [
                '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00',
                '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
                '16:00', '16:30', '17:00', '17:30', '18:00'
            ],
            selectedTime: null,
        }
    },
    computed: {
        timesBeforeNoon() {
            return this.times.filter(time => {
                const [hours] = time.split(':').map(Number);
                return hours < 13;
            });
        },
        timesAfterNoon() {
            return this.times.filter(time => {
                const [hours] = time.split(':').map(Number);
                return hours >= 13;
            });
        }
    },
    methods: {
        selectTime(time) {
            if (!this.isTimeDisabled(time)) {
                this.selectedTime = time;
                this.$emit('time-selected', time);
            }
        },
        isTimeDisabled(time) {
            const [hours, minutes] = time.split(':').map(Number);
            const selectedDateTime = new Date(this.selectedDate);
            selectedDateTime.setHours(hours, minutes, 0, 0);

            const now = new Date();
            const currentHours = now.getHours();
            const currentMinutes = now.getMinutes();

            if (selectedDateTime < now.setHours(currentHours, currentMinutes, 0, 0)) {
                return true;
            }

            return this.unavailableTimes.some(unavailable => {
                const fromTime = new Date(this.selectedDate);
                const [fromHours, fromMinutes] = unavailable.fromTime.split(':').map(Number);
                fromTime.setHours(fromHours, fromMinutes, 0, 0);

                const toTime = new Date(this.selectedDate);
                const [toHours, toMinutes] = unavailable.toTime.split(':').map(Number);
                toTime.setHours(toHours, toMinutes, 0, 0);

                return selectedDateTime >= fromTime && selectedDateTime < toTime;
            });
        }
    }
}
</script>

<style scoped>
.selected {
    background-color: #d09c6e;
    color: white;
}
</style>
