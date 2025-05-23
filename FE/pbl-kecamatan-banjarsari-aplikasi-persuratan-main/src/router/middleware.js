// middleware.js
export function roleGuard(allowedRoles) {
  return function (to, from, next) {
    // Ambil token dan role dari local storage
    const token = localStorage.getItem('token');
    const role = localStorage.getItem('role');

    // Jika token tidak ada, arahkan pengguna ke halaman login
    if (!token) {
      next('/login');
    } else {
      // Jika role tidak ada atau tidak diizinkan, arahkan pengguna ke halaman yang sesuai
      if (!role || !allowedRoles.includes(role)) {
        next('/login');
      } else {
        // Jika role diizinkan dan token ada, lanjutkan navigasi ke halaman yang diminta
        next();
      }
    }
  };
}
