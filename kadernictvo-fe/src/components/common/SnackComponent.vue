<template>
    <div class="text-center">
        <v-snackbar
            v-model="snackbar"
            :timeout="timeout"
            :color="color"
            close-on-content-click
        >
            {{ text }}

            <template v-slot:actions>
                <v-btn
                    :color="color"
                    variant="text"
                    @click="snackbar = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    name: "SnackComponent",
    props: {
        text: {
            type: String,
            required: true
        },
        color: {
            type: String,
            required: true
        },
        snackOpen: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            snackbar: false,
            timeout: 2000
        };
    },
    watch: {
        snackOpen(val) {
            this.snackbar = val;
        }
    }
}
</script>

<style scoped>
</style>
