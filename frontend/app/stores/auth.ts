import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', () => {
    const token = useCookie('auth_token')
    const refreshToken = useCookie('refresh_token') // Добавляем куку для рефреш-токена
    const user = ref(null)

    const isLoggedIn = computed(() => !!token.value)

    function setTokens(newToken: string, newRefreshToken: string) {
        token.value = newToken
        refreshToken.value = newRefreshToken
    }

    function logout() {
        token.value = null
        refreshToken.value = null
        user.value = null
        navigateTo('/login')
    }

    return { token, refreshToken, user, isLoggedIn, setTokens, logout }
})