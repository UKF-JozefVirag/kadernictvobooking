<template>
    <v-container class="mt-5">
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('reservation.secondSectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col
                v-for="employee in employees"
                :key="employee.id"
                cols="12"
                sm="6"
                md="4"
            >
                <ServiceCard
                    :class="{'selected': selectedEmployeeId === employee.id}"
                    @click="selectEmployee(employee)"
                    :card-title="employee.first_name"
                    :card-text="employee.description"
                    :card-image="employee.image"
                ></ServiceCard>
            </v-col>
        </v-row>
        <div class="mt-3" style="border-bottom: 1px solid #ececec;"></div>
    </v-container>
</template>

<script>
import SectionDescriber from '@/components/home/SectionDescriber.vue';
import ServiceCard from '@/components/home/ServiceCard.vue';
import axios from 'axios'

export default {
    name: 'ReservationEmployee',
    components: { ServiceCard, SectionDescriber },
    data() {
        return {
            employees: [],
            selectedEmployeeId: "",
            selectedEmployeeName: "",
            loadingEvents: false
        };
    },
    methods: {
        selectEmployee(employee) {
            if (this.selectedEmployeeId !== employee.id) {
                this.selectedEmployeeId = employee.id;
                this.selectedEmployeeName = employee.first_name;
                this.$emit('employee-selected', {
                    id: this.selectedEmployeeId,
                    first_name: this.selectedEmployeeName
                });
            }
        },
        async fetchEmployees() {
            try {
                const response = await axios.get('http://localhost:8000/api/employees');
                this.employees = response.data;
                this.loadingEvents = false;
            } catch (error) {
                console.error('Error fetching employees:', error);
            }
        },
    },
    created() {
        this.fetchEmployees();
    }
};
</script>

<style scoped>
.selected {
    border: 2px solid #d09c6e;
}
</style>
