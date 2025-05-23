<template>
  <div>
    <AppSidebarSA />
    <div class="wrapper d-flex flex-column min-vh-100">
      <AppHeader />
      <div class="body flex-grow-1">
        <CContainer class="px-4" lg>
          <!-- <SuperAdmin /> -->
          <router-view />
        </CContainer>
      </div>
      <AppFooter />
    </div>
  </div>
</template>
<script>
import { CContainer } from '@coreui/vue'
import AppFooter from '@/components/AppFooter.vue'
import AppHeader from '@/components/AppHeader.vue'
import AppSidebarSA from '@/components/AppSidebarSA.vue'

export default {
  name: 'SuperAdmin',
  components: {
    AppFooter,
    AppHeader,
    AppSidebarSA,
    CContainer,
  },
}
</script>
