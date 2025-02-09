<script setup>
import {useAuthStore} from "@/store";
import MainLayout from "@/layouts/MainLayout.vue";
import {ref} from "vue";

const authStore = useAuthStore();

const user = ref(authStore.user);
</script>

<template>
    <MainLayout>
        <h1>Hi {{ user.name }}</h1>
    </MainLayout>
</template>

<style scoped>

</style>
