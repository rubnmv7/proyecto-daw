<script setup>
import { ref, computed, onMounted } from 'vue'

const universoFandom      = ref('')
const personajes           = ref('')
const tono                 = ref('Ligero')
const duracion             = ref('medio')
const pov                  = ref('Primera persona')
const argumento            = ref('')
const resultado            = ref('')
const cargando             = ref(false)
const guardando            = ref(false)
const error                = ref('')
const exito                = ref('')
const tituloFanfic          = ref('')
const generosDisponibles   = ref([])
const generosSeleccionados = ref([])

onMounted(async () => {
  try {
    const res = await fetch('/backend/get_genres.php')
    generosDisponibles.value = await res.json()
  } catch (e) {}
})

const universo = computed(() => universoFandom.value)

function toggleGenero(id) {
  const idx = generosSeleccionados.value.indexOf(id)
  if (idx > -1) {
    generosSeleccionados.value.splice(idx, 1)
  } else {
    generosSeleccionados.value.push(id)
  }
}

const generosPrompt = computed(() => {
  return generosSeleccionados.value.map(id => {
    const g = generosDisponibles.value.find(g => g.id === id)
    return g ? g.nombre : ''
  }).filter(Boolean).join(', ') || 'Sin género'
})

async function generar() {
  if (!universoFandom.value.trim()) {
    error.value = 'El campo "Universo o fandom" es obligatorio'
    return
  }
  if (!personajes.value.trim()) {
    error.value = 'El campo "Personajes protagonistas" es obligatorio'
    return
  }
  if (!generosSeleccionados.value.length) {
    error.value = 'Selecciona al menos un género'
    return
  }

  cargando.value = true
  error.value = ''
  resultado.value = ''

  const prompt = `Escribe un fanfic con las siguientes características:
- Universo/Fandom: ${universo.value}
- Personajes protagonistas: ${personajes.value}
- Género: ${generosPrompt.value}
- Tono: ${tono.value}
- Punto de vista: ${pov.value}
- Duración: ${duracion.value}
${argumento.value ? '- Argumento: ' + argumento.value : ''}

Formato de respuesta:
[TITULO: <título del fanfic>]
<contenido del fanfic>

Escribe el capítulo 1 completo. Usa formato narrativo, con diálogos y descripciones.`

  try {
    const res = await fetch('/backend/generate.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ prompt }),
    })

    const data = await res.json()

    if (data.error) {
      error.value = data.error
      return
    }

    resultado.value = data.candidates?.[0]?.content?.parts?.[0]?.text ?? 'No se recibió texto de la IA.'

    if (resultado.value.startsWith('[TITULO:')) {
      const firstLineEnd = resultado.value.indexOf(']')
      if (firstLineEnd > 0) {
        tituloFanfic.value = resultado.value.substring(9, firstLineEnd).trim()
        resultado.value = resultado.value.substring(firstLineEnd + 1).trim()
      }
    }
  } catch (e) {
    error.value = 'Error de conexión con el servidor.'
  } finally {
    cargando.value = false
  }
}

async function guardarFanfic() {
  if (!tituloFanfic.value.trim()) {
    error.value = 'Genera el contenido primero para obtener el título'
    return
  }
  if (!resultado.value.trim()) {
    error.value = 'Genera el contenido primero'
    return
  }

  guardando.value = true
  error.value = ''

  try {
    const res = await fetch('/backend/save_fanfic.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        titulo: tituloFanfic.value.trim(),
        descripcion: '',
        estado: 'Terminado',
        generos: generosSeleccionados.value,
        capitulo_titulo: 'Capítulo 1',
        capitulo_contenido: resultado.value
      })
    })

    const data = await res.json()

    if (data.error) {
      error.value = data.error
      return
    }

    exito.value = 'Fanfic guardado correctamente'
    setTimeout(() => window.location.href = `/fanfic/${data.id}`, 1500)
  } catch (e) {
    error.value = 'Error al guardar'
  } finally {
    guardando.value = false
  }
}
</script>

<template>
  <div class="section">
    <div class="container layout">

      <aside>
        <div class="card panel">
          <h3>Configura tu fanfic</h3>

          <label>
            Universo o fandom
            <input class="field" v-model="universoFandom" placeholder="Ej: Fullmetal Alchemist, One Piece..." />
          </label>

          <label>
            Personajes protagonistas
            <input class="field" v-model="personajes" placeholder="Ej: Luffy, Kaneki..." />
          </label>

          <label>
            Tono
            <select class="field" v-model="tono">
              <option>Ligero</option>
              <option>Intenso</option>
              <option>Oscuro</option>
              <option>Cómico</option>
              <option>Melancólico</option>
              <option>Épico</option>
            </select>
          </label>

          <label>
            Punto de vista (POV)
            <select class="field" v-model="pov">
              <option value="Primera persona">Primera persona</option>
              <option value="Tercera persona">Tercera persona</option>
            </select>
          </label>

          <label>
            Duración
            <select class="field" v-model="duracion">
              <option value="corto">Corto (~500 palabras)</option>
              <option value="medio">Medio (~1000 palabras)</option>
              <option value="largo">Largo (~2000 palabras)</option>
            </select>
          </label>

          <label>
            Argumento o situación inicial
            <textarea class="field" v-model="argumento" rows="5"
              placeholder="Describe qué quieres que pase. Cuanto más detallado, mejor el resultado."></textarea>
          </label>

          <label>
            Géneros
            <div class="generosGrid">
              <span v-for="g in generosDisponibles" :key="g.id"
                class="generoChip"
                :class="{ selected: generosSeleccionados.includes(g.id) }"
                @click="toggleGenero(g.id)">{{ g.nombre }}</span>
              <span v-if="!generosDisponibles.length" class="muted">Cargando...</span>
            </div>
          </label>
        </div>
      </aside>

      <main>
        <div class="card panel result-panel">
          <h2>Tu fanfic</h2>

          <div v-if="exito" class="exito">{{ exito }}</div>
          <div v-if="error" class="err">{{ error }}</div>

          <div class="result-area">
            <p v-if="cargando" class="muted placeholder-message">Generando tu fanfic…</p>
            <pre v-else-if="resultado" class="result-text">{{ resultado }}</pre>
            <p v-else class="muted placeholder-message">Rellena los campos y pulsa Generar.</p>
          </div>

          <div class="actions">
            <button class="btn btnSecondary" @click="navigator.clipboard.writeText(resultado)" :disabled="!resultado">
              Copiar
            </button>
            <button class="btn btnPrimary" @click="guardarFanfic" :disabled="guardando || !resultado">
              {{ guardando ? 'Guardando...' : 'Guardar' }}
            </button>
            <button class="btn btnPrimary" @click="generar" :disabled="cargando">
              {{ cargando ? 'Generando...' : 'Generar' }}
            </button>
          </div>
        </div>
      </main>

    </div>
  </div>
</template>

<style scoped>
.section {
  min-height: 100vh;
  padding: calc(var(--navh) + 2rem) 0 3rem;
}

.layout {
  display: flex;
  gap: 2rem;
  align-items: stretch;
}

aside { width: 340px; flex-shrink: 0; }
main  { flex: 1; min-width: 0; display: flex; flex-direction: column; }
main .card { flex: 1; }

.panel { padding: 1.25rem; }
.panel h3 { margin-bottom: 1rem; }

label {
  display: block;
  color: var(--text);
  font-size: 0.9rem;
  margin-bottom: 1rem;
}

.field {
  display: block;
  width: 100%;
  margin-top: 0.4rem;
  padding: 0.6rem 0.75rem;
  border-radius: 6px;
  border: 1px solid rgba(255,255,255,0.08);
  background: rgba(255,255,255,0.04);
  color: var(--text);
  font-size: 0.9rem;
}

textarea.field {
  resize: vertical;
  box-sizing: border-box;
  max-width: 100%;
  min-width: 0;
  overflow-wrap: break-word;
  word-break: break-word;
}

select.field option { background: var(--card); }

.result-panel {
  display: flex;
  flex-direction: column;
  height: 100%;
  box-sizing: border-box;
}

.result-panel h2 { margin-bottom: 0.75rem; }

.result-area {
  flex: 1;
  background: rgba(255,255,255,0.02);
  border-radius: 8px;
  padding: 1.25rem;
  overflow-y: auto;
}

.result-text {
  white-space: pre-wrap;
  font-family: inherit;
  font-size: 0.95rem;
  line-height: 1.8;
  margin: 0;
}

.muted { color: var(--muted); margin: 0; }
.err   { color: #f87171; margin: 0; }
.exito { color: #10b981; margin-bottom: 1rem; }

.placeholder-message {
  font-size: 1.06rem;
  font-weight: 600;
  text-align: center;
  padding: 0.9rem 0;
  color: var(--muted);
  opacity: 0.95;
  margin: 0;
}

.actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}

.btn:disabled { opacity: 0.5; cursor: not-allowed; }

.generosGrid {
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem;
  margin-top: 0.4rem;
}

.generoChip {
  display: inline-block;
  padding: 0.3rem 0.7rem;
  border-radius: 20px;
  border: 1px solid rgba(255,255,255,0.15);
  background: transparent;
  color: var(--text);
  font-size: 0.8rem;
  cursor: pointer;
  transition: 0.2s;
}

.generoChip:hover {
  background: rgba(255,255,255,0.08);
}

.generoChip.selected {
  background: var(--primary);
  border-color: var(--primary);
  color: #fff;
}

@media (max-width: 768px) {
  .layout { flex-direction: column; }
  aside { width: 100%; }
  .result-panel { height: auto; min-height: 400px; }
}
</style>