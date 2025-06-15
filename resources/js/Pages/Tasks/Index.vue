<template>
  <div class="p-6 max-w-3xl mx-auto">
    <Tabs />
    <h1 class="text-3xl font-bold mb-6">Lista mea de sarcini</h1>

    <!-- FORMULAR CREARE TASK -->
    <form @submit.prevent="addTask" class="space-y-4 mb-8">
      <input
        v-model="newTask"
        type="text"
        placeholder="Titlu sarcină*"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
      />

      <textarea
        v-model="newDescription"
        placeholder="Descriere (opțional)"
        rows="2"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
      ></textarea>

      <div class="flex items-center gap-3">
        <label class="text-sm text-gray-600">Deadline:</label>
        <input
          v-model="newDeadline"
          type="date"
          class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
        />
        <button
          type="submit"
          class="ml-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded"
        >Adaugă</button>
      </div>
    </form>

    <!-- FILTRE & CONTOR -->
    <div class="flex justify-between items-center mb-4">
      <div class="flex gap-3">
        <button @click="filter = 'all'" :class="buttonClass('all')">Toate</button>
        <button @click="filter = 'active'" :class="buttonClass('active')">Active</button>
        <button @click="filter = 'completed'" :class="buttonClass('completed')">Finalizate</button>
      </div>
      <p class="text-sm text-gray-500">
        {{ remaining }} sarcin{{ remaining === 1 ? 'ă' : 'i' }} nefinalizat{{ remaining === 1 ? 'ă' : 'e' }}
      </p>
    </div>

    <!-- LISTA TASKURI -->
    <ul class="space-y-4">
      <li
        v-for="task in filteredTasks"
        :key="task.id"
        class="bg-white shadow p-4 rounded border hover:bg-gray-50 transition group"
      >
        <div class="flex items-start justify-between">
          <div class="flex items-start gap-3 w-full">
            <input
              type="checkbox"
              v-model="task.completed"
              @change="toggleTask(task)"
              class="w-5 h-5 mt-1 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            />
            <div class="flex-1">
              <!-- TITLU -->
              <span
                :class="{ 'line-through text-gray-500': task.completed }"
                @dblclick="editTask(task)"
                class="block font-medium cursor-pointer"
              >
                {{ editingTask?.id === task.id ? '' : task.title }}
              </span>
              <input
                v-if="editingTask?.id === task.id"
                v-model="editingTask.title"
                @keyup.enter="saveTask"
                @blur="saveTask"
                class="border border-gray-300 px-2 py-1 rounded w-full mt-1"
                autofocus
              />

              <!-- DESCRIERE -->
              <p v-if="task.description" class="text-sm text-gray-500 mt-1">📝 {{ task.description }}</p>
              <!-- DEADLINE -->
              <p
                v-if="task.deadline"
                class="text-sm mt-1"
                :class="{ 'text-red-600 font-semibold': isPastDeadline(task.deadline) }"
              >
                📅 Termen: {{ formatDate(task.deadline) }}
              </p>
            </div>
          </div>
          <button
            @click="deleteTask(task)"
            class="text-red-600 hover:text-red-800 text-lg font-semibold"
            title="Șterge sarcina"
          >✕</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import Tabs from '@/Components/Tabs.vue'
import { router } from '@inertiajs/vue3'

// === PROPS & REFS ===
const props = defineProps({ tasks: Array })
const tasks = computed(() => props.tasks)

const newTask        = ref('')
const newDescription = ref('')
const newDeadline    = ref('')

const filter = ref('all')
const editingTask = ref(null)

// === CRUD ===
function addTask () {
  if (!newTask.value.trim()) return

  router.post('/todo', {
    title:       newTask.value,
    description: newDescription.value || null,
    deadline:    newDeadline.value   || null
  }, {
    onSuccess: () => {
      newTask.value = ''
      newDescription.value = ''
      newDeadline.value = ''
    }
  })
}

function toggleTask (task) {
  router.put(`/todo/${task.id}`, {
    completed: task.completed
  })
}

function deleteTask (task) {
  if (confirm('Sigur vrei să ștergi această sarcină?')) {
    router.delete(`/todo/${task.id}`)
  }
}

function editTask (task) {
  editingTask.value = { ...task }
}

function saveTask () {
  if (!editingTask.value?.title.trim()) return
  router.put(`/todo/${editingTask.value.id}`, {
    title: editingTask.value.title
  }, {
    onSuccess: () => editingTask.value = null
  })
}

// === HELPERS ===
function isPastDeadline (deadline) {
  return new Date(deadline) < new Date()
}

function formatDate (dateStr) {
  return new Date(dateStr).toLocaleDateString('ro-RO', {
    year: 'numeric', month: 'long', day: 'numeric'
  })
}

// === FILTRARE ===
const filteredTasks = computed(() => {
  if (filter.value === 'active') return tasks.value.filter(t => !t.completed)
  if (filter.value === 'completed') return tasks.value.filter(t => t.completed)
  return tasks.value
})

const remaining = computed(() => tasks.value.filter(t => !t.completed).length)

function buttonClass (type) {
  return `text-sm px-3 py-1 rounded border ${filter.value === type ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`
}
</script>

<style scoped>
input[type="checkbox"]:checked { accent-color: #2563eb; }
</style>
