<template>
    <section>
        <Nav />
    </section>

    <section>
        <slot />
    </section>
</template>

<script setup>
    import Nav from "./Nav.vue";
</script>
