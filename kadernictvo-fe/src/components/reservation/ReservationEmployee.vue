<template>
    <v-container class="mt-5">
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('reservation.secondSectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <template v-if="loadingEvents">
                <v-col cols="12" sm="6" md="4" v-for="n in 9" :key="'skeleton-' + n">
                    <v-skeleton-loader
                        type="image"
                        class="my-2"
                        style="background-color: #E0E0E0">
                    </v-skeleton-loader>
                </v-col>
            </template>
            <template v-else>
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
                        :card-image="getImageUrl(employee.image)"
                        :service="false"
                        :reservation="true"
                    ></ServiceCard>
                </v-col>
            </template>
        </v-row>
        <div class="mt-3" style="border-bottom: 1px solid #ececec;"></div>
    </v-container>
    <SnackComponent color="warning" :text="snackText" :snackOpen="snackOpen"></SnackComponent>
</template>


<script>
import SectionDescriber from '@/components/home/SectionDescriber.vue';
import ServiceCard from '@/components/home/ServiceCard.vue';
import axiosInstance from '@/axios.js'
import SnackComponent from '@/components/common/SnackComponent.vue'

export default {
    name: 'ReservationEmployee',
    components: { SnackComponent, ServiceCard, SectionDescriber },
    data() {
        return {
            employees: [],
            selectedEmployeeId: "",
            selectedEmployeeName: "",
            loadingEvents: true,
            snackText: "",
            snackOpen: false
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
                const response = await axiosInstance.get('/employees');
                this.employees = response.data;
                this.loadingEvents = false;
            } catch (error) {
                this.snackOpen = true;
                this.snackText = 'Error fetching employee: ' + error;
            }
        },
        getImageUrl(image) {
            return image ? `http://localhost:8000/storage/${image}` : '';
        },
    },
    created() {
        this.fetchEmployees();
    },
    emits: ['employee-selected']
};

</script>

<style scoped>
.selected {
    border: 2px solid #d09c6e;
}
</style>
