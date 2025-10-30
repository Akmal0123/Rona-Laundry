<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
const users = ref([])
const loading = ref(false)
const showCreate = ref(false)
const showEdit = ref(false)
const form = ref({nama_user:'', email:'', password:'', no_whatsapp:'', alamat:'', role:''})
const editId = ref(null)
async function loadUsers() {
  loading.value = true
  try {
    const res = await fetch('/admin/users')
    const data = await res.json()
    users.value = data.data
  } finally { loading.value = false }
}
function openCreate() {
  showCreate.value = true
  form.value = {nama_user:'', email:'', password:'', no_whatsapp:'', alamat:'', role:''}
}
async function createUser() {
  await fetch('/admin/users', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(form.value)})
  showCreate.value = false
  loadUsers()
}
function openEdit(user) {
  showEdit.value = true
  editId.value = user.id
  form.value = {...user, password:''}
}
async function editUser() {
  await fetch(`/admin/users/${editId.value}`, {method:'PUT', headers:{'Content-Type':'application/json'}, body:JSON.stringify(form.value)})
  showEdit.value = false
  loadUsers()
}
async function delUser(id) {
  if (confirm('Hapus user ini?')) {
    await fetch(`/admin/users/${id}`, {method:'DELETE'})
    loadUsers()
  }
}
onMounted(loadUsers)
</script>
<template>
  <div class="p-8"><h2 class="text-2xl mb-6 font-bold">User Management</h2>
    <button @click="openCreate" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">Tambah User</button>
    <div v-if="loading">Loading...</div>
    <table class="w-full border mt-2">
      <thead><tr class="bg-gray-100">
        <th class="border p-2">Nama</th><th class="border p-2">Email</th><th class="border p-2">WhatsApp</th><th class="border p-2">Alamat</th><th class="border p-2">Role</th><th class="border p-2">Aksi</th>
      </tr></thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="border p-2">{{user.nama_user}}</td><td class="border p-2">{{user.email}}</td>
          <td class="border p-2">{{user.no_whatsapp}}</td><td class="border p-2">{{user.alamat}}</td><td class="border p-2">{{user.role}}</td>
          <td class="border p-2"><button @click="openEdit(user)" class="mr-2 text-yellow-700">Edit</button><button @click="delUser(user.id)" class="text-red-700">Hapus</button></td>
        </tr>
      </tbody>
    </table>
    <!-- Create Dialog -->
    <div v-if="showCreate" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30"><div class="bg-white p-8 rounded shadow w-80">
      <h3 class="mb-4 font-semibold">Tambah User</h3>
      <input v-model="form.nama_user" class="block border mb-2 w-full p-1" placeholder="Nama">
      <input v-model="form.email" class="block border mb-2 w-full p-1" placeholder="Email">
      <input v-model="form.password" type="password" class="block border mb-2 w-full p-1" placeholder="Password">
      <input v-model="form.no_whatsapp" class="block border mb-2 w-full p-1" placeholder="No WhatsApp">
      <input v-model="form.alamat" class="block border mb-2 w-full p-1" placeholder="Alamat">
      <input v-model="form.role" class="block border mb-2 w-full p-1" placeholder="Role">
      <button @click="createUser" class="bg-blue-600 text-white px-4 py-1 rounded mr-2">Simpan</button>
      <button @click="showCreate=false" class="px-4 py-1">Batal</button>
    </div></div>
    <!-- Edit Dialog -->
    <div v-if="showEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30"><div class="bg-white p-8 rounded shadow w-80">
      <h3 class="mb-4 font-semibold">Edit User</h3>
      <input v-model="form.nama_user" class="block border mb-2 w-full p-1" placeholder="Nama">
      <input v-model="form.email" class="block border mb-2 w-full p-1" placeholder="Email">
      <input v-model="form.password" type="password" class="block border mb-2 w-full p-1" placeholder="Password (isi jika ingin ganti)">
      <input v-model="form.no_whatsapp" class="block border mb-2 w-full p-1" placeholder="No WhatsApp">
      <input v-model="form.alamat" class="block border mb-2 w-full p-1" placeholder="Alamat">
      <input v-model="form.role" class="block border mb-2 w-full p-1" placeholder="Role">
      <button @click="editUser" class="bg-blue-600 text-white px-4 py-1 rounded mr-2">Update</button>
      <button @click="showEdit=false" class="px-4 py-1">Batal</button>
    </div></div>
  </div>
</template>
