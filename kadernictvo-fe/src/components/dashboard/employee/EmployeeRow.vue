<template>
    <tr>
        <td>{{ employee.name }}</td>
        <td>{{ employee.position }}</td>
        <td>
            <v-icon small @click="$emit('edit', employee)">mdi-pencil</v-icon>
            <v-icon small @click="$emit('delete', employee.id)">mdi-delete</v-icon>
        </td>
    </tr>
</template>

<script>
export default {
    name: 'EmployeeRow',
    props: {
        employee: Object
    }
}
</script>

<style scoped>
</style>
