<script setup>
import { ref, computed } from 'vue'
import { landingContent } from '../content/landingContent'

const fandoms = landingContent.fandomContent.items

const universoSeleccionado = ref('')
const universoCustom       = ref('')
const personajes           = ref('')
const genero               = ref('Romance')
const tono                 = ref('Ligero')
const duracion             = ref('medio')
const pov                  = ref('Primera persona')
const argumento            = ref('')
const resultado            = ref('')

const universo = computed(() =>
  universoSeleccionado.value === '__otro__'
    ? universoCustom.value
    : universoSeleccionado.value
)
</script>

<template>
  <div class="section">
    <div class="container layout">

      <aside>
        <div class="card panel">
          <h3>Configura tu fanfic</h3>

          <label>
            Universo o fandom
            <select class="field" v-model="universoSeleccionado">
              <option value="">— Elige un fandom —</option>
              <option v-for="f in fandoms" :key="f.name" :value="f.name">{{ f.name }}</option>
              <option value="__otro__">Otro…</option>
            </select>
          </label>
          <label v-if="universoSeleccionado === '__otro__'">
            Escribe tu fandom
            <input class="field" v-model="universoCustom" placeholder="Ej: Fullmetal Alchemist" />
          </label>

          <label>
            Personajes protagonistas
            <input class="field" v-model="personajes" placeholder="Ej: Luffy, Kaneki..." />
          </label>

          <label>
            Género
            <select class="field" v-model="genero">
              <option>Romance</option>
              <option>Drama</option>
              <option>Acción</option>
              <option>Comedia</option>
              <option>Misterio</option>
              <option>Terror</option>
              <option>Aventura</option>
              <option>Fantasía</option>
            </select>
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
        </div>
      </aside>

      <main>
        <div class="card panel result-panel">
          <h2>Tu fanfic</h2>

          <div class="result-area">
            <pre v-if="resultado" class="result-text">{{ resultado }}</pre>
            <p v-else class="muted placeholder-message">Rellena los campos y pulsa Generar.</p>
          </div>

          <div class="actions">
            <button class="btn btnPrimary">Generar</button>
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
  margin-top: 1rem;
}

.btn:disabled { opacity: 0.5; cursor: not-allowed; }

@media (max-width: 768px) {
  .layout { flex-direction: column; }
  aside { width: 100%; }
  .result-panel { height: auto; min-height: 400px; }
}
</style>
