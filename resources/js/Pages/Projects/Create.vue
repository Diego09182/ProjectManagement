<template>
  <div>
    <Header />

    <Banner />

    <div class="container mt-5">
      <h1 class="mb-4">創建專案</h1>
      <form @submit.prevent="submit">
        
        <div class="mb-3">
          <label for="title" class="form-label">標題</label>
          <input id="title" v-model="form.title" type="text" class="form-control" />
          <div v-if="form.errors.title" class="text-danger">
            {{ form.errors.title }}
          </div>
        </div>

        <div class="mb-3">
          <label for="label" class="form-label">標籤</label>
          <input id="label" v-model="form.label" type="text" class="form-control" />
          <div v-if="form.errors.label" class="text-danger">
            {{ form.errors.label }}
          </div>
        </div>

        <div class="mb-3">
          <label for="importance" class="form-label">重要性</label>
          <input id="importance" v-model="form.importance" type="number" class="form-control" />
          <div v-if="form.errors.importance" class="text-danger">
            {{ form.errors.importance }}
          </div>
        </div>

        <div class="mb-3">
          <label for="content" class="form-label">內容</label>
          <textarea id="content" v-model="form.content" class="form-control" rows="4"></textarea>
          <div v-if="form.errors.content" class="text-danger">
            {{ form.errors.content }}
          </div>
        </div>

        <div class="mb-3 form-check">
          <input id="status" type="checkbox" v-model="form.status" class="form-check-input" />
          <label for="status" class="form-check-label">狀態</label>
          <div v-if="form.errors.status" class="text-danger">
            {{ form.errors.status }}
          </div>
        </div>

        <div class="mb-3">
          <label for="progress" class="form-label">進度</label>
          <input id="progress" v-model="form.progress" type="number" class="form-control" />
          <div v-if="form.errors.progress" class="text-danger">
            {{ form.errors.progress }}
          </div>
        </div>

        <div class="mb-3">
          <label for="start_time" class="form-label">開始時間</label>
          <input id="start_time" v-model="form.start_time" type="datetime-local" class="form-control" />
          <div v-if="form.errors.start_time" class="text-danger">
            {{ form.errors.start_time }}
          </div>
        </div>

        <div class="mb-3">
          <label for="finish_time" class="form-label">結束時間</label>
          <input id="finish_time" v-model="form.finish_time" type="datetime-local" class="form-control" />
          <div v-if="form.errors.finish_time" class="text-danger">
            {{ form.errors.finish_time }}
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-dark">發布專案</button>
        </div>
        
      </form>
    </div>

    <Footer />
  </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export default {
  setup() {
    const form = useForm({
      title: '',
      label: '',
      importance: 1,
      content: '',
      status: false,
      progress: 0,
      start_time: '',
      finish_time: '',
    })

    function submit() {
      form.post(route('projects.store'), {
        onError: () => {
          console.error('表單驗證錯誤', form.errors)
        },
      })
    }

    return { form, submit }
  },
}
</script>

<style>
.text-danger {
  color: red;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}
</style>
