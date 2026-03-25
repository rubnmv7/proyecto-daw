<script setup>
import { ref } from 'vue'
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
</script>

<template>
	<nav class="mainNav" :class="{ isSolid: isNavSolid }">
		<div class="container navLayout">
			<a class="brandLink" href="#inicio" aria-label="Ir al inicio de Fanfia">
				<img :src="logoUrl" alt="Fanfia" class="brandLogo" />
				<span>Fanfia</span>
			</a>

			<ul class="navMenu">
				<li v-for="link in menuLinks" :key="link.href">
					<a :href="link.href">{{ link.label }}</a>
				</li>
			</ul>

			<div class="navActions">
				<a href="#crear" class="navButton navButtonPrimary">Crear con IA</a>
				<button class="navButton" @click="showLogin = true">Iniciar sesión</button>
			</div>
		</div>
	</nav>

	<LoginModal v-if="showLogin" @close="showLogin = false" />
</template>