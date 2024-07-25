<template>
    <v-card height="450" class="shadow-lg">
        <v-card-title>{{ $t('appointments.title') }}</v-card-title>
        <v-card-actions>
            <   Employee >
        </v-card-actions>
        <v-card-text>
            <v-list class="px-2">
                <v-list-item v-for="(stat, key) in stats" :key="key">
                    <div class="d-flex justify-space-between align-center">
                        <div>
                            <v-icon :color="stat.color" class="p-3" :style="{backgroundColor: stat.backgroundColor}">mdi-{{ stat.icon }}</v-icon>
                            <span class="ms-3 text-black">{{ key }}:</span>
                        </div>
                        <div class="text-black">
                            {{ stat.value }}
                        </div>
                    </div>
                    <hr style="color: black">
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
                [this.$t('appointments.pending')]: {
                    value: 8,
                    icon: 'clock-outline',
                    color: 'rgb(255,165,0)',
                    backgroundColor: 'rgba(255, 165, 0, 0.15)'
                },
                [this.$t('appointments.cancelled')]: {
                    value: 2,
                    icon: 'cancel',
                    color: 'rgb(176,0,0)',
                    backgroundColor: 'rgba(176,0,0, 0.15)'
                },
                [this.$t('appointments.completed')]: {
                    value: 18,
                    icon: 'checkbox-marked-outline',
                    color: 'rgb(0,255,0)',
                    backgroundColor: 'rgba(0,255,0, 0.15)'
                }
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
