<template>
    <div v-if="!loading">
        <div class="flex items-center space-x-4 mb-4 justify-between">
            <Select v-model="currentCourierId" :options="couriers" optionLabel="full_name" option-value="id" placeholder="Select a courier" />
            <div v-if="currentCourier" class="flex items-center space-x-4">
                <span>Transport Type: {{ transportTypes[currentCourier.transport_type].label }}</span>
                <span>Speed (m/s): {{transportTypes[currentCourier.transport_type].speed}}</span>
                <span>Distance: {{ Number(distance).toFixed(2) }} m</span>
                <span v-if="distance > 0">Time: {{ Number(time).toFixed(2) }} s</span>
            </div>
            <div v-if="currentCourier" class="flex items-center space-x-4 gap-2">
                <Button label="Clear" severity="danger" @click="Clear" />
                <Button label="Simulate" @click="simulateCourier" :loading="startSimulation" />
            </div>

        </div>
        <div v-if="currentCourier">
            <GoogleMap
                api-key="AIzaSyD59YY6PcR25dpkpXmyJ-0y_cCkUJYWamI"
                style="width: 100%; height: 500px;"
                :center="center"
                :zoom="15"
                @click="addMarker"
            >
                <Marker
                    v-for="(marker, index) in markers.slice(1)"
                    :key="index"
                    :options="marker"
                />
                <Polyline
                    :options="{
                    ...polylineOptions,
                    path: markers.map(marker => marker.position),
                }"
                />
                <CustomMarker v-if="currentCourierPosition" :options="{ position: currentCourierPosition }">
                    <div style="text-align: center">
                        <icon-delivery-man style="width: 50px; height: 50px;" />
                    </div>
                </CustomMarker>
            </GoogleMap>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from 'vue';
import {Button, Select} from 'primevue';
import {GoogleMap, Marker, Polyline, CustomMarker} from 'vue3-google-map';
import {getDistance} from 'geolib';
import {useCourierStore, useCourierLocationStore} from "@/store";
import IconDeliveryMan from "@/components/IconDeliveryMan.vue";

const transportTypes = [
    { label: 'Walking', value: 0, speed: 1.4, updateInterval: 10 },
    { label: 'Bicycle / ElectricBike', value: 1, speed: 4.2, updateInterval: 5 },
    { label: 'Scooter / ElectricScooter', value: 2, speed: 5.0, updateInterval: 5 },
    { label: 'Car / Motorcycle / Truck', value: 3, speed: 13.9, updateInterval: 2 }
]

const courierStore = useCourierStore();
const courierLocationStore = useCourierLocationStore();
const startSimulation = ref(false);

const loading = courierStore.loading;

onMounted(async () => {
    await courierStore.fetchCouriers();
});

const couriers = computed(() => courierStore.couriers);

const currentCourierId = ref(null);
const currentCourier = computed(() => couriers.value.find((courier) => courier.id === currentCourierId.value));
const currentCourierPosition = ref(null);
const center = ref(null);
const distance = ref(0);
const time = ref(0);
const route = ref([]);

watch(() => currentCourier.value, () => {
    calculateDistance();
    calculateTime();
    if (currentCourier.value) {
        center.value = {
            lat: Number(currentCourier.value.location.lat),
            lng: Number(currentCourier.value.location.lng),
        };
        currentCourierPosition.value = center.value;
        route.value = [center.value];
    }
});

const markers = computed(() => route.value.map((point) => ({
    position: point,
})));

const polylineOptions = computed(() => ({
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 2,
    path: route.value
}));

const addMarker = (event) => {
    route.value.push({
        lat: event.latLng.lat(),
        lng: event.latLng.lng(),
    });
    if (markers.value.length > 1) {
        calculateDistance();
        calculateTime();
    }
};
const calculateDistance = () => {
    distance.value = route.value.reduce((acc, point, index) => {
        if (index === 0) {
            return acc;
        }
        const prevPoint = route.value[index - 1];
        return acc + getDistance(point, prevPoint);
    }, 0);
};

const calculateTime = () => {
    if (!currentCourier.value) {
        return 0;
    }
    time.value = distance.value / transportTypes[currentCourier.value.transport_type].speed;
};

let interval = null;

function interpolatePoints(points, totalPoints) {
    const result = [];

    // Считаем общее количество сегментов (между точками)
    const segmentCount = points.length - 1;

    // Для каждой пары точек
    for (let i = 0; i < segmentCount; i++) {
        const start = points[i];
        const end = points[i + 1];

        // Количество точек на данном сегменте
        const segmentPointsCount = Math.floor(totalPoints / segmentCount);

        // Добавляем саму начальную точку
        if (i === 0) {
            result.push(start);
        }

        // Генерация промежуточных точек между start и end
        for (let j = 1; j < segmentPointsCount; j++) {
            const ratio = j / segmentPointsCount;
            const lat = start.lat + (end.lat - start.lat) * ratio;
            const lng = start.lng + (end.lng - start.lng) * ratio;
            result.push({ lat, lng });
        }
    }

    // Добавляем последнюю точку
    result.push(points[points.length - 1]);

    return result;
}

const simulateCourier = () => {
    if (route.value.length < 2) {
        alert('Please add at least two points to simulate the courier');
        return;
    }
    if (interval) {
        clearInterval(interval);
    }
    startSimulation.value = true;
    const timeParts = Math.ceil(time.value / transportTypes[currentCourier.value.transport_type].updateInterval);
    const points = interpolatePoints(route.value, timeParts);
    interval = setInterval(() => {
        if (points.length === 0) {
            clearInterval(interval);
            route.value = [currentCourierPosition.value];
            startSimulation.value = false;
            return;
        }
        currentCourierPosition.value = points.shift();
        courierLocationStore.updateCourierLocation(currentCourier.value.id, currentCourierPosition.value);
    }, transportTypes[currentCourier.value.transport_type].updateInterval * 1000);
};

const Clear = () => {
    route.value = [currentCourierPosition.value];
    distance.value = 0;
    time.value = 0;
    startSimulation.value = false;
    if (interval) {
        clearInterval(interval);
    }
};
</script>

<style scoped>
</style>
