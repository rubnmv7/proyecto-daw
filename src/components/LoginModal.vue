<script setup>
import { ref } from 'vue'

const emit = defineEmits(['close'])

const mode = ref('login')
const email = ref('')
const password = ref('')
const username = ref('')
const errorMsg = ref('')

async function handleLogin() {
	errorMsg.value = ''

	const form = new FormData()
	form.append('email', email.value)
	form.append('password', password.value)

	const res = await fetch('/backend/login.php', { method: 'POST', body: form })
	const text = await res.text()

	if (text === 'ok') {
		window.location.reload()
	} else if (text === 'credenciales_incorrectas') {
		errorMsg.value = 'Email o contraseña incorrectos'
	} else {
		errorMsg.value = 'Faltan campos'
	}
}

async function handleRegister() {
	errorMsg.value = ''

	const form = new FormData()
	form.append('email', email.value)
	form.append('password', password.value)
	form.append('nombre', username.value)

	const res = await fetch('/backend/register.php', { method: 'POST', body: form })
	const text = await res.text()

	if (text === 'ok') {
		window.location.reload()
	} else if (text === 'ya_existe') {
		errorMsg.value = 'El email o nombre ya existe'
	} else {
		errorMsg.value = 'Error al registrar'
	}
}

function handleSubmit() {
	if (mode.value === 'login') handleLogin()
	else handleRegister()
}

function toggleMode() {
	errorMsg.value = ''
	mode.value = mode.value === 'login' ? 'register' : 'login'
}
</script>

<template>
	<div class="loginOverlay" @click.self="emit('close')">
		<div class="loginModal">
			<button class="loginClose" @click="emit('close')">&times;</button>

			<h2 class="loginTitle">
				{{ mode === 'login' ? 'Iniciar sesión' : 'Crear cuenta' }}
			</h2>

			<p v-if="errorMsg" class="loginError">{{ errorMsg }}</p>

			<form class="loginForm" @submit.prevent="handleSubmit">
				<input
					v-if="mode === 'register'"
					v-model="username"
					type="text"
					placeholder="Nombre de usuario"
					class="loginInput"
					required
				/>
				<input v-model="email" type="email" placeholder="Email" class="loginInput" required />
				<input v-model="password" type="password" placeholder="Contraseña" class="loginInput" required />
				<button type="submit" class="loginSubmit">
					{{ mode === 'login' ? 'Entrar' : 'Registrarse' }}
				</button>
			</form>

			<p class="loginSwitch">
				<template v-if="mode === 'login'">
					¿No tienes cuenta? <a href="#" @click.prevent="toggleMode">Regístrate</a>
				</template>
				<template v-else>
					¿Ya tienes cuenta? <a href="#" @click.prevent="toggleMode">Inicia sesión</a>
				</template>
			</p>
		</div>
	</div>
</template>
