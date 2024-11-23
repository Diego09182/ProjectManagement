<template>

  <Header />

  <Banner />

  <div class="container mt-5">
    <h1 class="mb-4">創建任務</h1>
    <form @submit.prevent="submit" class="needs-validation">

      <div class="mb-3">
        <label for="title" class="form-label">任務標題</label>
        <input 
          id="title" 
          v-model="form.title" 
          type="text" 
          class="form-control" 
        />
        <div v-if="form.errors.title" class="text-danger mt-2">
          {{ form.errors.title }}
        </div>
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">任務內容</label>
        <textarea 
          id="content" 
          v-model="form.content" 
          class="form-control" 
          rows="3" 
        ></textarea>
        <div v-if="form.errors.content" class="text-danger mt-2">
          {{ form.errors.content }}
        </div>
      </div>

      <div class="form-check mb-3">
        <input 
          id="status" 
          type="checkbox" 
          v-model="form.status" 
          class="form-check-input" 
        />
        <label for="status" class="form-check-label">完成</label>
        <div v-if="form.errors.status" class="text-danger mt-2">
          {{ form.errors.status }}
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between">
        <button type="submit" class="btn btn-dark">創建任務</button>
        <Link 
          :href="route('projects.show', { project: project.id })" 
          class="btn btn-secondary">
          回到首頁
        </Link>
      </div>
      
    </form>
  </div>

  <Footer />

</template>

<script>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  components: {
    Link,
  },
  props: {
    project: Object,
  },
  setup(props) {
    const form = useForm({
      title: '',
      content: '',
      status: false,
    })

    function submit() {
      form.post(route('projects.tasks.store', { project: props.project.id }))
    }

    return { form, submit }
  },
}
</script>
