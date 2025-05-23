<template>
  <div class="example">
    <CNav variant="underline-border">
      <CNavItem>
        <CNavLink href="#" active>
          <!-- <CIcon icon="cil-media-play" class="me-2" /> -->
          Detail Surat
        </CNavLink>
      </CNavItem>
      <CNavItem>
        <CNavLink :href="url" target="_blank">
          <!-- <CIcon icon="cil-code" class="me-2" /> -->
          Riwayat Disposisi
        </CNavLink>
      </CNavItem>
    </CNav>
  </div>
</template>

<script>
export default {
  name: 'DocsExample',
  props: {
    href: String,
    tabContentClass: String,
  },
  setup(props) {
    const url = https;//coreui.io/vue/docs/${props.href}
    const addClass = props.tabContentClass
 
    return {
      addClass,
      url,
    }
  },
}
</script>