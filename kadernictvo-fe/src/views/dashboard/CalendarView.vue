<template>
    <SideBar></SideBar>
    <v-container>
        <div class="d-flex">
            <Calendar/>
        </div>
    </v-container>
</template>

<script>
import Calendar from '@/components/dashboard/Calendar.vue'
import SideBar from '@/components/dashboard/SideBar.vue'

export default {
    name: 'CalendarView',
    components: { SideBar, Calendar }
};
</script>

<style scoped>

</style>
