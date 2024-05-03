<template>
    <div class="d-flex flex-column justify-content-center align-items-center describer">
        <BIconScissors class="h4" style="transform: rotate(90deg)"></BIconScissors>
        <p style="font-size: 1.6em; color: #d09c6e">
            {{sectionName}}
        </p>
        <BIconScissors class="h4" style="transform: rotate(-90deg)"></BIconScissors>
    </div>
</template>

<script>
export default {
    name: "SectionDescriber",
    props: {
        sectionName: String,
    }
}
</script>

<style scoped>
</style>
