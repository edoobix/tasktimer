<template>
  <div>
    <h1>Login</h1>
    <form @submit.prevent="handleLogin">
      <input v-model="login" type="text" placeholder="Login" />
      <input v-model="password" type="password" placeholder="Password" />
      <button type="submit">Enter</button>
    </form>
  </div>
</template>

<script setup>
const login = ref('')
const password = ref('')
const auth = useAuthStore()

async function handleLogin() {
  try {
    const data = await $fetch('http://localhost/api/login_check', {
      method: 'POST',
      body: { login: login.value, password: password.value }
    })

    auth.setToken(data.token)
    await navigateTo('/')
  } catch (e) {
    alert('Invalid credentials')
  }
}
</script>