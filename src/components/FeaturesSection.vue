<script setup>
// ── Sección de características ──
// Explica las 3 funcionalidades principales de la app con iconos SVG
import logoUrl from '../../images/logo.svg'

defineProps({
	featureContent: {
		type: Object,
		required: true,
	},
})
</script>

<template>
	<section id="caracteristicas" class="section featureSection">
		<div class="container featureLayout">
			<div class="featureTextBlock">
				<h2>{{ featureContent.title }}</h2>
				<p class="sectionLead">{{ featureContent.intro }}</p>
				<ul class="featureList">
					<li v-for="(feature, i) in featureContent.items" :key="feature.title">
						<div class="featureMarker">
							<svg v-if="i === 0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
							<svg v-else-if="i === 1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
							<svg v-else width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
						</div>
						<div>
							<strong>{{ feature.title }}</strong>
							<p>{{ feature.text }}</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="featureVisual">
				<img :src="logoUrl" alt="Logotipo de Fanfia" />
			</div>
		</div>
	</section>
</template>