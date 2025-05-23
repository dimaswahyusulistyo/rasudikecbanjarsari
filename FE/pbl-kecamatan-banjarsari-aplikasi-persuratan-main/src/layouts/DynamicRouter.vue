<template>
  <component :is="layoutComponent" />
</template>

<script>
import { ref, onMounted } from 'vue';
import { getLayoutComponent } from '@/router/layoutHelper';

export default {
  name: 'DynamicRouter',
  setup() {
    const layoutComponent = ref(null);

    onMounted(async () => {
      const userRole = localStorage.getItem('role');
      layoutComponent.value = await getLayoutComponent(userRole);
    });

    return { layoutComponent };
  },
};
</script>
