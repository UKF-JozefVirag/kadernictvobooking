<template>
    <v-card>
        <v-layout>
            <v-app-bar color="black" prominent>
                <v-app-bar-nav-icon variant="text" color="white" :ripple="false" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

                <v-toolbar-title>Dashboard</v-toolbar-title>

                <v-spacer></v-spacer>

                <template v-if="$vuetify.display.mdAndUp">
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
                            >
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>

                <v-menu transition="scale-transition">
                    <template v-slot:activator="{ props }">
                        <v-btn color="white" v-bind="props" :ripple="false">
                            SK
                            <BIconCaretDownFill id="icon-caret"></BIconCaretDownFill>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item
                            v-for="(item, index) in languages"
                            :key="index"
                            :value="index"
                        >
                            <v-list-item-title>{{ item.short }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-app-bar>

            <v-navigation-drawer v-model="drawer" :location="$vuetify.display.mobile ? 'bottom' : undefined" temporary>
                <v-list>
                    <v-list-item
                        v-for="(item, index) in dashboardItems"
                        :key="index"
                        :value="index"
                    >
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

        </v-layout>
    </v-card>
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
            { title: 'Foo', value: 'foo' },
            { title: 'Bar', value: 'bar' },
            { title: 'Fizz', value: 'fizz' },
            { title: 'Buzz', value: 'buzz' },
        ],
        profileItems: [
            { title: "My profile", value: 'profile' },
            { title: "Settings", value: "settings" },
            { title: "Logout", value: "logout" }
        ],
        languages: [
            { name: "English", short: "EN" },
            { name: "Slovak", short: "SK" }
        ]
    }),

    watch: {
        group() {
            this.drawer = false;
        },
    },

    methods: {
        handleProfileItemClick(item) {
            if (item.value === 'logout') {
                this.logout();
            } else {
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
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
                    }
                );
                localStorage.removeItem('token');
                this.$router.push('/login');
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>

<style lang="scss" scoped>
#icon-caret {
    color: white;
}
</style>
