<template>
  <div>

    <Header />

    <Banner />

    <div class="container mt-5">

      <div class="card mb-4">
        <div class="card-body">
          <h1 class="mb-3">{{ project.title }}</h1>
          <h2><strong>標籤:</strong> {{ project.label }}</h2>
          <h2><strong>專案內容:</strong> {{ project.content }}</h2>
          <h2><strong>進度:</strong> {{ projectProgress }}%</h2>
          <h2><strong>重要性:</strong> {{ project.importance }}</h2>
          <span 
            :class="{
              'badge bg-success': project.status,
              'badge bg-warning text-dark': !project.status
            }"
          >
            {{ project.status ? '已完成' : '未完成' }}
          </span>
          <div class="mt-3">
            <label for="progress" class="form-label"><strong>更新進度:</strong></label>
            <input 
              type="range" 
              id="progress" 
              v-model="projectProgress" 
              min="0" 
              max="100" 
              class="form-range"
            />
          </div>
          <div class="d-flex justify-content-between">
            <button @click="updateProject" class="btn btn-dark mt-3">更新專案</button>
            <Link :href="route('projects.edit', { project: project.id })" class="btn btn-dark mt-3 me-2">編輯</Link>
          </div>
        </div>
      </div>

      <Link 
        :href="route('projects.tasks.create', { project: project.id})" 
        class="btn btn-dark me-2">
        創建任務
      </Link>

      <div class="mt-4">
        <h2>任務列表</h2>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4" v-for="task in tasks.data" :key="task.id">
            <div class="card h-100 shadow-sm">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title m-0">{{ task.title }}</h5>
                  <span 
                    :class="{
                      'badge bg-success': task.status,
                      'badge bg-warning text-dark': !task.status
                    }"
                  >
                    {{ task.status ? '已完成' : '未完成' }}
                  </span>
                </div>
                <p class="card-text">{{ task.content }}</p>
                <div class="mt-auto">
                  <div class="form-check mb-3">
                    <input 
                      type="checkbox" 
                      :checked="task.status" 
                      @change="complete(task)" 
                      class="form-check-input me-2"
                      id="task-{{ task.id }}"
                    />
                    <label class="form-check-label" :for="'task-' + task.id">完成</label>
                  </div>
                  <div class="d-flex">
                    <Link 
                      :href="route('projects.tasks.edit', { project: project.id, task: task.id })" 
                      class="btn btn-sm btn-primary me-2">
                      編輯任務
                    </Link>
                    <button 
                      @click="deleteTask(task.id)" 
                      class="btn btn-sm btn-danger">
                      刪除任務
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <div class="d-flex justify-content-center">
          <button 
            v-for="link in tasks.links" 
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

    <Footer />

  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  components: {
    Link,
  },
  props: {
    project: Object,
    tasks: Object,
  },
  data() {
    return {
      projectProgress: this.project.progress,
    };
  },
  methods: {

    updateProject() {
      this.$inertia.put(route('projects.complete', { project: this.project.id }), {
        progress: this.projectProgress,
        status: this.project.status
      });
    },

    complete(task) {
      const newStatus = !task.status;
      this.$inertia.put(route('projects.tasks.complete', {
        project: this.project.id,
        task: task.id
      }), {
        status: newStatus
      }, {
        onSuccess: () => {
          task.status = newStatus;
        }
      });
    },

    deleteTask(taskId) {
      this.$inertia.delete(route('projects.tasks.destroy', { 
        project: this.project.id,
        task: taskId
      }));
    },

    getPage(url) {
      if (url) {
        this.$inertia.get(url);
      }
    }
  }
}
</script>