<template>
    <v-card height="400">
        <v-card-title>Appointments Quick Stats</v-card-title>
        <v-card-text>
            <v-list>
                <v-list-item>
                    <v-row class="d-flex justify-between align-center">
                        <v-col cols="auto">
                            <v-icon class="mr-2" color="grey darken-1">mdi-clock</v-icon>
                            <span>Čakajúce:</span>
                        </v-col>
                        <v-col cols="auto">
                            8
                        </v-col>
                    </v-row>
                </v-list-item>
                <v-list-item>
                    <v-row class="d-flex justify-between align-center">
                        <v-col cols="auto">
                            <v-icon class="mr-2" color="grey darken-1">mdi-check</v-icon>
                            <span>Schválené:</span>
                        </v-col>
                        <v-col cols="auto">
                            10
                        </v-col>
                    </v-row>
                </v-list-item>
                <v-list-item>
                    <v-row class="d-flex justify-between align-center">
                        <v-col cols="auto">
                            <v-icon class="mr-2" color="grey darken-1">mdi-close</v-icon>
                            <span>Zrušené:</span>
                        </v-col>
                        <v-col cols="auto">
                            2
                        </v-col>
                    </v-row>
                </v-list-item>
                <v-list-item>
                    <v-row class="d-flex justify-between align-center">
                        <v-col cols="auto">
                            <v-icon class="mr-2" color="grey darken-1">mdi-check-circle-outline</v-icon>
                            <span>Dokončené:</span>
                        </v-col>
                        <v-col cols="auto">
                            18
                        </v-col>
                    </v-row>
                </v-list-item>
                <v-list-item>
                    <v-row class="d-flex justify-between align-center">
                        <v-col cols="auto">
                            <v-icon class="mr-2" color="grey darken-1">mdi-cancel</v-icon>
                            <span>Odmietnuté:</span>
                        </v-col>
                        <v-col cols="auto">
                            2
                        </v-col>
                    </v-row>
                </v-list-item>
                <v-list-item>
                    <v-row class="d-flex justify-between align-center">
                        <v-col cols="auto">
                            <v-icon class="mr-2" color="grey darken-1">mdi-account-remove</v-icon>
                            <span>Nezúčastnené:</span>
                        </v-col>
                        <v-col cols="auto">
                            0
                        </v-col>
                    </v-row>
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
                pending: 5,
                approved: 15,
                canceled: 2,
                completed: 10,
                rejected: 0,
                unattended: 0
            }
        }
    }
}
</script>

<style scoped>
.badge-text {
    color: white;
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 999px;
    text-transform: uppercase;
}
</style>
