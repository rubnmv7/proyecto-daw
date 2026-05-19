<script setup>
import { ref, onMounted } from 'vue'

const fanfics = ref([])
const cargando = ref(true)
const error = ref('')

onMounted(async () => {
  await cargarFanfics()
})

async function cargarFanfics() {
  cargando.value = true
  error.value = ''
  try {
    const res = await fetch('/backend/my_fanfics.php')
    const data = await res.json()
    if (data.error) {
      error.value = data.error
    } else {
      fanfics.value = data
    }
  } catch (e) {
    error.value = 'Error al cargar tus fanfics.'
  } finally {
    cargando.value = false
  }
}

function crearFanfic() {
  window.location.href = '/crear'
}

function verFanfic(id) {
  window.location.href = `/fanfic/${id}`
}

function getEstadoColor(estado) {
  const colores = {
    'Borrador': '#94a3b8',
    'En progreso': '#f59e0b',
    'Terminado': '#10b981'
  }
  return colores[estado] || '#94a3b8'
}
</script>

<template>
  <div class="page">
    <header class="page-header">
      <div class="container">
        <h1>Mis Fanfics</h1>
        <button class="btn btnPrimary" @click="crearFanfic">+ Nuevo Fanfic</button>
      </div>
    </header>

    <main class="container">
      <div v-if="cargando" class="loading">Cargando...</div>
      <div v-else-if="error" class="error-msg">{{ error }}</div>
      <div v-else-if="fanfics.length === 0" class="empty-state">
        <p>No tienes fanfics todavía.</p>
        <button class="btn btnPrimary" @click="crearFanfic">Crea tu primer fanfic</button>
      </div>
      <div v-else class="fanfics-grid">
        <div v-for="fanfic in fanfics" :key="fanfic.id" class="fanfic-card" @click="verFanfic(fanfic.id)">
          <div class="fanfic-header">
            <h3>{{ fanfic.titulo }}</h3>
            <span class="estado" :style="{ backgroundColor: getEstadoColor(fanfic.estado) }">
              {{ fanfic.estado }}
            </span>
          </div>
          <p class="descripcion">{{ fanfic.descripcion || 'Sin descripción' }}</p>
          <div class="fanfic-meta">
            <span>{{ fanfic.capitulos }} capítulo{{ fanfic.capitulos !== 1 ? 's' : '' }}</span>
            <span>{{ fanfic.fecha_actualizacion }}</span>
          </div>
          <div v-if="fanfic.generos.length" class="generos">
            <span v-for="g in fanfic.generos" :key="g" class="genero-tag">{{ g }}</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.page {
  min-height: 100vh;
  padding: calc(var(--navh) + 2rem) 0 3rem;
}

.page-header {
  margin-bottom: 2rem;
}

.page-header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.page-header h1 {
  font-size: 2rem;
  margin: 0;
}

.container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

.fanfics-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.fanfic-card {
  background: var(--card);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--radius);
  padding: 1.5rem;
  cursor: pointer;
  transition: transform 0.2s;
}

.fanfic-card:hover {
  transform: translateY(-4px);
}

.fanfic-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.75rem;
  gap: 1rem;
}

.fanfic-header h3 {
  margin: 0;
  font-size: 1.1rem;
  flex: 1;
}

.estado {
  font-size: 0.75rem;
  padding: 0.25rem 0.6rem;
  border-radius: 20px;
  color: #fff;
  white-space: nowrap;
}

.descripcion {
  color: var(--muted);
  font-size: 0.9rem;
  margin: 0 0 1rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.fanfic-meta {
  display: flex;
  justify-content: space-between;
  font-size: 0.85rem;
  color: var(--muted);
  margin-bottom: 0.75rem;
}

.generos {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.genero-tag {
  font-size: 0.75rem;
  background: rgba(255,255,255,0.08);
  padding: 0.25rem 0.65rem;
  border-radius: 20px;
}

.loading, .error-msg, .empty-state {
  text-align: center;
  padding: 3rem;
}

.error-msg { color: #f87171; }

.empty-state p {
  color: var(--muted);
  margin-bottom: 1rem;
}

@media (max-width: 768px) {
  .page { padding: calc(var(--navh) + 1rem) 0 2rem; }
  .page-header .container { flex-direction: column; gap: 1rem; align-items: flex-start; }
  .page-header h1 { font-size: 1.5rem; }
  .fanfics-grid { grid-template-columns: 1fr; }
  .fanfic-header { flex-direction: column; gap: 0.5rem; }
  .container { padding: 0 1rem; }
}
</style>