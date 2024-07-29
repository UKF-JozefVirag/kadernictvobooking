<template>
    <SideBar></SideBar>
    <v-container>
        <v-row>
            <v-col cols="12" md="12" lg="8" offset-xl="2">
                <UserInfo></UserInfo>
            </v-col>
        </v-row>

<!--        <v-row>-->
<!--            <v-col cols="12" md="12" lg="8" offset-xl="2">-->
<!--                <ChangePassword></ChangePassword>-->
<!--            </v-col>-->
<!--        </v-row>-->
    </v-container>
</template>

<script>
import SideBar from "@/components/dashboard/SideBar.vue";
import UserInfo from "@/components/login/UserInfo.vue";
import ChangePassword from "@/components/login/ChangePassword.vue";

export default {
    name: "ProfileView",
    components: {ChangePassword, UserInfo, SideBar},
}
</script>

<style scoped>
</style>
