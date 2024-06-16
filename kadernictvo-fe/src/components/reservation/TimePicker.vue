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
    data() {
        return {
            times: [
                '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00',
                '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
                '16:00', '16:30', '17:00', '17:30', '18:00'
            ],
            selectedTime: null
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
            this.selectedTime = time;
            this.$emit('time-selected', time);
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
