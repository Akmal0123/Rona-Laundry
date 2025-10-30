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
          <a
            href="/"
            class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md transition"
          >
            Beranda
          </a>
        </li>
        <li>
          <a
            href="/cek-status"
            class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md transition"
          >
            Cek Status
          </a>
        </li>
        <li>
          <a
            href="/reservasi"
            class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-md transition"
          >
            Reservasi
          </a>
        </li>
      </ul>

      <!-- 🔹 Ikon Akun -->
      <div
        class="flex items-center justify-center bg-white rounded-full border-[3px] border-pink-400 p-1.5 mr-2 shadow-md hover:scale-105 hover:shadow-lg transition"
      >
        <span class="material-icons text-black text-3xl">
          person
        </span>
      </div>

    </div>
  </nav>
</template>

<script setup>
</script>

<style scoped>
nav {
  font-family: "Poppins", sans-serif;
}
</style>
