export default [
  {
    component: 'CNavItem',
    name: 'Beranda',
    to: '/dashboard',
    icon: 'cilHome',
    badge: {
      color: 'primary',
      // text: 'NEW',
    },
  },
  {
    component: 'CNavTitle',
    name: 'Aktivitas',
  },
  
  {
    component: 'CNavItem',
    name: 'Disposisi Saya',
    to: '/disposisi',
    icon: 'cilPeople',
  },
]
