<template>
    <div>
        <router-link to="/">Home</router-link>
        <router-link to="/about">About</router-link>
        <router-link to="/login">Log In</router-link>
        <h1>Hello World!</h1>
        <h2>{{title}}</h2>
    </div>
</template>

<script>
    export default {
        name: "root",
        data : function () {
            return {
                title : 'Laratube Project',
            }
        }

    }
</script>

<style scoped>

</style>
