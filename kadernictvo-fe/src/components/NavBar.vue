<template>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="../assets/logo-light.png"
                                                  alt="logo"
                                                  width="100px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="#">Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">O nás</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="#">Služby</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Galéria</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="#">Kontakt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Online rezervácia</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "NavBar"
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

    .navbar-collapse{
        text-align: center;
    }

</style>


