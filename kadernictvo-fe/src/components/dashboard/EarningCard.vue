<template>
    <v-card class="text-center shadow-lg" :color="color" width="400" dark style="cursor: pointer">
        <v-card-text>
            <strong>{{ title }}</strong>
        </v-card-text>
        <v-card-text :class="{'text-danger': isNegative, 'text-success': !isNegative}">
            <span>{{ subtitle }}</span>
        </v-card-text>
        <v-card-text>
            <v-sheet color="white">
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-sparkline
                            :model-value="value"
                            :color="sparklineColor"
                            :labels="value"
                            label-size="14"
                            height="100"
                            padding="24"
                            stroke-linecap="round"
                            smooth
                            auto-draw
                        >
                        </v-sparkline>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { defineProps, computed } from 'vue'

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: Array,
        required: true
    },
    color: {
        type: String,
        default: 'green'
    },
    sparklineColor: {
        type: String,
        default: 'success'
    }
})

const calculatePercentageChange = (values) => {
    if (values.length < 2) return 0
    const previousValue = values[values.length - 2]
    const currentValue = values[values.length - 1]
    const change = ((currentValue - previousValue) / previousValue) * 100
    return change.toFixed(2)
}

const subtitle = computed(() => {
    const change = calculatePercentageChange(props.value)
    return `${change > 0 ? '+' : ''}${change}%`
})

const isNegative = computed(() => {
    return calculatePercentageChange(props.value) < 0
})
</script>

<style scoped>
.text-danger {
    color: red;
}

.text-success {
    color: green;
}


</style>
