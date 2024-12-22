<template>
  <div>

    <Header />

    <Banner />

    <div class="container mt-5">
      
      <h1 class="mb-4">上傳檔案至專案：{{ project.name }}</h1>
      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="path" class="form-label">檔案</label>
          <input 
            id="path" 
            type="file" 
            class="form-control" 
            multiple 
            @change="handleFileUpload"
          />
          <div v-if="form.errors.files" class="text-danger">
            {{ form.errors.files }}
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-dark">上傳檔案</button>
        </div>
      </form>

    </div>

    <Footer />

  </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

export default {
  props: {
    project: Object,
  },
  data() {
    return {
      form: useForm({
        files: null,
        project_id: this.project.id,
      }),
    };
  },
  methods: {
    handleFileUpload(event) {
      this.form.files = event.target.files;
    },
    submit() {
      const formData = new FormData();

      if (this.form.files) {
        for (let i = 0; i < this.form.files.length; i++) {
          formData.append('files[]', this.form.files[i]);
        }
      }

      formData.append('project_id', this.form.project_id);

      this.form.post(route('files.store', { project: this.form.project_id }), {
        data: formData,
        onFinish: () => this.form.reset(),
        preserveScroll: true,
      });
    },
  },
};
</script>

<style scoped>
  .text-danger {
    color: red;
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }
</style>
