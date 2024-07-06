<template>
    <v-card height="450" class="shadow-lg">
        <v-card-title>Appointments Quick Stats</v-card-title>
        <v-card-text>
            <v-list>
                <v-list-item v-for="(stat, key) in stats" :key="key">
                    <div class="d-flex justify-space-between align-center mt-3">
                        <div>
                            <v-icon :color="stat.color" :style="{backgroundColor: stat.backgroundColor, borderRadius: '50%'}">mdi-{{ stat.icon }}</v-icon>
                            <span :style="{color: stat.color}">{{ key }}:</span>
                        </div>
                        <div>
                            {{ stat.value }}
                        </div>
                    </div>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'AppointmentsStats',
    data() {
        return {
            stats: {
                'Čakajúce': { value: 8, icon: 'clock', color: 'rgba(255, 165, 0, 1)', backgroundColor: 'rgba(255, 165, 0, 0.15)' },
                'Schválené': { value: 10, icon: 'check', color: 'green', backgroundColor: 'rgba(0, 128, 0, 0.15)' },
                'Zrušené': { value: 2, icon: 'cancel', color: 'red', backgroundColor: 'rgba(255, 0, 0, 0.15)' },
                'Dokončené': { value: 18, icon: 'check-circle', color: 'green', backgroundColor: 'rgba(0, 128, 0, 0.15)' },
                'Odmietnuté': { value: 2, icon: 'close-circle', color: 'red', backgroundColor: 'rgba(255, 0, 0, 0.15)' },
                'Nezúčastnené': { value: 0, icon: 'alert', color: 'yellow', backgroundColor: 'rgba(255, 255, 0, 0.15)' }
            }
        }
    }
}
</script>

<style scoped>
.d-flex {
    display: flex;
    justify-content: space-between;
}
</style>
