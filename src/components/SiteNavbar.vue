<script setup>
// ── Barra de navegación principal ──
// Muestra logo, enlaces, y usuario logueado (con menú desplegable)
// También incluye el modal de login y el menú responsive para móvil
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
const showMobileMenu = ref(false)
const currentUser = ref(null)
const showDropdown = ref(false)

function cerrarDropdown(e) {
	if (!e.target.closest('.userDropdown')) showDropdown.value = false
}

function cerrarMobileMenu(e) {
	if (!e.target.closest('.mainNav')) showMobileMenu.value = false
}

// Al cargar, comprueba si hay sesión activa
onMounted(async () => {
	const res = await fetch('/backend/current_user.php')
	const text = await res.text()
	if (text !== 'no') currentUser.value = JSON.parse(text)
	document.addEventListener('click', cerrarDropdown)
	document.addEventListener('click', cerrarMobileMenu)
})

onBeforeUnmount(() => {
	document.removeEventListener('click', cerrarDropdown)
	document.removeEventListener('click', cerrarMobileMenu)
})

// Cierra la sesión del usuario
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
							<a v-if="currentUser?.tipo === 'Admin'" href="/admin" class="dropdownItem">Admin</a>
							<hr class="dropdownDivider" />
							<button class="dropdownItem" @click="logout">Cerrar sesión</button>
						</div>
					</div>
				</template>
				<button v-else class="navButton" @click="showLogin = true">Iniciar sesión</button>
			</div>

			<button class="hamburger" @click.stop="showMobileMenu = !showMobileMenu" aria-label="Menú">
				<span class="hamburger-line" :class="{ open: showMobileMenu }"></span>
				<span class="hamburger-line" :class="{ open: showMobileMenu }"></span>
				<span class="hamburger-line" :class="{ open: showMobileMenu }"></span>
			</button>
		</div>

		<div v-if="showMobileMenu" class="mobileMenu">
			<ul class="mobileNavList">
				<li v-for="link in menuLinks" :key="link.href">
					<a :href="link.href" class="mobileNavLink" @click="showMobileMenu = false">{{ link.label }}</a>
				</li>
			</ul>
			<template v-if="currentUser">
				<hr class="mobileDivider" />
				<a href="/perfil" class="mobileNavLink" @click="showMobileMenu = false">Configurar perfil</a>
				<a href="/mis-fanfics" class="mobileNavLink" @click="showMobileMenu = false">Mis Fanfics</a>
				<a v-if="currentUser?.tipo === 'Admin'" href="/admin" class="mobileNavLink" @click="showMobileMenu = false">Admin</a>
				<hr class="mobileDivider" />
				<button class="mobileNavLink mobileLogout" @click="logout">Cerrar sesión</button>
			</template>
			<template v-else>
				<hr class="mobileDivider" />
				<button class="mobileNavLink mobileLoginBtn" @click="showLogin = true; showMobileMenu = false">Iniciar sesión</button>
			</template>
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

.hamburger {
	display: none;
	flex-direction: column;
	gap: 5px;
	background: none;
	border: none;
	cursor: pointer;
	padding: 0.5rem;
	margin-left: auto;
}

.hamburger-line {
	display: block;
	width: 24px;
	height: 2px;
	background: var(--text);
	border-radius: 2px;
	transition: 0.3s;
}

.hamburger-line.open:nth-child(1) {
	transform: translateY(7px) rotate(45deg);
}

.hamburger-line.open:nth-child(2) {
	opacity: 0;
}

.hamburger-line.open:nth-child(3) {
	transform: translateY(-7px) rotate(-45deg);
}

.mobileMenu {
	position: absolute;
	top: var(--navh);
	left: 0;
	right: 0;
	background: var(--bg);
	border-bottom: 1px solid var(--panel-border);
	padding: 1rem 1.5rem 1.5rem;
	z-index: 200;
}

.mobileNavList {
	list-style: none;
	display: flex;
	flex-direction: column;
	gap: 0;
}

.mobileNavLink {
	display: block;
	padding: 0.75rem 0;
	color: var(--text);
	text-decoration: none;
	font-size: 1rem;
	background: none;
	border: none;
	text-align: left;
	width: 100%;
	cursor: pointer;
}

.mobileNavLink:hover {
	color: var(--primary);
}

.mobileDivider {
	border: none;
	border-top: 1px solid var(--panel-border);
	margin: 0.5rem 0;
}

.mobileLogout {
	color: #ef4444;
}

.mobileLoginBtn {
	color: var(--primary);
	font-weight: 600;
}

@media (max-width: 768px) {
	.hamburger {
		display: flex;
	}

	.navMenu,
	.navActions {
		display: none;
	}

	.userName {
		display: none;
	}
}
</style>