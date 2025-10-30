<script setup>
import { ref, onMounted } from 'vue'
const payments = ref([])
const loading = ref(false)
async function loadPayments() {
  loading.value = true
  try {
    const res = await fetch('/admin/payments')
    const data = await res.json()
    payments.value = data.data
  } finally { loading.value = false }
}
async function verifyPayment(id) {
  await fetch(`/admin/payments/${id}/verify`, { method: 'POST' })
  loadPayments()
}
async function rejectPayment(id) {
  await fetch(`/admin/payments/${id}/reject`, { method: 'POST' })
  loadPayments()
}
onMounted(loadPayments)
</script>
<template>
<div class="p-8"><h2 class="text-2xl mb-6 font-bold">Payment Verification</h2>
  <div v-if="loading">Loading...</div>
  <table class="w-full border mt-2">
    <thead><tr class="bg-gray-100">
      <th class="border p-2">Order ID</th><th class="border p-2">User</th><th class="border p-2">Tanggal</th><th class="border p-2">Total</th><th class="border p-2">Status</th><th class="border p-2">Aksi</th>
    </tr></thead>
    <tbody>
      <tr v-for="payment in payments" :key="payment.id">
        <td class="border p-2">{{payment.order_id}}</td>
        <td class="border p-2">{{payment.user?.nama_user || '-'}}</td>
        <td class="border p-2">{{payment.tanggal}}</td>
        <td class="border p-2">{{payment.total}}</td>
        <td class="border p-2">{{payment.status}}</td>
        <td class="border p-2">
          <button @click="verifyPayment(payment.id)" class="bg-green-500 text-white px-2 rounded mr-2">Verifikasi</button>
          <button @click="rejectPayment(payment.id)" class="bg-red-500 text-white px-2 rounded">Tolak</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
</template>
