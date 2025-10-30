<template>
  <div class="flex min-h-screen bg-pink-50 font-poppins">
    <!-- 🔹 Sidebar -->
    <Sidebar />
    <!-- 🔹 Main Content -->
    <main class="flex-1 p-8 overflow-y-auto ml-64">
      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <div class="flex items-center space-x-3">
          <span class="text-xl font-semibold text-slate-900">Admin</span>
          <span
            class="material-icons-round text-4xl text-slate-800 border-[1.5px] border-pink-400 rounded-full p-1 bg-pink-50 shadow-sm">
            person
          </span>
        </div>
      </div>
      <!-- Stats Cards -->
      <div class="grid grid-cols-4 gap-6 mb-8">
        <div v-for="card in stats" :key="card.title"
          class="bg-pink-100 border border-pink-300 p-4 rounded-xl shadow hover:shadow-lg transition">
          <div class="flex justify-between items-center mb-2">
            <p class="text-gray-600 font-medium">{{ card.title }}</p>
            <span class="material-icons text-pink-500">{{ card.icon }}</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-800">{{ card.value }}</h3>
        </div>
      </div>

      <!-- Chart Pemasukan Bulanan -->
      <div class="bg-white shadow-md rounded-xl p-6 mb-8">
        <h3 class="font-semibold text-gray-700 mb-4">Pemasukan Bulanan</h3>
        <div class="h-96">
          <apexchart type="bar" height="100%" :options="chartOptions" :series="chartSeries" />
        </div>
      </div>

      <!-- Recent Tables -->
      <div class="grid grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white shadow-md rounded-xl p-4">
          <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Recent Orders</h3>
            <button class="text-pink-500 hover:underline">View All</button>
          </div>
          <table class="w-full text-left text-gray-700">
            <thead class="bg-pink-100">
              <tr>
                <th class="py-2 px-3">Customer</th>
                <th class="py-2 px-3">Service</th>
                <th class="py-2 px-3">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in recentOrders" :key="order.id" class="border-b hover:bg-pink-50">
                <td class="py-2 px-3">{{ order.name }}</td>
                <td class="py-2 px-3">{{ order.service }}</td>
                <td class="py-2 px-3">
                  <span :class="{
                    'text-green-600 font-semibold': order.status === 'Selesai',
                    'text-yellow-600 font-semibold': order.status === 'Proses'
                  }">
                    {{ order.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Recent Users -->
        <div class="bg-white shadow-md rounded-xl p-4">
          <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Recent Users</h3>
            <button class="text-pink-500 hover:underline">View All</button>
          </div>
          <table class="w-full text-left text-gray-700">
            <thead class="bg-pink-100">
              <tr>
                <th class="py-2 px-3">Name</th>
                <th class="py-2 px-3">Email</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in recentUsers" :key="user.id" class="border-b hover:bg-pink-50">
                <td class="py-2 px-3">{{ user.name }}</td>
                <td class="py-2 px-3">{{ user.email }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue'
import { ref, onMounted } from 'vue'
import ApexCharts from 'vue3-apexcharts'

// 🔹 Registrasi komponen ApexCharts agar bisa digunakan
const apexchart = ApexCharts

// 🔹 Sidebar Menu
const menus = ref([
  { text: 'Dashboard', icon: 'dashboard', link: '/admin/dashboard' },
  { text: 'Products', icon: 'inventory_2', link: '/admin/products' },
  { text: 'Users', icon: 'group', link: '/admin/users' },
  { text: 'Orders', icon: 'shopping_cart', link: '/admin/orders' },
  { text: 'Payment Verification', icon: 'payments', link: '/admin/payments' }
])

// Live stats and lists
const stats = ref({ totalProducts: 0, totalUsers: 0, totalOrders: 0, pendingVerification: 0 })
const recentOrders = ref([])
const recentUsers = ref([])

// Chart config (keep static or wire later)
const chartSeries = ref([])
const chartOptions = ref({
  chart: { type: 'bar', toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 800 } },
  colors: ['#ec4899'],
  plotOptions: { bar: { borderRadius: 6, columnWidth: '45%', distributed: false } },
  dataLabels: { enabled: false },
  xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'], labels: { style: { colors: '#6b7280' } } },
  yaxis: { labels: { style: { colors: '#6b7280' }, formatter: val => `Rp ${val.toLocaleString()}` } },
  tooltip: { y: { formatter: val => `Rp ${val.toLocaleString()}` } },
  grid: { borderColor: '#f3f4f6' },
  title: { text: 'Grafik Pemasukan Bulanan', align: 'center', style: { fontSize: '16px', color: '#1f2937', fontWeight: 'bold' } }
})

async function loadDashboardData() {
  const res = await fetch('/admin/dashboard-data')
  const data = await res.json()
  stats.value = data.stats
  recentOrders.value = data.recentOrders
  recentUsers.value = data.recentUsers
  // chartSeries.value = data.chartSeries || []
}

onMounted(loadDashboardData)
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.material-icons {
  font-size: 20px;
}
</style>