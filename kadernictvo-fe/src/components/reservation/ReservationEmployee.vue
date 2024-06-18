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
                    :card-title="employee.name"
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

export default {
    name: 'ReservationEmployee',
    components: { ServiceCard, SectionDescriber },
    data() {
        let src = "/src/assets/images/employees/";
        return {
            employees: [
                {
                    id: 1,
                    name: "John",
                    description: "Barber",
                    image: src + "placeholder-person.png"
                },
                {
                    id: 2,
                    name: "Jane",
                    description: "Barber",
                    image: src + "placeholder-person.png"
                },
                {
                    id: 3,
                    name: "Bob",
                    description: "Barber",
                    image: src + "placeholder-person.png"
                },
                {
                    id: 4,
                    name: "Martin",
                    description: "Barber",
                    image: src + "placeholder-person.png"
                },
                {
                    id: 5,
                    name: "Simon",
                    description: "Barber",
                    image: src + "placeholder-person.png"
                },
                {
                    id: 6,
                    name: "Nezáleží",
                    description: "Barber",
                    image: src + "placeholder-person.png"
                }
            ],
            selectedEmployeeId: "",
            selectedEmployeeName: ""
        };
    },
    methods: {
        selectEmployee(employee) {
            if (this.selectedEmployeeId !== employee.id) {
                this.selectedEmployeeId = employee.id;
                this.selectedEmployeeName = employee.name;
                this.$emit('employee-selected', {
                    id: this.selectedEmployeeId,
                    name: this.selectedEmployeeName
                });
            }
        }
    }
};
</script>

<style scoped>
.selected {
    border: 2px solid #d09c6e;
}
</style>
