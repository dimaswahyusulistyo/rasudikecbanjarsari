<template>
  <div>
    <AppHeaderLP />
    <div class="content">
      <slot>
        <router-view />
      </slot>
    </div>
    <AppFooter />
  </div>
</template>

<script>
import AppFooter from '@/components/AppFooter.vue'
import AppHeaderLP from '../components/AppHeaderLP.vue';

export default {
  name: 'LandingLayout',
  components: {
    AppHeaderLP,
    AppFooter,
  },
}
</script>
