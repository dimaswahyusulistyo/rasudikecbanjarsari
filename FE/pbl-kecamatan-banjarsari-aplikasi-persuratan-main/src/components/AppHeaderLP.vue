<template>
  <CHeader :class="headerClassNames" position="sticky">
    <CContainer class="border-bottom px-4" fluid style="background-color: #003083;">
      <div style="display: flex; align-items: center;">
        <img src="@/assets/images/logo-header.png" alt="Logo" style="height: 40px;" />
      </div>
      
      <CHeaderNav>
        <!-- Dropdown for color mode -->
        <CDropdown variant="nav-item" placement="bottom-end">
          <!-- Dropdown toggle -->
          <CDropdownToggle :caret="false">
            <CIcon v-if="colorMode === 'dark'" icon="cil-moon" size="lg" />
            <CIcon v-else-if="colorMode === 'light'" icon="cil-sun" size="lg" style="color: white;"/>
            <CIcon v-else icon="cil-contrast" size="lg" />
          </CDropdownToggle>
          <!-- Dropdown menu -->
          <CDropdownMenu>
            <CDropdownItem
              :active="colorMode === 'light'"
              class="d-flex align-items-center"
              component="button"
              type="button"
              @click="setColorMode('light')"
            >
              <CIcon class="me-2" icon="cil-sun" size="lg" :style="{ color: colorMode === 'light' ? 'white' : 'auto' }" /> Light
            </CDropdownItem>
            <CDropdownItem
              :active="colorMode === 'dark'"
              class="d-flex align-items-center"
              component="button"
              type="button"
              @click="setColorMode('dark')"
            >
              <CIcon class="me-2" icon="cil-moon" size="lg" :style="{ color: colorMode === 'dark' ? 'white' : 'auto' }" /> Dark
            </CDropdownItem>
            <CDropdownItem
              :active="colorMode === 'auto'"
              class="d-flex align-items-center"
              component="button"
              type="button"
              @click="setColorMode('auto')"
            >
              <CIcon class="me-2" icon="cil-contrast" size="lg" :style="{ color: colorMode === 'auto' ? 'white' : 'auto' }" /> Auto
            </CDropdownItem>
          </CDropdownMenu>
        </CDropdown>

        <div class="px-2" style="align-self: center; cursor: pointer;" @click="toggleFullScreen">
          <CIcon icon="cil-fullscreen" size="lg" :style="{ color: colorMode === 'light' || colorMode === 'auto' ? 'white' : 'black' }" />
        </div>

        <li class="nav-item py-1">
          <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
        </li>

        <CButton color="primary" class="px-4" @click="$router.push('login')">
          Login
        </CButton>
      </CHeaderNav>
    </CContainer>
  </CHeader>
</template>

<script>
import { onMounted, ref } from 'vue'
import { CContainer, useColorModes } from '@coreui/vue'
import AppHeaderDropdownAccnt from './AppHeaderDropdownAccnt'

export default {
  name: 'AppHeader',
  components: {
    AppHeaderDropdownAccnt,
  },
  setup() {
    const headerClassNames = ref('mb-0 p-0')
    const { colorMode, setColorMode } = useColorModes('coreui-free-vue-admin-template-theme')

    // Method to toggle full screen
    const toggleFullScreen = () => {
      if (document.fullscreenElement) {
        document.exitFullscreen();
      } else {
        document.documentElement.requestFullscreen();
      }
    };

    onMounted(() => {
      document.addEventListener('scroll', () => {
        if (document.documentElement.scrollTop > 0) {
          headerClassNames.value = 'mb-0 p-0 shadow-sm'
        } else {
          headerClassNames.value = 'mb-0 p-0'
        }
      })
    })

    return {
      headerClassNames,
      colorMode,
      setColorMode,
      toggleFullScreen, // Expose the method to the template
    }
  },
}
</script>
