<script setup>
import MainLayout from "@/layouts/MainLayout.vue";
import CourierList from "@/components/CourierList.vue";
import {Button} from "primevue";
import {onBeforeMount} from "vue";
import {useCourierStore} from "@/store";
import {useRouter} from "vue-router";

const courierStore = useCourierStore();
const router = useRouter();

onBeforeMount(async () => {
    await Promise.all([
        courierStore.fetchAvailabilityStatuses(),
        courierStore.fetchTransportTypes()
    ]);
});
</script>

<template>
    <MainLayout>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold mb-4">Couriers</h2>
            <Button label="Add Courier" icon="pi pi-plus" @click="router.push({ name: 'courier', params: { id: 'new' } })" />
        </div>
        <CourierList />
    </MainLayout>
</template>

<style scoped>

</style>
