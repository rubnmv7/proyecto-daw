<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import logoUrl from '../../images/logo.svg'
import LoginModal from './LoginModal.vue'

defineProps({
	menuLinks: {
		type: Array,
		required: true,
	},
	isNavSolid: {
		type: Boolean,
		default: false,
	},
})

const showLogin = ref(false)
const currentUser = ref(null)
const showDropdown = ref(false)

function cerrarDropdown(e) {
	if (!e.target.closest('.userDropdown')) showDropdown.value = false
}

onMounted(async () => {
	const res = await fetch('/backend/current_user.php')
	const text = await res.text()
	if (text !== 'no') currentUser.value = JSON.parse(text)
	document.addEventListener('click', cerrarDropdown)
})

onBeforeUnmount(() => {
	document.removeEventListener('click', cerrarDropdown)
})

async function logout() {
	await fetch('/backend/logout.php', { method: 'POST' })
	window.location.reload()
}

function toggleDropdown() {
	showDropdown.value = !showDropdown.value
}
</script>

<template>
	<nav class="mainNav" :class="{ isSolid: isNavSolid }">
		<div class="container navLayout">
			<a href="/" class="brandLink" aria-label="Ir al inicio de Fanfia">
				<img :src="logoUrl" alt="Fanfia" class="brandLogo" />
				<span>Fanfia</span>
			</a>

			<ul class="navMenu">
				<li v-for="link in menuLinks" :key="link.href">
					<a :href="link.href">{{ link.label }}</a>
				</li>
			</ul>

			<div class="navActions">
				<template v-if="currentUser">
					<div class="userDropdown" @click.stop="toggleDropdown">
						<button class="userBtn">
							<img v-if="currentUser.foto" :src="currentUser.foto" class="userAvatar" />
							<span v-else class="userAvatar userInitial">{{ currentUser.nombre[0].toUpperCase() }}</span>
							<span class="userName">{{ currentUser.nombre }}</span>
							<span class="arrow" :class="{ up: showDropdown }">▼</span>
						</button>
						<div v-if="showDropdown" class="dropdownMenu">
							<a href="/perfil" class="dropdownItem">Configurar perfil</a>
							<a href="/mis-fanfics" class="dropdownItem">Mis Fanfics</a>
							<hr class="dropdownDivider" />
							<button class="dropdownItem" @click="logout">Cerrar sesión</button>
						</div>
					</div>
				</template>
				<button v-else class="navButton" @click="showLogin = true">Iniciar sesión</button>
			</div>
		</div>
	</nav>

	<LoginModal v-if="showLogin" @close="showLogin = false" />
</template>

<style scoped>
.userDropdown {
	position: relative;
}

.userBtn {
	display: flex;
	align-items: center;
	gap: 0.5rem;
	background: none;
	border: none;
	padding: 0.3rem;
	color: var(--text);
	cursor: pointer;
	font-size: 0.95rem;
}

.userAvatar {
	width: 32px;
	height: 32px;
	border-radius: 50%;
	object-fit: cover;
}

.userInitial {
	display: flex;
	align-items: center;
	justify-content: center;
	background: var(--primary);
	color: #fff;
	font-weight: 700;
	font-size: 0.85rem;
}

.arrow {
	font-size: 0.6rem;
	transition: 0.2s;
}

.arrow.up {
	transform: rotate(180deg);
}

.dropdownMenu {
	position: absolute;
	top: calc(100% + 0.5rem);
	right: 0;
	background: var(--card);
	border: 1px solid rgba(255,255,255,0.1);
	border-radius: 10px;
	min-width: 200px;
	box-shadow: 0 8px 24px rgba(0,0,0,0.4);
	z-index: 200;
	overflow: hidden;
}

.dropdownItem {
	display: block;
	width: 100%;
	padding: 0.7rem 1rem;
	color: var(--text);
	text-decoration: none;
	font-size: 0.9rem;
	background: none;
	border: none;
	text-align: left;
	cursor: pointer;
	box-sizing: border-box;
}

.dropdownItem:hover {
	background: rgba(255,255,255,0.06);
}

.dropdownDivider {
	border: none;
	border-top: 1px solid rgba(255,255,255,0.08);
	margin: 0;
}
</style>