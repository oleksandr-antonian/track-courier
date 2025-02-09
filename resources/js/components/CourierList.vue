<script setup>
import { onMounted } from "vue";
import { useCourierStore } from "@/store";
import {DataTable, Column, Paginator, Button, useConfirm} from "primevue";
import {useToast} from "primevue/usetoast";
import {useRouter} from "vue-router";

const courierStore = useCourierStore();
const confirm = useConfirm();
const toast = useToast();
const router = useRouter();

onMounted(async () => {
    await courierStore.fetchCouriers();
});

const onPageChange = (event) => {
    courierStore.fetchCouriers(event.page + 1);
};

const getAvailabilityStatus = (status) => {
    const availabilityStatus = courierStore.availabilityStatuses.find((item) => item.value === status);
    return availabilityStatus ? availabilityStatus.label : "";
};
const getTransportType = (type) => {
    const transportType = courierStore.transportTypes.find((item) => item.value === type);
    return transportType ? transportType.label : "";
};
const deleteCourier = (event, courier) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Do you want to delete this courier?',
        icon: 'pi pi-info-circle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity: 'danger'
        },
        accept: async () => {
            try {
                await courierStore.deleteCourier(courier.id);
                toast.add({ severity: 'success', summary: 'Success', detail: 'Courier deleted successfully' });
            } catch (error) {
                toast.add({ severity: 'error', summary: 'Error', detail: error.message });
            }
        }
    });
};
const editCourier = (courier) => {
    router.push({ name: 'courier', params: { id: courier.id } });
};
</script>

<template>
    <div>
        <DataTable :value="courierStore.couriers" :loading="courierStore.loading" data-key="id">
            <Column field="id" header="ID"></Column>
            <Column field="full_name" header="Name"></Column>
            <Column field="email" header="Email"></Column>
            <Column field="phone" header="Phone"></Column>
            <Column field="availability_status" header="Availability Status">
                <template #body="slotProps">
                    <span
                        :class="{
                            'bg-red-200 text-red-800': slotProps.data.availability_status === 0,
                            'bg-green-200 text-green-800': slotProps.data.availability_status === 1,
                            'bg-yellow-200 text-yellow-800': slotProps.data.availability_status === 2,
                        }"
                        class="px-2 py-1 rounded-full"
                    >
                        {{ getAvailabilityStatus(slotProps.data.availability_status) }}
                    </span>
                </template>
            </Column>
            <Column field="transport_type" header="Transport Type">
                <template #body="slotProps">
                    <span class="px-2 py-1 rounded-full">
                        {{ getTransportType(slotProps.data.transport_type) }}
                    </span>
                </template>
            </Column>
            <Column field="city.name" header="City"></Column>
            <Column class="w-24 !text-end" header="Actions">
                <template #body="{ data }">
                    <div class="flex justify-end space-x-2">
                        <Button icon="pi pi-trash" class="p-button-rounded p-button-danger p-button-outlined" @click="deleteCourier($event, data)" />
                        <Button icon="pi pi-pencil" class="p-button-rounded p-button-primary p-button-outlined" @click="editCourier(data)" />
                    </div>
                </template>
            </Column>
        </DataTable>

        <Paginator
            :rows="courierStore.pagination.per_page"
            :totalRecords="courierStore.pagination.total"
            @page="onPageChange"
        />
    </div>
</template>
