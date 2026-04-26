export default defineNuxtPlugin(() => {
    const auth = useAuthStore()
    const config = useRuntimeConfig()

    const api = $fetch.create({
        baseURL: 'http://localhost/api/v1',

        onRequest({ options }) {
            if (auth.token) {
                options.headers = {
                    ...options.headers,
                    Authorization: `Bearer ${auth.token}`
                }
            }
        },

        async onResponseError({ response, options }) {
            // Если ошибка 401 и у нас есть рефреш-токен
            if (response.status === 401 && auth.refreshToken) {
                try {
                    // Важно: используем обычный $fetch, а не созданный api, чтобы не зациклиться
                    const data = await $fetch('http://localhost/api/token/refresh', {
                        method: 'POST',
                        body: { refresh_token: auth.refreshToken }
                    })

                    // Обновляем токены в сторе
                    auth.setTokens(data.token, data.refresh_token)

                    // Повторяем запрос, который упал
                    // Мы перезаписываем заголовок авторизации новым токеном
                    options.headers = {
                        ...options.headers,
                        Authorization: `Bearer ${data.token}`
                    }

                    return await $fetch(response.url, options)
                } catch (refreshError) {
                    // Если даже рефреш-токен протух или невалиден
                    auth.logout()
                    throw refreshError
                }
            }
        }
    })

    return { provide: { api } }
})