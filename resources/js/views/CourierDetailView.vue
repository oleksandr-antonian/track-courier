<script setup>
import { useRoute, useRouter } from 'vue-router';
import {Breadcrumb, InputText, Select, Button, Skeleton} from 'primevue';
import MainLayout from "@/layouts/MainLayout.vue";
import {computed, onBeforeMount, ref} from "vue";
import {useCourierStore, useCityStore} from "../store";
import {useToast} from "primevue/usetoast";

const route = useRoute();
const router = useRouter();
const toast = useToast();

const loading = ref(false);
const saveLoading = ref(false);

const courierId = route.params.id;

const courierStore = useCourierStore();
const cityStore = useCityStore();

const availabilityStatuses = computed(() => courierStore.availabilityStatuses);
const transportTypes = computed(() => courierStore.transportTypes);
const cities = computed(() => cityStore.cities);

onBeforeMount(async () => {
    loading.value = true;
    await Promise.all([
        courierStore.fetchAvailabilityStatuses(),
        courierStore.fetchTransportTypes()
    ]);
    if (courierId !== 'new' && isNaN(parseInt(courierId))) {
        await router.push({name: 'couriers'});
    } else if (courierId !== 'new') {
        try {
            const response = await courierStore.fetchCourier(parseInt(courierId));
            await cityStore.fetchCities();
            form.value = response.data;
        } catch (e) {
            toast.add({severity: 'error', summary: 'Error', detail: 'Courier not found'});
            await router.push({name: 'couriers'});
        }
    }
    loading.value = false;
});

const form = ref({
    id: courierId === 'new' ? null : parseInt(courierId),
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    availability_status: null,
    transport_type: null,
    city: null,
    city_id: null,
});

const saveCourier = async () => {
    saveLoading.value = true;
    try {
        if (courierId === 'new') {
            await courierStore.createCourier(form.value);
            toast.add({severity: 'success', summary: 'Success', detail: 'Courier created'});
        } else {
            await courierStore.updateCourier(courierId, form.value);
            toast.add({severity: 'success', summary: 'Success', detail: 'Courier updated'});
        }
        await router.push({name: 'couriers'});
    } catch (e) {
        toast.add({severity: 'error', summary: 'Error', detail: e.message});
    } finally {
        saveLoading.value = false;
    }
};
</script>

<template>
    <MainLayout>
        <Breadcrumb :model="[{label: 'Couriers', route: '/couriers', icon: 'pi pi-home'}, {label: 'Courier Detail'}]">
            <template #item="{ item, props }">
                <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                    <a :href="href" v-bind="props.action" @click="navigate">
                        <span :class="[item.icon, 'text-color']" />
                        <span>{{ item.label }}</span>
                    </a>
                </router-link>
                <span v-else>{{item.label}}</span>
            </template>
        </Breadcrumb>
        <h2 class="text-2xl font-semibold mb-4">{{ courierId === 'new' ? 'New Courier' : 'Courier Detail' }}</h2>
        <div class="mt-6 lg:max-w-2xl" v-if="!loading">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <InputText v-model="form.first_name" placeholder="First Name" fluid />
                </div>
                <div>
                    <InputText v-model="form.last_name" placeholder="Last Name" fluid />
                </div>
                <div>
                    <InputText v-model="form.email" placeholder="Email" fluid />
                </div>
                <div>
                    <InputText v-model="form.phone" placeholder="Phone" fluid />
                </div>
                <div>
                    <Select v-model="form.availability_status" :options="availabilityStatuses" optionLabel="label" placeholder="Availability Status" fluid option-value="value" />
                </div>
                <div>
                    <Select v-model="form.transport_type" :options="transportTypes" optionLabel="label" placeholder="Transport Type" fluid option-value="value" />
                </div>
                <div>
                    <Select v-model="form.city_id" :options="cities" optionLabel="name" placeholder="City" fluid option-value="id" />
                </div>
            </div>
            <Button label="Save" class="mt-6" fluid @click="saveCourier" :loading="saveLoading" />
        </div>
        <div class="mt-6 lg:max-w-2xl" v-else>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <Skeleton width="100%" height="2rem" />
                <Skeleton width="100%" height="2rem" />
                <Skeleton width="100%" height="2rem" />
                <Skeleton width="100%" height="2rem" />
                <Skeleton width="100%" height="2rem" />
                <Skeleton width="100%" height="2rem" />
                <Skeleton width="100%" height="2rem" />
            </div>
            <Skeleton width="100%" height="2rem" class="mt-6" />
        </div>
    </MainLayout>
</template>

<style scoped>

</style>
