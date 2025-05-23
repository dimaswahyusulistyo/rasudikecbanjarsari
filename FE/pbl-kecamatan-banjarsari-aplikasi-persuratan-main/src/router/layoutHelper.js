export async function getLayoutComponent(userRole) {
  switch (userRole) {
    case 'admin':
      return (await import('@/layouts/DefaultLayout.vue')).default;
    case 'superadmin':
      return (await import('@/layouts/SuperAdmin.vue')).default;
    case 'camat':
      return (await import('@/layouts/CamatLayout.vue')).default;
    default:
      return (await import('@/layouts/LandingLayout.vue')).default;
  }
}
