<template>
  
  <Header />

  <Banner />

  <div class="container mt-5">
    <h1 class="mb-4">編輯任務</h1>
    <form @submit.prevent="submit" class="needs-validation">

      <div class="mb-3">
        <label for="title" class="form-label">任務標題</label>
        <input 
          id="title" 
          v-model="form.title" 
          type="text" 
          class="form-control"
          required 
        />
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">任務內容</label>
        <textarea 
          id="content" 
          v-model="form.content" 
          class="form-control"
          rows="3" 
          required>
        </textarea>
      </div>

      <div class="form-check mb-3">
        <input 
          id="status" 
          type="checkbox" 
          v-model="form.status" 
          class="form-check-input" 
        />
        <label for="status" class="form-check-label">完成</label>
      </div>

      <div class="card-footer d-flex justify-content-between">
      <button type="submit" class="btn btn-dark">更新</button>
        <Link 
          :href="route('projects.show', { project: project.id })" 
          class="btn btn-secondary ms-2">
          回到首頁
        </Link>
      </div>
      
    </form>
  </div>

  <Footer />

</template>

<script>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export default {
  components: {
    Link,
  },
  props: {
    project: Object,
    task: Object,
  },
  data() {
    return {
      form: useForm({
        title:    this.task.title,
        content:  this.task.content,
        status:   Boolean(this.task.status),
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(route('projects.tasks.update', {
        project: this.project.id,
        task: this.task.id,
      }));
    },
  },
};
</script>
