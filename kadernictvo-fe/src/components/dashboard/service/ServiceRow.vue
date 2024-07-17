<template>
    <tr>
        <td>{{ service.name }}</td>
        <td>{{ service.position }}</td>
        <td>
            <v-icon small @click="$emit('edit', service)">mdi-pencil</v-icon>
            <v-icon small @click="$emit('delete', service.id)">mdi-delete</v-icon>
        </td>
    </tr>
</template>

<script>
export default {
    name: 'ServiceRow',
    props: {
        service: Object
    }
}
</script>

<style scoped>
</style>
