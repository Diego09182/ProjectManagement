<template>
  
  <Header />

  <Banner />

  <div class="container mt-4">
    <div class="d-flex justify-content-end">
      <Link :href="route('projects.create')" class="btn btn-dark">新增專案</Link>
    </div>
    <br>
    <div class="row">
      <div class="col-md-4 mb-4" v-for="project in projects.data" :key="project.id">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="card-title m-0">{{ project.title }}</h4>
              <h4>
                <span 
                  :class="{
                    'badge bg-success': project.status,
                    'badge bg-warning text-dark': !project.status
                  }"
                >
                  {{ project.status ? '已完成' : '未完成' }}
                </span>
              </h4>
            </div>
            <hr>
            <h4 class="card-text">
              <span class="badge bg-dark">{{ project.label }}</span>  
              <br><br>
              <strong>重要性:</strong> {{ project.importance }}
              <br>
              <strong>進度:</strong> {{ project.progress }}%
              <br>
              <strong>開始時間:</strong> {{ project.start_time }}
              <br>
              <strong>結束時間:</strong> {{ project.finish_time }}
            </h4>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <div>
              <Link :href="route('projects.show', { project: project.id })" class="btn btn-dark btn me-2">檢視</Link>
              <Link :href="route('projects.edit', { project: project.id })" class="btn btn-dark btn me-2">編輯</Link>
            </div>
            <button @click="deleteProject(project.id)" class="btn btn-danger btn-sm">刪除</button>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4">
      <div class="flex justify-center">
        <button 
          v-for="link in projects.links" 
          :key="link.label" 
          :disabled="!link.url"
          @click="getPage(link.url)"
          class="mx-1 px-3 py-1 border rounded hover:bg-blue-500 hover:text-white"
          :class="{ 'bg-blue-500 text-white': link.active, 'bg-gray-200': !link.url }"
        >
          <span v-if="link.label.includes('Previous')">««</span>
          <span v-else-if="link.label.includes('Next')">»»</span>
          <span v-else>{{ link.label }}</span>
        </button>
      </div>
    </div>
  </div>

  <br><br><br><br>

  <Footer />
  
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  components: {
    Link,
  },
  props: {
    projects: Object,
  },
  setup() {
    const form = useForm({})

    function deleteProject(id) {
      form.delete(route('projects.destroy', { project: id }))
    }

    function getPage(url) {
      if (url) {
        window.location.href = url
      }
    }

    return { form, deleteProject, route, getPage }
  },
}
</script>
