<template>
    <SideBar></SideBar>
    <ServiceCard></ServiceCard>
</template>

<script>
import SideBar from '@/components/dashboard/SideBar.vue'
import ServiceCard from '@/components/dashboard/service/ServiceCard.vue'

export default {
    name: 'ServicesView',
    components: { ServiceCard, SideBar }
}
</script>

<style scoped>

</style>
