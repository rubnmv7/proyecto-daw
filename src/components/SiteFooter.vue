<script setup>
defineProps({
	footerContent: {
		type: Object,
		required: true,
	},
})
</script>

<template>
	<footer id="contacto" class="footer">
		<div class="container footerLayout">
			<div class="footerCopy">{{ footerContent.copyright }}</div>
			<div class="footerLinks">
				<a v-for="link in footerContent.links" :key="link.label" :href="link.href">{{ link.label }}</a>
			</div>
		</div>
	</footer>
</template>