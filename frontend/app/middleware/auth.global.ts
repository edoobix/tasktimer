export default defineNuxtRouteMiddleware((to, from) => {
    const auth = useAuthStore()

    // Список публичных страниц
    const publicPages = ['/login', '/register']
    const isPublic = publicPages.includes(to.path)

    if (!auth.isLoggedIn && !isPublic) {
        return navigateTo('/login')
    }

    if (auth.isLoggedIn && isPublic) {
        return navigateTo('/')
    }
})