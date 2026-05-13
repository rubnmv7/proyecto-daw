<script setup>
import { ref, onMounted } from 'vue'

defineProps({
	fandomContent: {
		type: Object,
		required: true,
	},
})

const fanfics = ref([])

onMounted(async () => {
	try {
		const res = await fetch('/backend/explore_fanfics.php?')
		const data = await res.json()
		fanfics.value = (data.fanfics || []).slice(0, 3)
	} catch (e) {}
})
</script>

<template>
	<section class="exploreSection">
		<div class="exploreBg"></div>
		<div class="container">
			<div class="exploreHeader">
				<h2>{{ fandomContent.title }}</h2>
				<p>Descubre las últimas historias creadas por la comunidad.</p>
			</div>

			<div v-if="fanfics.length" class="fanficsRow">
				<a v-for="f in fanfics" :key="f.id" :href="`/fanfic/${f.id}`" class="miniCard">
					<div class="miniCardTop">
						<span class="miniCardIcon">{{ f.generos?.[0]?.[0] || '★' }}</span>
					</div>
					<div class="miniCardBody">
						<strong>{{ f.titulo }}</strong>
						<span class="miniCardAuthor">✍ {{ f.autor }}</span>
					</div>
				</a>
			</div>

			<div class="exploreAction">
				<a href="/explorar" class="btn btnPrimary btnExplore">
					Explorar todos los fanfics
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
					</svg>
				</a>
			</div>
		</div>
	</section>
</template>

<style scoped>
.exploreSection {
	position: relative;
	overflow: hidden;
	padding: 5rem 0;
	text-align: center;
}

.exploreBg {
	position: absolute;
	inset: 0;
	background-image: var(--galaxy-image);
	background-position: center;
	background-size: cover;
	filter: saturate(0.55) brightness(0.45);
}

.exploreBg::after {
	content: "";
	position: absolute;
	inset: 0;
	background: linear-gradient(180deg, rgba(126,60,255,0.25), rgba(126,60,255,0.05)),
	            linear-gradient(180deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
}

.container {
	position: relative;
	z-index: 1;
}

.exploreHeader {
	margin-bottom: 2.5rem;
}

.exploreHeader h2 {
	font-size: 2.2rem;
	font-weight: 800;
	margin: 0 0 0.5rem;
}

.exploreHeader p {
	color: var(--muted);
	font-size: 1.05rem;
	margin: 0;
}

.fanficsRow {
	display: flex;
	gap: 1.25rem;
	justify-content: center;
	margin-bottom: 2.5rem;
	flex-wrap: wrap;
}

.miniCard {
	display: flex;
	flex-direction: column;
	width: 220px;
	background: rgba(16,16,27,0.7);
	backdrop-filter: blur(12px);
	border: 1px solid rgba(255,255,255,0.06);
	border-radius: 14px;
	overflow: hidden;
	text-decoration: none;
	color: var(--text);
	transition: 0.3s;
}

.miniCard:hover {
	transform: translateY(-6px);
	border-color: var(--primary);
	box-shadow: 0 12px 40px rgba(0,0,0,0.5);
}

.miniCardTop {
	display: flex;
	align-items: center;
	justify-content: center;
	height: 80px;
	background: linear-gradient(135deg, rgba(126,60,255,0.15), rgba(126,60,255,0.05));
}

.miniCardIcon {
	font-size: 1.6rem;
}

.miniCardBody {
	padding: 0.9rem 1rem;
	display: flex;
	flex-direction: column;
	gap: 0.3rem;
	text-align: left;
}

.miniCardBody strong {
	font-size: 0.95rem;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.miniCardAuthor {
	font-size: 0.8rem;
	color: var(--muted);
}

.btnExplore {
	display: inline-flex;
	align-items: center;
	gap: 0.6rem;
	padding: 0.85rem 2rem;
	font-size: 1.05rem;
}

@media (max-width: 768px) {
	.exploreSection { padding: 3rem 0; }
	.exploreHeader h2 { font-size: 1.6rem; }
	.miniCard { width: 160px; }
	.miniCardTop { height: 60px; }
}
</style>