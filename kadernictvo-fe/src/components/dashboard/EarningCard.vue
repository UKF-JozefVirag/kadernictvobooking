<template>
    <v-card class="text-center shadow-lg" :color="color" width="400" dark style="cursor: pointer">
        <v-card-text>
            <strong>{{ title }}</strong>
        </v-card-text>
        <v-card-text :class="{'text-danger': isNegative && !secondValues, 'text-success': !isNegative && !secondValues, 'text-transparent': secondValues}">
            <span v-if="props.percentage">{{ subtitle }}</span>
        </v-card-text>
        <v-card-text>
            <v-sheet color="white">
                <v-row no-gutters>
                    <v-col cols="12">
                        <div style="position: relative; height: 200px;">
                            <Line :data="chartData" :options="chartOptions"></Line>
                        </div>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { defineProps, computed } from 'vue'
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement)

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
    },
    labels: {
        type: Array,
        required: false
    },
    percentage: {
        type: Boolean,
        required: false
    },
    secondValues: {
        type: Array,
        required: false
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

const generateColor = (index) => {
    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
        '#33369d', '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF'
    ]
    return colors[index % colors.length]
}

const chartData = computed(() => {
    const datasets = [
        {
            label: props.title,
            backgroundColor: props.color,
            borderColor: props.color,
            data: props.value,
            fill: false,
            tension: 0.4
        }
    ]

    if (props.secondValues && props.secondValues.length > 0) {
        props.secondValues.forEach((item, index) => {
            datasets.push({
                label: item.employee,
                backgroundColor: generateColor(index),
                borderColor: generateColor(index),
                data: Object.values(item.times),
                fill: false,
                tension: 0.4,
                borderWidth: 0.5
            })
        })
    }

    return {
        labels: props.labels || (props.secondValues && props.secondValues.length > 0 ? Object.keys(props.secondValues[0].times) : []),
        datasets
    }
})

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            grid: {
                drawOnChartArea: false
            },
            ticks: {
                autoSkip: true,
                maxTicksLimit: 5,
                maxRotation: 45,
                minRotation: 0
            }
        },
        y: {
            grid: {
                drawOnChartArea: false
            },
            ticks: {
                stepSize: 1,
                beginAtZero: true
            }
        }
    },
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            callbacks: {
                label: function(context) {
                    return `${context.dataset.label}: ${context.raw}`;
                }
            }
        }
    }
}
</script>

<style scoped>
.text-danger {
    color: red;
}

.text-success {
    color: green;
}

.text-transparent {
    color: transparent;
    user-select: none;
}
</style>
