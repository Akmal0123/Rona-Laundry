<script setup>
import { ref, onMounted } from 'vue'
const products = ref([])
const loading = ref(false)
const showCreate = ref(false)
const showEdit = ref(false)
const form = ref({nama_layanan:'', harga_perkilo:'', harga_permeter:'', harga_satuan:''})
const editId = ref(null)
async function loadProducts() {
  loading.value = true
  try {
    const res = await fetch('/admin/products')
    const data = await res.json()
    products.value = data.data
  } finally { loading.value = false }
}
function openCreate() {
  showCreate.value = true
  form.value = {nama_layanan:'', harga_perkilo:'', harga_permeter:'', harga_satuan:''}
}
async function createProduct() {
  await fetch('/admin/products', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(form.value)})
  showCreate.value = false
  loadProducts()
}
function openEdit(product) {
  showEdit.value = true
  editId.value = product.id
  form.value = {...product}
}
async function editProduct() {
  await fetch(`/admin/products/${editId.value}`, {method:'PUT', headers:{'Content-Type':'application/json'}, body:JSON.stringify(form.value)})
  showEdit.value = false
  loadProducts()
}
async function delProduct(id) {
  if (confirm('Hapus produk ini?')) {
    await fetch(`/admin/products/${id}`, {method:'DELETE'})
    loadProducts()
  }
}
onMounted(loadProducts)
</script>
<template>
<div class="p-8"><h2 class="text-2xl mb-6 font-bold">Product Management</h2>
  <button @click="openCreate" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">Tambah Produk</button>
  <div v-if="loading">Loading...</div>
  <table class="w-full border mt-2">
    <thead><tr class="bg-gray-100">
      <th class="border p-2">Nama Layanan</th><th class="border p-2">Harga/Kg</th><th class="border p-2">Harga/meter</th><th class="border p-2">Harga Satuan</th><th class="border p-2">Aksi</th>
    </tr></thead>
    <tbody>
      <tr v-for="product in products" :key="product.id">
        <td class="border p-2">{{product.nama_layanan}}</td><td class="border p-2">{{product.harga_perkilo}}</td>
        <td class="border p-2">{{product.harga_permeter}}</td><td class="border p-2">{{product.harga_satuan}}</td>
        <td class="border p-2"><button @click="openEdit(product)" class="mr-2 text-yellow-700">Edit</button><button @click="delProduct(product.id)" class="text-red-700">Hapus</button></td>
      </tr>
    </tbody>
  </table>
  <!-- Create Dialog -->
  <div v-if="showCreate" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30"><div class="bg-white p-8 rounded shadow w-80">
    <h3 class="mb-4 font-semibold">Tambah Produk</h3>
    <input v-model="form.nama_layanan" class="block border mb-2 w-full p-1" placeholder="Nama Layanan">
    <input v-model="form.harga_perkilo" class="block border mb-2 w-full p-1" placeholder="Harga/Kg">
    <input v-model="form.harga_permeter" class="block border mb-2 w-full p-1" placeholder="Harga/Meter">
    <input v-model="form.harga_satuan" class="block border mb-2 w-full p-1" placeholder="Harga Satuan">
    <button @click="createProduct" class="bg-blue-600 text-white px-4 py-1 rounded mr-2">Simpan</button>
    <button @click="showCreate=false" class="px-4 py-1">Batal</button>
  </div></div>
  <!-- Edit Dialog -->
  <div v-if="showEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30"><div class="bg-white p-8 rounded shadow w-80">
    <h3 class="mb-4 font-semibold">Edit Produk</h3>
    <input v-model="form.nama_layanan" class="block border mb-2 w-full p-1" placeholder="Nama Layanan">
    <input v-model="form.harga_perkilo" class="block border mb-2 w-full p-1" placeholder="Harga/Kg">
    <input v-model="form.harga_permeter" class="block border mb-2 w-full p-1" placeholder="Harga/Meter">
    <input v-model="form.harga_satuan" class="block border mb-2 w-full p-1" placeholder="Harga Satuan">
    <button @click="editProduct" class="bg-blue-600 text-white px-4 py-1 rounded mr-2">Update</button>
    <button @click="showEdit=false" class="px-4 py-1">Batal</button>
  </div></div>
</div>
</template>
