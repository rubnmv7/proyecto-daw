<script setup>
// ── Página de explorar fanfics públicos ──
// Muestra un buscador y listado de fanfics terminados de toda la comunidad
import { ref, onMounted } from 'vue'

const fanfics = ref([])
const generos = ref([])
const busqueda = ref('')
const generoFiltro = ref('')
const cargando = ref(true)

onMounted(() => cargar())

// Pide los fanfics al backend, con filtros si los hay
async function cargar() {
  cargando.value = true
  try {
    let url = '/backend/explore_fanfics.php?'
    if (busqueda.value) url += `buscar=${encodeURIComponent(busqueda.value)}&`
    if (generoFiltro.value) url += `genero=${generoFiltro.value}&`
    const res = await fetch(url)
    const data = await res.json()
    fanfics.value = data.fanfics || []
    generos.value = data.generos || []
  } catch (e) {}
  finally { cargando.value = false }
}

function verFanfic(id) {
  window.location.href = `/fanfic/${id}`
}
</script>

<template>
  <div class="page">
    <div class="container">
      <h1>Explorar fanfics</h1>

      <div class="filtros">
        <input class="field" v-model="busqueda" placeholder="Buscar por título o descripción..." @input="cargar" />
        <select class="field filtro-select" v-model="generoFiltro" @change="cargar">
          <option value="">Todos los géneros</option>
          <option v-for="g in generos" :key="g.id" :value="g.id">{{ g.nombre }}</option>
        </select>
      </div>

      <div v-if="cargando" class="loading">Cargando...</div>
      <div v-else-if="!fanfics.length" class="empty">No se encontraron fanfics.</div>
      <div v-else class="grid">
        <div v-for="f in fanfics" :key="f.id" class="card" @click="verFanfic(f.id)">
          <h3>{{ f.titulo }}</h3>
          <p class="desc">{{ f.descripcion || 'Sin descripción' }}</p>
          <div class="meta">
            <span>✍ {{ f.autor }}</span>
            <span>{{ f.capitulos }} cap{{ f.capitulos !== 1 ? 's' : '' }}</span>
            <span>{{ f.fecha }}</span>
          </div>
          <div v-if="f.generos.length" class="tags">
            <span v-for="g in f.generos" :key="g" class="tag">{{ g }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page {
  min-height: 100vh;
  padding: calc(var(--navh) + 2rem) 0 3rem;
}

.container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

h1 {
  font-size: 2rem;
  margin-bottom: 1.5rem;
}

.filtros {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
}

.field {
  display: block;
  width: 100%;
  padding: 0.6rem 0.75rem;
  border-radius: 6px;
  border: 1px solid rgba(255,255,255,0.08);
  background: rgba(255,255,255,0.04);
  color: var(--text);
  font-size: 0.9rem;
  box-sizing: border-box;
}

.filtro-select {
  max-width: 250px;
  flex-shrink: 0;
}

.filtro-select option { background: var(--card); }

.loading, .empty {
  text-align: center;
  padding: 3rem;
  color: var(--muted);
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.card {
  background: var(--card);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--radius);
  padding: 1.5rem;
  cursor: pointer;
  transition: transform 0.2s;
  text-align: center;
}

.card:hover {
  transform: translateY(-4px);
}

.card h3 {
  margin: 0 0 0.5rem;
  font-size: 1.1rem;
}

.desc {
  color: var(--muted);
  font-size: 0.9rem;
  margin: 0 0 1rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.meta {
  display: flex;
  justify-content: center;
  gap: 1rem;
  font-size: 0.85rem;
  color: var(--muted);
  margin-bottom: 0.75rem;
}

.tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem;
  justify-content: center;
}

.tag {
  font-size: 0.75rem;
  background: rgba(255,255,255,0.08);
  padding: 0.25rem 0.65rem;
  border-radius: 20px;
}

@media (max-width: 768px) {
  .filtros { flex-direction: column; }
  .filtro-select { max-width: 100%; }
  .grid { grid-template-columns: 1fr; }
  .meta { flex-wrap: wrap; gap: 0.4rem; }
  .page { padding: calc(var(--navh) + 1rem) 0 2rem; }
  h1 { font-size: 1.5rem; }
  .container { padding: 0 1rem; }
}
</style>