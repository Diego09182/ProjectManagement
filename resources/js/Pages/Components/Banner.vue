<template>
  <div class="container-fluid bg-dark text-white py-5">
    <div class="container text-center">
      <h1 class="display-4 fw-bold">
        <Link :href="route('projects.index')" class="text-white text-decoration-none">
          ProjectManagemnt
        </Link>
      </h1>
      <br>
      <h3 class="fw-bold">專案管理工具</h3>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
};
</script>

  