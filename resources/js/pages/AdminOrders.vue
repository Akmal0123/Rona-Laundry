<script setup>
import { ref, onMounted } from 'vue'
const orders = ref([])
const loading = ref(false)
async function loadOrders() {
  loading.value = true
  try {
    const res = await fetch('/admin/orders')
    const data = await res.json()
    orders.value = data.data
  } finally { loading.value = false }
}
onMounted(loadOrders)
function delOrder(id) {
  if(confirm('Hapus pesanan ini?')) {
    fetch(`/admin/orders/${id}`, {method:'DELETE'}).then(loadOrders)
  }
}
</script>
<template>
<div class="p-8">
  <h2 class="text-2xl mb-6 font-bold">Order Management</h2>
  <div v-if="loading">Loading...</div>
  <table class="w-full border mt-2">
    <thead><tr class="bg-gray-100">
      <th class="border p-2">ID</th><th class="border p-2">User</th><th class="border p-2">Tanggal</th>
      <th class="border p-2">Metode</th><th class="border p-2">Status</th><th class="border p-2">Total</th><th class="border p-2">Aksi</th>
    </tr></thead>
    <tbody>
      <tr v-for="order in orders" :key="order.id">
        <td class="border p-2">{{order.id}}</td>
        <td class="border p-2">{{order.user?.nama_user || '-'}}</td>
        <td class="border p-2">{{order.tanggal_masuk}}</td>
        <td class="border p-2">{{order.metode_pengambilan}}</td>
        <td class="border p-2">{{order.status_order}}</td>
        <td class="border p-2">{{order.total_harga}}</td>
        <td class="border p-2"><button class="mr-2 text-blue-700">Lihat</button><button @click="delOrder(order.id)" class="text-red-700">Hapus</button></td>
      </tr>
    </tbody>
  </table>
</div>
</template>
