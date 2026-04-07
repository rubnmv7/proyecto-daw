<script setup>
import { ref } from 'vue'

defineProps({
	fandomContent: {
		type: Object,
		required: true,
	},
})

const trackRef = ref(null)

function moveTrack(direction) {
	if (!trackRef.value) return
	trackRef.value.scrollBy({ left: direction * 260, behavior: 'smooth' })
}
</script>

<template>
	<section id="explorar" class="section fandomSection">
		<div class="container">
			<h2>{{ fandomContent.title }}</h2>
			<div class="fandomSlider">
				<button class="sliderButton isPrev" type="button" @click="moveTrack(-1)">&#8592;</button>
				<div ref="trackRef" class="fandomTrack">
				<div v-for="(item, index) in fandomContent.items" :key="index" class="fandomTile">
						<img :src="item.img" :alt="item.name" class="fandomImg" />
						<span>{{ item.name }}</span>
					</div>
				</div>
				<button class="sliderButton isNext" type="button" @click="moveTrack(1)">&#8594;</button>
			</div>
		</div>
	</section>
</template>