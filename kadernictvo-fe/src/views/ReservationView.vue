<template>
    <NavBar class="position-relative bg-black"></NavBar>
    <ReservationEvent></ReservationEvent>
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
