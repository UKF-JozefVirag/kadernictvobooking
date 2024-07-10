<template>
    <header class="header" id="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="../assets/images/logo-light.png" alt="logo" width="50px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="header-nav">
                    <ul class="navbar-nav mx-auto header-nav">
                        <li class="nav-item mx-5">
                            <router-link to="/" class="nav-link" href="#header">{{ $t('nav.home') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <a href="/#about-us" class="nav-link">{{ $t('nav.about') }}</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a href="/#services" class="nav-link">{{ $t('nav.services') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="/#gallery" class="nav-link">{{ $t('nav.gallery') }}</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a href="/#contact-us" class="nav-link">{{ $t('nav.contact') }}</a>
                        </li>
                        <li class="nav-item">
                            <router-link to="/reservation" class="nav-link">{{ $t('nav.reservation') }}</router-link>
                        </li>
                        <li class="nav-item mx-3 dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ ($i18n.locale).toUpperCase() }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" @click="changeLanguage('sk')">SK</a></li>
                                <li><a class="dropdown-item" @click="changeLanguage('en')">EN</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: "NavBar",
    methods: {
        changeLanguage(lang) {
            this.$i18n.locale = lang;
            localStorage.setItem('language', lang); // Uložte jazyk do localStorage
        }
    },
    created() {
        const savedLanguage = localStorage.getItem('language');
        if (savedLanguage) {
            this.$i18n.locale = savedLanguage;
        }
    }
};
</script>

<style>
.nav-item {
    font-size: large;
    white-space: nowrap;
}

.nav-item::after {
    content: '';
    display: block;
    width: 0;
    height: 2px;
    background: #ffffff;
    transition: width .3s;
}

.nav-item:hover::after {
    width: 100%;
    transition: width .3s;
}

.navbar-collapse {
    text-align: center;
    width: 100%;
}

.dropdown-menu-dark {
    background-color: black;
}

.dropdown-item {
    color: white;
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        text-align: center;
    }

    .navbar-nav {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100vw;
    }

    .nav-item {
        margin: 0.5rem 0;
    }
}
</style>
