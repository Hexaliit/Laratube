<template>
    <div class="base">
        <HeaderAdmin></HeaderAdmin>
        <SidebarAdmin></SidebarAdmin>
    </div>
</template>

<script>
    import HeaderAdmin from "./HeaderAdmin";
    import SidebarAdmin from "./SidebarAdmin";
    export default {
        name: "base",
        components : {
            HeaderAdmin , SidebarAdmin ,
        },
    }
</script>

<style scoped>
    @import 'base.css';
</style>
