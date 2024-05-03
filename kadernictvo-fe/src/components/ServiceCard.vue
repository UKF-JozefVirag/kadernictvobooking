<template>
    <v-card width="300px" class="mx-auto">
        <template v-slot:title>
            <span class="font-weight-black">{{cardTitle}}</span>
        </template>
        <v-card-text class="bg-surface-light pt-4">
            {{cardText}}
        </v-card-text>
        <template v-slot:subtitle>
            {{cardPrice}}
        </template>
    </v-card>
</template>

<script>
export default {
    name: "ServiceCard",
    props: {
        cardTitle: String,
        cardText: String,
        cardPrice: Number,
    }
}
</script>

<style scoped>

</style>
