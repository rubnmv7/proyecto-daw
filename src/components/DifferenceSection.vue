<script setup>
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
			<div class="comparisonPanels">
				<div v-for="panel in comparisonContent.panels" :key="panel.title" class="comparisonCard">
					<h3>{{ panel.title }}</h3>
					<div class="comparisonText">
						<p>{{ panel.text }}</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>