<script setup>
// ── Cabecera principal de la landing ──
// Muestra el título, subtítulo, botones CTA y el contador de fanfics
import { ref, onMounted } from 'vue'

defineProps({
	heroContent: {
		type: Object,
		required: true,
	},
})

const totalFanfics = ref(0)

// Al cargar, pide al backend cuántos fanfics hay publicados
onMounted(async () => {
	try {
		const res = await fetch('/backend/fanfic_count.php')
		const data = await res.json()
		totalFanfics.value = data.total || 0
	} catch (e) {}
})
</script>

<template>
	<header id="inicio" class="heroSection">
		<div class="heroBackground"></div>
		<div class="container">
			<div class="heroCopy">
				<h1>{{ heroContent.title }}</h1>
				<p class="heroText">{{ heroContent.subtitle }}</p>
				<div class="heroActions">
					<a :href="heroContent.primaryCta.href" class="btn btnPrimary">{{ heroContent.primaryCta.label }}</a>
					<a :href="heroContent.secondaryCta.href" class="btn btnSecondary">{{ heroContent.secondaryCta.label }}</a>
				</div>
				<div class="heroBadge">{{ totalFanfics.toLocaleString() }} historias publicadas por el momento.</div>
			</div>
		</div>
	</header>
</template>
