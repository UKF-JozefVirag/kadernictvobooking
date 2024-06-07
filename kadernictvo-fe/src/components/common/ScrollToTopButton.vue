<template>
    <v-btn
        class="md-5 mr-3 elevation-21"
        dark
        fab
        button
        right
        color="indigo darken-3"
        fixed
        @click="top"
    />
</template>

<script>
export default {
    name: "ScrollToTopButton",
    methods: {
        top() {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        }
    }
}
</script>


<style scoped>

</style>
