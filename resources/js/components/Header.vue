<script setup>
import {Menubar, Avatar, Menu} from 'primevue';
import { useRouter } from 'vue-router';
import { ref, computed } from "vue";
import { vOnClickOutside } from '@vueuse/components'
import {useAuthStore} from "../store/index.js";

const router = useRouter();
const currentRouteName = computed(() => router.currentRoute.value.name);

const authStore = useAuthStore();
const user = ref(authStore.user);
const letterAvatar = computed(() => user.value.name.charAt(0).toUpperCase());

const items = ref([
  {
    label: 'Map',
    key: 'map',
    icon: 'pi pi-map',
    routerName: 'home',
  },
  {
    label: 'Couriers',
    key: 'couriers',
    icon: 'pi pi-users',
    routerName: 'couriers',
  },
  {
    label: 'Debug',
    key: 'debug',
    icon: 'pi pi-cog',
    routerName: 'debug',
  }
]);

const profileMenuItems = ref([
  {
    label: 'Profile',
    icon: 'pi pi-user',
    command: () => {
      router.push({name: 'profile'});
    }
  },
  {
    label: 'Logout',
    icon: 'pi pi-sign-out',
    command: async () => {
      await authStore.logout();
      await router.push({name: 'login'});
    }
  }
]);
const isOpenProfileMenu = ref(false);
const toggleProfileMenu = () => {
  isOpenProfileMenu.value = !isOpenProfileMenu.value;
}
const closeProfileMenu = () => {
  isOpenProfileMenu.value = false;
}
</script>

<template>
  <div>
    <Menubar :model="items">
      <template #item="{ item }">
        <router-link :to="{name: item.routerName}" class="flex items-center gap-2 py-2 px-4 rounded" :class="{'bg-primary-500 text-white': currentRouteName === item.routerName}">
          <i :class="item.icon"></i>
          <span>{{ item.label }}</span>
        </router-link>
      </template>
      <template #end>
        <div class="relative">
          <div class="flex items-center gap-2 py-2 px-4 rounded cursor-pointer hover:bg-slate-100 transition-colors avatar" @click="toggleProfileMenu">
            <Avatar :label="letterAvatar" class="mr-2" />
            <span>{{ user.name }}</span>
          </div>
          <transition name="fade">
            <div class="absolute top-full left-0 right-0 mt-1 z-10" v-on-click-outside="closeProfileMenu" v-if="isOpenProfileMenu">
              <Menu :model="profileMenuItems" />
            </div>
          </transition>
        </div>
      </template>
    </Menubar>
  </div>
</template>

<style scoped>

</style>
