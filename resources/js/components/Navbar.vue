<template>
  <nav class="fixed top-0 left-0 w-full bg-pink-400 text-white shadow-md z-50">
    <div class="w-full flex justify-between items-center px-2 py-3">

      <!-- 🔹 Logo -->
      <div class="bg-white p-2 rounded-xl shadow-md flex items-center ml-2">
        <img src="/images/logo.png" alt="Logo" class="h-10 w-auto" />
      </div>

      <!-- 🔹 Menu Navigasi -->
      <ul class="flex space-x-4">
        <li>
          <a href="/" class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md transition">Beranda</a>
        </li>
        <li>
          <a href="/cek-status" class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md transition">Cek Status</a>
        </li>
        <li>
          <a href="/reservasi" class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md transition">Reservasi</a>
        </li>
      </ul>

      <!-- 🔹 Auth buttons or Profile icon -->
      <div class="relative">
        <template v-if="!user">
          <button @click="login" class="bg-white text-pink-600 font-semibold px-4 py-1 rounded-lg border border-pink-500 hover:bg-pink-100 mx-1 transition">Login</button>
          <button @click="register" class="bg-pink-600 text-white font-semibold px-4 py-1 rounded-lg border hover:bg-pink-700 mx-1 transition">Register</button>
        </template>
        <template v-else>
          <div @click="sidebarOpen = !sidebarOpen" class="flex items-center justify-center bg-white rounded-full border-[3px] border-pink-400 p-1.5 mr-2 shadow-md hover:scale-105 hover:shadow-lg transition cursor-pointer">
            <span class="material-icons text-black text-3xl">person</span>
          </div>
          <!-- Sidebar/Dropdown for account -->
          <transition name="fade">
            <div v-if="sidebarOpen" class="absolute right-2 top-12 min-w-[170px] bg-white border border-pink-200 shadow-lg rounded-xl z-50 py-2 px-3 text-black">
              <p class="font-bold mb-2">{{user.nama_user || user.name || 'Account'}}</p>
              <a @click.prevent="goProfile" class="block py-1 px-2 rounded hover:bg-pink-100">Edit Profile</a>
              <a v-if="user.role === 'admin'" href="/admin/dashboard" class="block py-1 px-2 rounded hover:bg-pink-100">Dashboard Admin</a>
              <hr class="my-2">
              <a @click.prevent="logout" class="block py-1 px-2 rounded text-red-600 hover:bg-pink-100">Logout</a>
            </div>
          </transition>
        </template>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
const sidebarOpen = ref(false)
const page = usePage()
const user = computed(() => page.props?.auth?.user || null)
function logout() {
  sidebarOpen.value = false
  router.post('/logout')
}
function goProfile() {
  sidebarOpen.value = false
  router.visit('/user-profile')
}
function login() {
  router.visit('/login')
}
function register() {
  router.visit('/masuk')
}
</script>

<style scoped>
nav {
  font-family: "Poppins", sans-serif;
}
.fade-enter-active, .fade-leave-active { transition: opacity .15s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
