<template>
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <Link :href="route('projects.index')" class="text-white text-decoration-none">
                        ProjectManagemnt
                    </Link>
                </a>
            </div>
        </div>
  </header>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
};
</script>