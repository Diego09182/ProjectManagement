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

      <div class="mt-4">
        <h2>檔案列表</h2>
        <div class="list-group">
          <div class="list-group-item" v-for="file in project.files" :key="file.id">
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ file.name }}</span>
              <div>
                <a :href="route('files.download', { file: file.id })" class="btn btn-sm btn-info me-2">下載</a>
                <button 
                  @click="deleteFile(file.id)" 
                  class="btn btn-sm btn-danger">
                  刪除
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <Footer />

  </div>
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
      files: null,
      project_id: props.project.id,
    })

    function handleFileUpload(event) {
      form.files = event.target.files;
    }

    function submit() {
      const formData = new FormData();

      if (form.files) {
        for (let i = 0; i < form.files.length; i++) {
          formData.append('files[]', form.files[i]);
        }
      }

      formData.append('project_id', form.project_id);

      form.post(route('files.store', { project: form.project_id }), {
        data: formData,
        onFinish: () => form.reset(),
        preserveScroll: true,
      });
    }

    return { form, submit, handleFileUpload }
  },
}
</script>

<style scoped>
  .text-danger {
    color: red;
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }
</style>
