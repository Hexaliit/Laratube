<template>
    <div>
        <h1>Welcome to About Page</h1>
        <h2>{{title}}</h2>
    </div>
</template>

<script>
    export default {
        name: "AboutComponent",
        data : function () {
            return {
                title: 'This is about page'
            }
        }
    }
</script>

<style scoped>

</style>
