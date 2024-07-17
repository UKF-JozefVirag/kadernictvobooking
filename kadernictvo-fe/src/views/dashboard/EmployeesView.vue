<template>
    <SideBar></SideBar>
    <EmployeesCard></EmployeesCard>
</template>

<script>
import SideBar from '@/components/dashboard/SideBar.vue'
import EmployeesCard from '@/components/dashboard/employee/EmployeesCard.vue'

export default {
    name: 'EmployeesView',
    components: { EmployeesCard, SideBar }
}
</script>

<style scoped>

</style>
