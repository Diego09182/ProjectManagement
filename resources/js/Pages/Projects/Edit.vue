<template>

  <Header />

  <Banner />

  <div class="container mt-5">
    <h1 class="mb-4">編輯專案</h1>

    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="title" class="form-label">標題</label>
        <input 
          id="title" 
          v-model="form.title" 
          type="text" 
          class="form-control" 
        />
        <div v-if="form.errors.title" class="text-danger">{{ form.errors.title }}</div>
      </div>
      
      <div class="mb-3">
        <label for="label" class="form-label">標籤</label>
        <input 
          id="label" 
          v-model="form.label" 
          type="text" 
          class="form-control" 
        />
        <div v-if="form.errors.label" class="text-danger">{{ form.errors.label }}</div>
      </div>

      <div class="mb-3">
        <label for="importance" class="form-label">重要性</label>
        <input 
          id="importance" 
          v-model="form.importance" 
          type="number" 
          class="form-control" 
        />
        <div v-if="form.errors.importance" class="text-danger">{{ form.errors.importance }}</div>
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">內容</label>
        <textarea 
          id="content" 
          v-model="form.content" 
          class="form-control" 
          rows="4" 
        ></textarea>
        <div v-if="form.errors.content" class="text-danger">{{ form.errors.content }}</div>
      </div>

      <div class="mt-3">
        <label for="progress" class="form-label"><strong>更新進度:</strong></label>
        <h2><strong>進度:</strong> {{ form.progress }}%</h2>
        <input 
          type="range" 
          id="progress" 
          v-model="form.progress" 
          min="0" 
          max="100" 
          class="form-range"
        />
      </div>

      <div class="mb-3">
        <label for="start_time" class="form-label">開始時間</label>
        <input 
          id="start_time" 
          v-model="form.start_time" 
          type="datetime-local" 
          class="form-control" 
        />
        <div v-if="form.errors.start_time" class="text-danger">{{ form.errors.start_time }}</div>
      </div>

      <div class="mb-3">
        <label for="finish_time" class="form-label">結束時間</label>
        <input 
          id="finish_time" 
          v-model="form.finish_time" 
          type="datetime-local" 
          class="form-control" 
        />
        <div v-if="form.errors.finish_time" class="text-danger">{{ form.errors.finish_time }}</div>
      </div>

      <button type="submit" class="btn btn-dark">更新專案</button>
    </form>
  </div>

  <Footer />
  
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  props: {
    project: Object, 
  },
  setup(props) {

    const form = useForm({
      title: props.project.title,
      label: props.project.label,
      importance: props.project.importance,
      content: props.project.content,
      progress: props.project.progress,
      start_time: props.project.start_time,
      finish_time: props.project.finish_time,
    })

    function submit() {
      form.put(route('projects.update', { project: props.project.id }))
    }

    return { form, submit }
  },
}
</script>

