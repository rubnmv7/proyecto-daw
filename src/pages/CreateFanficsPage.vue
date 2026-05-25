<script setup>
import { ref, computed, onMounted } from 'vue'

// ─────────────── DATOS DEL FORMULARIO ───────────────
// Cada uno de estos campos se rellena en el formulario de la izquierda
const universoFandom      = ref('')     // El universo o fandom
const personajes           = ref('')     // Personajes que aparecerán
const tono                 = ref('Ligero')  // Tono de la historia
const duracion             = ref('medio')   // Longitud del fanfic
const pov                  = ref('Primera persona')  // Punto de vista narrativo
const argumento            = ref('')     // Argumento opcional detallado
const resultado            = ref('')     // Aquí se guarda el texto generado por la IA
const cargando             = ref(false)  // Mientras la IA está generando
const guardando            = ref(false)  // Mientras se guarda en la BD
const error                = ref('')     // Mensajes de error
const exito                = ref('')     // Mensajes de éxito al guardar
const tituloFanfic          = ref('')    // Título extraído de la respuesta de la IA
const descripcionFanfic     = ref('')    // Descripción corta extraída de la respuesta

// ─────────────── GÉNEROS ───────────────
// Se cargan desde la base de datos al entrar en la página
const generosDisponibles   = ref([])     // Lista de géneros que viene del backend
const generosSeleccionados = ref([])     // IDs de los géneros que el usuario ha marcado

// Al cargar la página, pedimos los géneros al servidor
onMounted(async () => {
  try {
    const res = await fetch('/backend/get_genres.php')
    generosDisponibles.value = await res.json()
  } catch (e) {}
})

const universo = computed(() => universoFandom.value)

// Marca o desmarca un género cuando el usuario hace click en un chip
function toggleGenero(id) {
  const idx = generosSeleccionados.value.indexOf(id)
  if (idx > -1) {
    generosSeleccionados.value.splice(idx, 1)
  } else {
    generosSeleccionados.value.push(id)
  }
}

// Convierte los IDs de géneros seleccionados a nombres separados por coma
// Esto se usa después para construir el prompt que se manda a la IA
const generosPrompt = computed(() => {
  return generosSeleccionados.value.map(id => {
    const g = generosDisponibles.value.find(g => g.id === id)
    return g ? g.nombre : ''
  }).filter(Boolean).join(', ') || 'Sin género'
})

// ─────────────── GENERAR FANFIC ───────────────
// Esta función se ejecuta al pulsar el botón "Generar"
// Valida los campos obligatorios, construye el prompt y lo envía a Gemini
async function generar() {
  // Validación: el usuario debe rellenar los campos obligatorios
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

  // Construye el prompt con todos los datos del formulario
  // Este texto se enviará a Gemini para que genere el fanfic
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
[DESCRIPCION: <frase corta de una línea que resuma el fanfic>]
<contenido del fanfic>

Escribe un fanfic completo de un solo capítulo. Usa formato narrativo, con diálogos y descripciones.`

  // Envía el prompt al backend PHP, que a su vez lo manda a Gemini
  try {
    const res = await fetch('/backend/generate.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ prompt }),
    })

    const data = await res.json()

    // Si el backend devuelve un error, lo mostramos
    if (data.error) {
      error.value = data.error
      return
    }

    // El texto generado viene en data.text (el backend ya extrajo la respuesta de Gemini)
    resultado.value = data.text ?? 'No se recibió texto de la IA.'

    // Extrae título y descripción de la respuesta
    let resto = resultado.value
    // TITULO
    const titMatch = resto.match(/^\[TITULO:\s*(.*?)\]/)
    if (titMatch) {
      tituloFanfic.value = titMatch[1]
      resto = resto.substring(titMatch[0].length).trim()
    }
    // DESCRIPCION
    const descMatch = resto.match(/^\[DESCRIPCION:\s*(.*?)\]/)
    if (descMatch) {
      descripcionFanfic.value = descMatch[1]
      resto = resto.substring(descMatch[0].length).trim()
    }
    resultado.value = resto
  } catch (e) {
    error.value = 'Error de conexión con el servidor.'
  } finally {
    cargando.value = false
  }
}

// ─────────────── GUARDAR EN BD ───────────────
// Guarda el fanfic generado en la base de datos
// Se envía el título, contenido y géneros al backend
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
        descripcion: descripcionFanfic.value.trim(),
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

    // Si se guardó correctamente, redirige a la página del fanfic
    exito.value = 'Fanfic guardado correctamente'
    setTimeout(() => location.hash = `#/fanfic/${data.id}`, 1500)
  } catch (e) {
    error.value = 'Error al guardar'
  } finally {
    guardando.value = false
  }
}
</script>

<template>
  <!-- ═══ PÁGINA DE CREACIÓN ═══ -->
  <!-- Layout de dos columnas: izquierda formulario, derecha resultado -->
  <div class="section">
    <div class="container layout">

      <!-- ─── COLUMNA IZQUIERDA: formulario de configuración ─── -->
      <aside>
        <div class="card panel">
          <h3>Configura tu fanfic</h3>

          <!-- Campo: universo o fandom -->
          <label>
            Universo o fandom
            <input class="field" v-model="universoFandom" placeholder="Ej: Fullmetal Alchemist, One Piece..." />
          </label>

          <!-- Campo: personajes -->
          <label>
            Personajes protagonistas
            <input class="field" v-model="personajes" placeholder="Ej: Luffy, Kaneki..." />
          </label>

          <!-- Campo: tono de la historia -->
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

          <!-- Campo: punto de vista narrativo -->
          <label>
            Punto de vista (POV)
            <select class="field" v-model="pov">
              <option value="Primera persona">Primera persona</option>
              <option value="Tercera persona">Tercera persona</option>
            </select>
          </label>

          <!-- Campo: duración / longitud -->
          <label>
            Duración
            <select class="field" v-model="duracion">
              <option value="corto">Corto (~500 palabras)</option>
              <option value="medio">Medio (~1000 palabras)</option>
              <option value="largo">Largo (~2000 palabras)</option>
            </select>
          </label>

          <!-- Campo: argumento o situación inicial (opcional) -->
          <label>
            Argumento o situación inicial
            <textarea class="field" v-model="argumento" rows="5"
              placeholder="Describe qué quieres que pase. Cuanto más detallado, mejor el resultado."></textarea>
          </label>

          <!-- Campo: selección de géneros -->
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

      <!-- ─── COLUMNA DERECHA: resultado y acciones ─── -->
      <main>
        <div class="card panel result-panel">
          <h2>Tu fanfic</h2>

          <!-- Mensajes de éxito o error -->
          <div v-if="exito" class="exito">{{ exito }}</div>
          <div v-if="error" class="err">{{ error }}</div>

          <!-- Área donde se muestra el fanfic generado -->
          <div class="result-area">
            <p v-if="cargando" class="muted placeholder-message">Generando tu fanfic…</p>
            <pre v-else-if="resultado" class="result-text">{{ resultado }}</pre>
            <p v-else class="muted placeholder-message">Rellena los campos y pulsa Generar.</p>
          </div>

          <!-- Botones de acción: copiar, guardar, generar -->
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
