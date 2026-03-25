<script setup>
defineProps({
	heroContent: {
		type: Object,
		required: true,
	},
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
				<div class="heroBadge">{{ heroContent.stats }}</div>
			</div>
		</div>
	</header>
</template>