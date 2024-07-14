<template>
    <NavBar class="position-relative bg-black"></NavBar>
    <ReservationComplete></ReservationComplete>
</template>

<script>
import NavBar from '@/components/NavBar.vue'
import FooterComponent from '@/components/FooterComponent.vue'
import ReservationComplete from '@/components/reservation/ReservationComplete.vue'

export default {
    name: 'ReservationCompleteView',
    components: { FooterComponent, NavBar, ReservationComplete },
    created() {
        if (!this.$route.meta.requiresReservationView) {
            this.$router.push('/');
        }
    }
}
</script>

<style scoped>

</style>
