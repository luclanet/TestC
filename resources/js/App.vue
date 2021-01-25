<template>
    <div class="app">
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import './Styles/app.scss';

    export default {
        name: 'app'
    }
</script>