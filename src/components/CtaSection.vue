<script setup>
// ── Sección de cierre (CTA final) ──
// Última llamada a la acción con botones para crear o explorar
defineProps({
	closingContent: {
		type: Object,
		required: true,
	},
})
</script>

<template>
	<section id="planes" class="closingSection">
		<div class="closingBackground"></div>
		<div class="container">
			<div class="closingContent">
				<h2>{{ closingContent.title }}</h2>
				<p>{{ closingContent.subtitle }}</p>
				<div class="closingActions">
					<a :href="closingContent.primaryCta.href" class="btn btnPrimary">{{ closingContent.primaryCta.label }}</a>
					<a :href="closingContent.secondaryCta.href" class="btn btnSecondary">{{ closingContent.secondaryCta.label }}</a>
				</div>
			</div>
		</div>
	</section>
</template>