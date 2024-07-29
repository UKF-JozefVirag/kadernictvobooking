<template>
    <v-layout>
        <v-app-bar color="black" prominent absolute id="sidebar">
            <v-app-bar-nav-icon variant="text" color="white" :ripple="false"
                                @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
            <v-menu transition="scale-transition">
                <template v-slot:activator="{ props }">
                    <v-btn color="white" :ripple="false" v-bind="props">
                        {{ email }}
                        <BIconCaretDownFill id="icon-caret"></BIconCaretDownFill>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                        v-for="(item, index) in profileItems"
                        :key="index"
                        :value="index"
                        @click="handleProfileItemClick(item)"
                        class="navbarTile"
                        :active-class="'active-list-item'"
                        :v-ripple="false"
                    >
                        <v-list-item-title >{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" :location="$vuetify.display.mobile ? 'bottom' : 'left'" clipped>
            <v-list>
                <v-list-item
                    v-for="(item, index) in dashboardItems"
                    :key="index"
                    :value="index"
                    :prepend-icon="item.icon"
                    @click="handleProfileItemClick(item)"
                    class="dashboard-item"
                    :active-class="'active-list-item'"
                >
                    <template v-slot:prepend>
                        <v-icon>{{ item.icon }}</v-icon>
                    </template>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </v-layout>
    <SnackComponent color="red" :text="snackText" :snack-open="snackOpen"></SnackComponent>
</template>

<script>
import axios from "axios";
import axiosInstance from '@/axios.js'
import SnackComponent from '@/components/common/SnackComponent.vue'

export default {
    name: "SideBar",
    components: { SnackComponent },
    data: () => ({
        drawer: false,
        group: null,
        email: 'User',
        dashboardItems: [],
        profileItems: [],
        languages: [
            {name: "English", short: "EN"},
            {name: "Slovak", short: "SK"}
        ],
        snackText: "",
        snackOpen: false
    }),

    watch: {
        group() {
            this.drawer = false;
        },
    },
    created() {
        this.getUser();
        this.initializeMenuItems();
    },

    methods: {
        async getUser() {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const response = await axiosInstance('/user', {
                    headers: {
                        Authorization: `Bearer ${decodeURIComponent($cookies.get('token'))}`
                    }
                });
                this.email = response.data.email;
            } catch (error) {
                this.snackOpen = true;
                this.snackText = "Error logging out: " + error;
                return null;
            }
        },

        initializeMenuItems() {
            this.dashboardItems = [
                {title: this.$t('sidebar.dashboard'), value: 'dashboard', icon: "mdi-view-dashboard"},
                {title: this.$t('sidebar.calendar'), value: 'calendar', icon: "mdi-calendar-blank"},
                // {title: this.$t('sidebar.customers'), value: 'customers', icon: "mdi-account-multiple"},
                // {title: this.$t('sidebar.report'), value: 'report', icon: "mdi-chart-bar"},
                {title: this.$t('sidebar.employees'), value: 'employee', icon: "mdi-account-group"},
                {title: this.$t('sidebar.services'), value: 'service', icon: "mdi-briefcase"},
            ];
            this.profileItems = [
                {title: this.$t('sidebar.profile'), value: 'profile'},
                // {title: this.$t('sidebar.settings'), value: "settings"},
                {title: this.$t('sidebar.logout'), value: "logout"}
            ];
        },

        handleProfileItemClick(item) {
            switch (item.value) {
                case "logout":
                    this.logout();
                    break;
                case "profile":
                    this.$router.push('/profile');
                    break;
                case "dashboard":
                    this.$router.push('/dashboard');
                    break;
                case "calendar":
                    this.$router.push('/calendar');
                    break;
                case "employee":
                    this.$router.push('/employee');
                    break;
                case "service":
                    this.$router.push('/services');
                    break;
            }
        },

        async logout() {
            try {
                const token = decodeURIComponent($cookies.get('token'));
                if (!token) {
                    throw new Error('No token found');
                }

                await axiosInstance.post(
                    '/logout',
                    {},
                    {
                        headers: {
                            'Authorization': 'Bearer ' + token
                        }
                    }
                );

                $cookies.remove('token');
                this.$router.push('/login');
            } catch (error) {
                console.error('Logout Error:', error);
                this.snackOpen = true;
                this.snackText = "Error logging out: " + error.message;
            }
        }

    }
}
</script>


<style lang="scss" scoped>
#icon-caret {
    color: white;
}

#sidebar {
    position: static !important;
}

.dashboard-item,
.navbarTile {
    background-color: white !important;
    transition: none !important;
    &:hover, &:active {
        background-color: rgba(0, 0, 0, 0.1) !important;
        color: black !important;
    }
    .v-list-item__title {
        color: black !important;
    }
}

.active-list-item {
    background-color: rgba(0, 0, 0, 0.1) !important;
    color: black !important;
}

.v-list-item {
    transition: none !important;
    &:hover, &:active {
        background-color: rgba(0, 0, 0, 0.1) !important;
        color: black !important;
    }
}

.dashboard-item:deep(.v-btn__overlay) {
    display: none;
}
.dashboard-item:deep(.v-btn__underlay) {
    display: none;
}
.dashboard-item:deep(.v-ripple__container) {
    display: none;
}
</style>





