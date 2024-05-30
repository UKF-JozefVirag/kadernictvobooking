<template>
    <v-container fluid>
        <v-row>
            <v-col cols="8">
<!--                <v-img src="../assets/images/header.jpg"></v-img>-->
            </v-col>
            <v-col cols="4">
                <LoginForm></LoginForm>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import LoginForm from "@/components/login/LoginForm.vue";

export default {
    name: "LoginView",
    components: {LoginForm}
}
</script>

<style scoped>

</style>
