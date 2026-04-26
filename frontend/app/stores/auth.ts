import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', () => {
    const token = useCookie('auth_token') // Используем куки для SSR стабильности
    const user = ref(null)

    const isLoggedIn = computed(() => !!token.value)

    function setToken(newToken: string) {
        token.value = newToken
    }

    function logout() {
        token.value = null
        user.value = null
        navigateTo('/login')
    }

    return { token, user, isLoggedIn, setToken, logout }
})