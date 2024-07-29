<template>
    <v-card height="450" class="shadow-lg">
        <v-card-title>{{ $t('appointments.title') }}</v-card-title>
        <v-spacer></v-spacer>
        <v-card-actions class="d-flex align-center justify-center">
            <v-btn icon="" :ripple="false" @click="prevEmployee">
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <span class="mx-2 text-black employee-name">{{ currentEmployeeName }}</span>
            <v-btn icon="" :ripple="false" @click="nextEmployee">
                <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
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
import axiosInstance from '@/axios.js';

export default {
    name: 'AppointmentsStats',
    data() {
        return {
            selectedEmployeeIndex: 0,
            employees: [],
            stats: {
                [this.$t('appointments.pending')]: {
                    value: 0,
                    icon: 'clock-outline',
                    color: 'rgb(255,165,0)',
                    backgroundColor: 'rgba(255, 165, 0, 0.15)'
                },
                // [this.$t('appointments.cancelled')]: {
                //     value: 0,
                //     icon: 'cancel',
                //     color: 'rgb(176,0,0)',
                //     backgroundColor: 'rgba(176,0,0, 0.15)'
                // },
                [this.$t('appointments.completed')]: {
                    value: 0,
                    icon: 'checkbox-marked-outline',
                    color: 'rgb(0,255,0)',
                    backgroundColor: 'rgba(0,255,0, 0.15)'
                }
            }
        }
    },
    computed: {
        currentEmployee() {
            return this.employees[this.selectedEmployeeIndex] || {};
        },
        currentEmployeeName() {
            const employee = this.currentEmployee.employee || {};
            return `${employee.first_name} ${employee.last_name}`;
        }
    },
    mounted() {
        this.fetchEmployees();
    },
    methods: {
        async fetchEmployees() {
            try {
                const response = await axiosInstance.get('stats/getTodayOrders', {
                    headers: {
                        Authorization: 'Bearer ' + decodeURIComponent($cookies.get('token'))
                    }
                });
                this.employees = response.data;
                if (this.employees.length > 0) {
                    this.updateStats();
                }
            } catch (error) {
                console.error("Error fetching employees:", error);
            }
        },
        updateStats() {
            const currentEmployeeData = this.currentEmployee;
            this.stats[this.$t('appointments.pending')].value = currentEmployeeData.pending;
            this.stats[this.$t('appointments.completed')].value = currentEmployeeData.completed;
        },
        prevEmployee() {
            if (this.selectedEmployeeIndex > 0) {
                this.selectedEmployeeIndex--;
            } else {
                this.selectedEmployeeIndex = this.employees.length - 1;
            }
            this.updateStats();
        },
        nextEmployee() {
            if (this.selectedEmployeeIndex < this.employees.length - 1) {
                this.selectedEmployeeIndex++;
            } else {
                this.selectedEmployeeIndex = 0;
            }
            this.updateStats();
        }
    }
}
</script>



<style scoped>
.d-flex {
    display: flex;
    justify-content: space-between;
}

.employee-name {
    font-size: 1.3rem;
}

</style>
