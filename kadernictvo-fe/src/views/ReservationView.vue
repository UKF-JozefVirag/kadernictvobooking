<template>
    <NavBar class="nb justify-content-center bg-black"></NavBar>
    <ReservationEvent class="reservation-event"></ReservationEvent>
</template>

<script>
import NavBar from '@/components/NavBar.vue'
import ReservationEvent from '@/components/home/ReservationEvent.vue'

export default {
    name: 'ReservationView',
    components: { ReservationEvent, NavBar }
}
</script>

<style scoped>
</style>
