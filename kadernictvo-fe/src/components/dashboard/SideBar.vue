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
                    >
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
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
</template>

<script>
import axios from "axios";

export default {
    name: "SideBar",
    data: () => ({
        drawer: false,
        group: null,
        email: 'email@email.com',
        dashboardItems: [
            {title: 'Dashboard', value: 'dashboard', icon: "mdi-view-dashboard"},
            {title: 'Calendar', value: 'calendar', icon: "mdi-calendar-blank"},
            {title: 'Customers', value: 'customers', icon: "mdi-account-multiple"},
            {title: 'Report', value: 'report', icon: "mdi-chart-bar"},
        ],
        profileItems: [
            {title: "My profile", value: 'profile'},
            {title: "Settings", value: "settings"},
            {title: "Logout", value: "logout"}
        ],
        languages: [
            {name: "English", short: "EN"},
            {name: "Slovak", short: "SK"}
        ]
    }),

    watch: {
        group() {
            this.drawer = false;
        },
    },

    methods: {
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
                default:
                    console.log(`Navigating to ${item.value}`);
            }
        },

        async logout() {
            try {
                const response = await axios.post(
                    'http://localhost:8000/api/logout',
                    {},
                    {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer ' + decodeURIComponent($cookies.get('token'))
                        }
                    }
                );
                $cookies.remove('token');
                this.$router.push('/login');
            } catch (error) {
                console.log(error);
            }
        },
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
}

.dashboard-item:hover,
.navbarTile:hover {
    background-color: rgba(0, 0, 0, 0.1) !important;
    color: black !important;
}

.dashboard-item .v-list-item__title,
.navbarTile .v-list-item__title {
    color: black !important;
}

.active-list-item {
    background-color: rgba(0, 0, 0, 0.1) !important;
    color: black !important;
}

.v-list-item {
    transition: none !important;
}

.v-list-item:hover {
    background-color: rgba(0, 0, 0, 0.1) !important;
    color: black !important;
}
</style>




