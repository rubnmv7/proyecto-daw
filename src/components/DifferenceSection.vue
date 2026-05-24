<script setup>
// ── Comparativa: IA genérica vs Fanfia ──
// Dos paneles lado a lado mostrando la diferencia de calidad narrativa
defineProps({
	comparisonContent: {
		type: Object,
		required: true,
	},
})
</script>

<template>
	<section class="section comparisonSection">
		<div class="container">
			<h2>{{ comparisonContent.title }}</h2>
			<p class="sectionLead">{{ comparisonContent.intro }}</p>
			<div class="comparisonGrid">
				<div v-for="panel in comparisonContent.panels" :key="panel.title"
					:class="['comparisonCard', panel.title === 'IA genérica' ? 'isChatGPT' : 'isFanfia']">
					<div class="comparisonHead">
						<h3>{{ panel.title }}</h3>
						<span class="comparisonAuthor">{{ panel.author }}</span>
					</div>
					<div class="comparisonBody">
						<p>{{ panel.text }}</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>
