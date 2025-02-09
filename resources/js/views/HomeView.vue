<script setup>
import {useAuthStore} from "@/store";
import MainLayout from "@/layouts/MainLayout.vue";
import { GoogleMap, Marker } from 'vue3-google-map'
import {ref} from "vue";

const authStore = useAuthStore();

const user = ref(authStore.user);

const center = { lat: 40.689247, lng: -74.044502 }
</script>

<template>
    <MainLayout :space="false" :fullHeight="true">
        <GoogleMap
            api-key="AIzaSyD59YY6PcR25dpkpXmyJ-0y_cCkUJYWamI"
            style="width: 100%; height: 100%;"
            :center="center"
            :zoom="15"
        >
            <Marker :options="{ position: center }" />
        </GoogleMap>
    </MainLayout>
</template>

<style scoped>

</style>
