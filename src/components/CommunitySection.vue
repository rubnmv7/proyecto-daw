<script setup>
defineProps({
	quoteItems: {
		type: Array,
		required: true,
	},
})
</script>

<template>
	<section class="section communitySection">
		<div class="container">
			<h2>Comunidad Fanfia</h2>
			<div class="cards quoteGrid">
				<div v-for="(item, index) in quoteItems" :key="index" class="card quoteCard">
					<p>{{ item.quote }}</p>
					<div class="quoteAuthor">
						<div class="authorAvatar"></div>
						<span>{{ item.author }}</span>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>