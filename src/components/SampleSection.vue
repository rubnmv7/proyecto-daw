<script setup>
// ── Preview de fanfics populares (landing) ──
// Carga y muestra los 6 fanfics más valorados de la comunidad
import { ref, onMounted } from 'vue'

defineProps({
	previewContent: {
		type: Object,
		required: true,
	},
})

const fanfics = ref([])
const cargando = ref(true)

// Pide al backend los fanfics más valorados al cargar
onMounted(async () => {
	try {
		const res = await fetch('/backend/top_fanfics.php?limit=6')
		if (res.ok) {
			fanfics.value = await res.json()
		}
	} catch (e) {
		console.error(e)
	} finally {
		cargando.value = false
	}
})

// Devuelve clase CSS según el estado del fanfic
function estadoClass(estado) {
	if (estado === 'Terminado') return 'done'
	if (estado === 'En progreso') return 'progress'
	return 'draft'
}

// Icono corto para cada estado
function estadoShort(estado) {
	if (estado === 'Terminado') return '✓'
	if (estado === 'En progreso') return '…'
	return '✎'
}

function verFanfic(id) {
	window.location.href = `/fanfic/${id}`
}
</script>

<template>
	<section id="crear" class="section librarySection">
		<div class="container">
			<h2>{{ previewContent.title }}</h2>
			<p class="sectionLead">{{ previewContent.intro }}</p>
			<div class="libraryLayout">
				<div class="storyList">
					<div v-if="cargando" class="storyRow">
						<p style="color: var(--muted);">Cargando fanfics…</p>
					</div>
					<article v-else-if="fanfics.length" v-for="item in fanfics" :key="item.id" class="storyRow" @click="verFanfic(item.id)">
						<div class="storyThumb statusThumb" :class="estadoClass(item.estado)">
							{{ estadoShort(item.estado) }}
						</div>
						<div class="storyInfo">
							<strong>{{ item.titulo }}</strong>
							<p>{{ item.descripcion || 'Sin descripción.' }}</p>
							<div class="storyMeta">
								<span class="storyMetaItem">✍ {{ item.autor }}</span>
								<span class="storyMetaItem">{{ item.capitulos }} caps</span>
								<span class="storyMetaItem">✔ {{ item.valoraciones }}</span>
							</div>
						</div>
					</article>
					<div v-else class="storyRow">
						<p style="color: var(--muted);">Aún no hay fanfics en la biblioteca.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<style scoped>
.storyRow {
	cursor: pointer;
}

.statusThumb {
	font-size: 1rem;
	font-weight: 700;
}

.statusThumb.done {
	color: #34d399;
	background: rgba(52, 211, 153, 0.12);
}

.statusThumb.progress {
	color: #fbbf24;
	background: rgba(251, 191, 36, 0.12);
}

.statusThumb.draft {
	color: #94a3b8;
	background: rgba(148, 163, 184, 0.12);
}
</style>
