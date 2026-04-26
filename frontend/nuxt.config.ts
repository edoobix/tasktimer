// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    compatibilityDate: '2025-07-15',
    devtools: { enabled: true },

    future: {
      compatibilityVersion: 4,
    },

    modules: ['@pinia/nuxt'],

    vite: {
        server: {
            watch: {
                usePolling: true, // Заставляет Vite постоянно проверять файлы на изменения
            },
        },
    },
})