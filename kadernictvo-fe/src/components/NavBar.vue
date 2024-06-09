<template>
    <header class="header" id="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="../assets/images/logo-light.png" alt="logo" width="80px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="header-nav">
                    <ul class="navbar-nav mx-auto header-nav">
                        <li class="nav-item mx-5">
                            <a class="nav-link" href="#header">{{ $t('nav.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about-us">{{ $t('nav.about') }}</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a class="nav-link" href="#services">{{ $t('nav.services') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gallery">{{ $t('nav.gallery') }}</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a class="nav-link" href="#contact-us">{{ $t('nav.contact') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ $t('nav.reservation') }}</a>
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
        }
    }
};
</script>

<style scoped>
li {
    font-size: large;
}

li::after {
    content: '';
    display: block;
    width: 0;
    height: 2px;
    background: #ffffff;
    transition: width .3s;
}

li:hover::after {
    width: 100%;
    transition: width .3s;
}

.navbar-collapse {
    text-align: center;
}

.dropdown-menu-dark {
    background-color: black;
}

.dropdown-item {
    color: white;
}
</style>
