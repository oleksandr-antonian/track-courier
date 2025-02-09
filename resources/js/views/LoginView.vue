<template>
    <div class="flex items-center justify-center h-screen w-full">
        <Card style="width: 25rem; overflow: hidden">
            <template #title>
                <h2 class="text-center text-2xl mb-4">Login</h2>
            </template>
            <template #subtitle>
                <p>Enter your credentials to login.</p>
            </template>
            <template #content>
                <div class="mb-4">
                    <InputText v-model="email" placeholder="Enter your email" fluid class="mb-4" />
                    <Password v-model="password" :feedback="false" toggleMask placeholder="Enter your password" fluid />
                </div>
            </template>
            <template #footer>
                <Button label="Login" class="w-full" @click="login" :loading="loading" />
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Button, Card, InputText, Password } from 'primevue';
import { useAuthStore } from '../store';
import { useToast } from 'primevue/usetoast';
import {useRouter} from "vue-router";

const router = useRouter();
const authStore = useAuthStore();
const toast = useToast();
const email = ref('');
const password = ref('');
const loading = ref(false);

const login = async () => {
    try {
        loading.value = true;
        const response = await authStore.login(email.value, password.value);
        toast.add({ severity: 'success', summary: 'Success Message', detail: response.message });
        await router.push({name: 'home'});
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error Message', detail: error.message });
    } finally {
        loading.value = false;
    }
};
</script>
