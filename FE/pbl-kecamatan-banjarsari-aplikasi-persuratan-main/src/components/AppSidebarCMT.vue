<template>
  <CSidebar class="border-end" colorScheme="auto" position="fixed" :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible" @visible-change="(event) =>
    $store.commit({
      type: 'updateSidebarVisible',
      value: event,
    })
    ">
    <CSidebarHeader class="border-bottom" style="background-color: #003083;">
      <RouterLink custom to="/" v-slot="{ href, navigate }">
        <CSidebarBrand v-bind="$attrs" as="a" :href="href" @click="navigate" style="background-color: #003083;">
          <div style="display: flex; align-items: center; justify-content: center;">
            <img :src="logoSrc" alt="Logo" class="logo" />
          </div>
        </CSidebarBrand>
      </RouterLink>
      <CCloseButton class="d-lg-none" dark @click="$store.commit('toggleSidebar')" />
    </CSidebarHeader>
    <AppSidebarNavCMT />
    <CSidebarFooter class="border-top d-none d-lg-flex" style="background-color: #003083;">
      <CSidebarToggler @click="$store.commit('toggleUnfoldable')" />
    </CSidebarFooter>
  </CSidebar>
</template>

<script>
import { computed } from 'vue'
import { RouterLink } from 'vue-router'
import { useStore } from 'vuex'
import { AppSidebarNavCMT } from './AppSidebarNavCMT'
import { logo } from '@/assets/brand/logo'
import { sygnet } from '@/assets/brand/sygnet'
import logoHeader from '@/assets/images/logo-header.png'
import logoJateng from '@/assets/images/logo-jateng.png'
export default {
  name: 'AppSidebarCMT',
  components: {
    AppSidebarNavCMT,
    RouterLink,
  },
  setup() {
    const store = useStore()
    const logoSrc = computed(() => store.state.sidebarUnfoldable ? logoJateng : logoHeader)
    return {
      logoSrc,
      logo,
      sygnet,
      sidebarUnfoldable: computed(() => store.state.sidebarUnfoldable),
      sidebarVisible: computed(() => store.state.sidebarVisible),
    }
  },
}
</script>

<style>
    .logo {
        width: auto;
        height: 40px; 
        max-width: 100%;
    }
</style>