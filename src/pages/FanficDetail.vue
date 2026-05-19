<script setup>
import { ref, onMounted } from 'vue'

const pathParts = window.location.pathname.split('/')
const fanficId = pathParts[2]

const fanfic = ref(null)
const cargando = ref(true)
const error = ref('')
const valorando = ref(false)
const comentario = ref('')
const mostrarInput = ref(false)

onMounted(async () => {
  await cargarFanfic()
})

async function cargarFanfic() {
  cargando.value = true
  error.value = ''
  try {
    const res = await fetch(`/backend/get_fanfic.php?id=${fanficId}`)
    const data = await res.json()
    if (data.error) {
      error.value = data.error
    } else {
      fanfic.value = data
    }
  } catch (e) {
    error.value = 'Error al cargar el fanfic.'
  } finally {
    cargando.value = false
  }
}

async function valorar(tipo) {
  valorando.value = true
  error.value = ''
  try {
    const form = new FormData()
    form.append('fanfic_id', fanficId)
    form.append('tipo', tipo)
    form.append('comentario', comentario.value.trim())

    const res = await fetch('/backend/rate_fanfic.php', {
      method: 'POST',
      body: form
    })
    const data = await res.json()
    if (!res.ok) {
      if (res.status === 401) {
        window.location.href = '/'
        return
      }
      error.value = data.error || 'Error al valorar'
      return
    }
    if (data.success) {
      comentario.value = ''
      mostrarInput.value = false
      await cargarFanfic()
    }
  } catch (e) {
    error.value = 'Error de conexión'
  } finally {
    valorando.value = false
  }
}

function volver() {
  window.location.href = '/mis-fanfics'
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
    <div class="container">
      <button class="btn btnSecondary back-btn" @click="volver">← Mis Fanfics</button>

      <div v-if="cargando" class="loading">Cargando...</div>
      <div v-else-if="error" class="err">{{ error }}</div>

      <div v-else-if="fanfic" class="fanfic-detail">
        <header class="fanfic-header">
          <div>
            <h1>{{ fanfic.titulo }}</h1>
            <p class="autor">Por {{ fanfic.autor }}</p>
          </div>
          <span class="estado-badge" :style="{ backgroundColor: getEstadoColor(fanfic.estado) }">
            {{ fanfic.estado }}
          </span>
        </header>

        <p v-if="fanfic.descripcion" class="descripcion">{{ fanfic.descripcion }}</p>

        <div v-if="fanfic.generos.length" class="generos">
          <span v-for="g in fanfic.generos" :key="g" class="genero-tag">{{ g }}</span>
        </div>

        <section class="capitulos-section">
          <h2>Contenido</h2>
          <div v-if="!fanfic.capitulos_lista.length" class="empty-capitulos">
            Este fanfic no tiene contenido.
          </div>
          <div v-else class="capitulos-list">
            <div v-for="cap in fanfic.capitulos_lista" :key="cap.id" class="capitulo-card">
              <div class="cap-header">
                <h3>{{ cap.titulo }}</h3>
              </div>
              <p class="cap-contenido">{{ cap.contenido }}</p>
            </div>
          </div>
        </section>

        <section class="valoraciones-section">
          <h2>Valoraciones</h2>
          <div class="valoraciones-stats">
            <span class="stat positiva">👍 {{ fanfic.positivas }}</span>
            <span class="stat negativa">👎 {{ fanfic.negativas }}</span>
          </div>
          <div class="valorar-actions">
            <button class="btn btnValorar" :disabled="valorando" @click="valorar('Positiva')">👍 Me gusta</button>
            <button class="btn btnValorar" :disabled="valorando" @click="valorar('Negativa')">👎 No me gusta</button>
            <button class="btn btnSmall" @click="mostrarInput = !mostrarInput">
              {{ mostrarInput ? 'Cancelar' : 'Dejar comentario' }}
            </button>
          </div>
          <div v-if="mostrarInput" class="comentario-input">
            <textarea class="field" v-model="comentario" placeholder="Escribe un comentario..." rows="3"></textarea>
            <p class="field-hint">Pulsa 👍 o 👎 para guardar tu valoración con el comentario.</p>
          </div>
          <div v-if="fanfic.comentarios?.length" class="comentarios-lista">
            <div v-for="(c, i) in fanfic.comentarios" :key="i" class="comentario">
              <span class="comentario-tipo">{{ c.tipo === 'Positiva' ? '👍' : '👎' }}</span>
              <span class="comentario-texto">{{ c.comentario }}</span>
              <span class="comentario-fecha">{{ c.fecha }}</span>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page {
  min-height: 100vh;
  padding: calc(var(--navh) + 2rem) 0 3rem;
}

.container { max-width: 800px; margin: 0 auto; padding: 0 1.5rem; }
.back-btn { margin-bottom: 1.5rem; }
.loading, .err { text-align: center; padding: 2rem; }
.err { color: #f87171; }

.fanfic-detail {
  background: var(--card);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--radius);
  padding: 2rem;
}

.fanfic-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; gap: 2rem; }
.fanfic-header h1 { margin: 0 0 0.25rem; font-size: 1.8rem; }
.autor { color: var(--muted); margin: 0; font-size: 0.9rem; }

.estado-badge { padding: 0.35rem 0.8rem; border-radius: 20px; color: #fff; font-size: 0.8rem; }
.descripcion { color: var(--muted); margin-bottom: 1.5rem; line-height: 1.6; font-size: 0.95rem; }

.generos { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 2rem; }
.genero-tag { font-size: 0.75rem; background: rgba(126,60,255,0.1); color: var(--primary); padding: 0.25rem 0.65rem; border-radius: 20px; }

.capitulos-section h2 { font-size: 1.1rem; margin-bottom: 1rem; color: var(--text); }
.empty-capitulos { text-align: center; padding: 2rem; color: var(--muted); }

.cap-header h3 { margin: 0 0 1rem; font-size: 1.1rem; }

.cap-contenido {
  line-height: 1.9;
  white-space: pre-wrap;
  margin: 0;
  font-size: 0.95rem;
  color: var(--text);
}

.valoraciones-section { margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.06); }
.valoraciones-section h2 { font-size: 1.1rem; margin-bottom: 0.75rem; }
.valoraciones-stats { display: flex; gap: 1.5rem; margin-bottom: 0.75rem; }
.stat { font-size: 0.95rem; }
.stat.positiva { color: #10b981; }
.stat.negativa { color: #f87171; }
.valorar-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }

.btnValorar, .btnSmall {
  padding: 0.4rem 0.9rem;
  font-size: 0.85rem;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: var(--radius);
  background: rgba(255,255,255,0.04);
  color: var(--text);
  cursor: pointer;
}

.btnValorar:disabled { opacity: 0.5; cursor: not-allowed; }

.comentario-input { margin-top: 0.75rem; }

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
  resize: vertical;
}

.field-hint { font-size: 0.8rem; color: var(--muted); margin: 0.4rem 0 0; }

.comentarios-lista { margin-top: 0.75rem; display: flex; flex-direction: column; gap: 0.4rem; }

.comentario {
  display: flex;
  gap: 0.5rem;
  align-items: flex-start;
  background: rgba(255,255,255,0.02);
  border-radius: 6px;
  padding: 0.5rem 0.7rem;
}

.comentario-texto { flex: 1; font-size: 0.85rem; }
.comentario-fecha { font-size: 0.7rem; color: var(--muted); white-space: nowrap; }

@media (max-width: 768px) {
  .page { padding: calc(var(--navh) + 1rem) 0 2rem; }
  .container { padding: 0 1rem; }
  .fanfic-detail { padding: 1.25rem; }
  .fanfic-header h1 { font-size: 1.3rem; }
  .fanfic-header { flex-direction: column; gap: 0.75rem; }
  .valorar-actions { flex-direction: column; }
  .comentario { flex-wrap: wrap; }
}
</style>