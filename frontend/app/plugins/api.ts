export default defineNuxtPlugin(() => {
    const auth = useAuthStore()

    const api = $fetch.create({
        baseURL: 'http://localhost/api/v1',
        onRequest({ options }) {
            if (auth.token) {
                options.headers = {
                    ...options.headers,
                    Authorization: `Bearer ${auth.token}`
                }
            }
        }
    })

    return { provide: { api } }
})