<script setup>
import MainLayout from "@/layouts/MainLayout.vue";
import {GoogleMap, CustomMarker} from 'vue3-google-map'
import {useCourierLocationStore} from "@/store";
import {computed, onMounted, onUnmounted} from "vue";
import IconDeliveryMan from "@/components/IconDeliveryMan.vue";

const courierLocationStore = useCourierLocationStore();

const center = { lat: 50.4501000, lng: 30.5234000 };

const courierLocations = computed(() => courierLocationStore.courierLocations);

onMounted( () => {
    courierLocationStore.listenToCourierLocationUpdates();
});

onUnmounted( () => {
    courierLocationStore.stopListeningToCourierLocationUpdates();
});
</script>

<template>
    <MainLayout :space="false" :fullHeight="true">
        <GoogleMap
            api-key="AIzaSyD59YY6PcR25dpkpXmyJ-0y_cCkUJYWamI"
            style="width: 100%; height: 100%;"
            :center="center"
            :zoom="10"
        >
            <CustomMarker  v-for="(location, index) in courierLocations" :key="location.courier_id" :options="{ position: {
                lat: location.latitude,
                lng: location.longitude
            } }">
                <div class="flex flex-col items-center justify-center">
                    <span class="bg-amber-400 rounded p-1">{{location.courier_id}}</span>
                    <icon-delivery-man style="width: 50px; height: 50px;" />
                </div>
            </CustomMarker>
        </GoogleMap>
    </MainLayout>
</template>
