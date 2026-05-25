<script setup>
// ── Página de perfil de usuario ──
// Permite al usuario cambiar su nombre, email y foto de perfil
import { ref, onMounted } from 'vue'

const usuario = ref(null)
const nombre = ref('')
const email = ref('')
const foto = ref('')
const cargando = ref(true)
const guardando = ref(false)
const error = ref('')
const exito = ref('')

// Carga los datos del usuario al entrar
onMounted(async () => {
  const res = await fetch('/backend/current_user.php')
  const text = await res.text()
  if (text === 'no') {
    location.hash = '#/'
    return
  }
  usuario.value = JSON.parse(text)
  nombre.value = usuario.value.nombre
  email.value = usuario.value.email
  foto.value = usuario.value.foto || ''
  cargando.value = false
})

// Guarda los cambios del perfil en el backend
async function guardar() {
  if (!nombre.value.trim() || !email.value.trim()) {
    error.value = 'Todos los campos son obligatorios'
    return
  }

  guardando.value = true
  error.value = ''
  exito.value = ''

  try {
    const res = await fetch('/backend/update_profile.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nombre: nombre.value.trim(),
        email: email.value.trim(),
        foto: foto.value.trim()
      })
    })
    const data = await res.json()
    if (data.error) {
      error.value = data.error
    } else {
      exito.value = 'Perfil actualizado correctamente'
      usuario.value.nombre = nombre.value.trim()
      usuario.value.email = email.value.trim()
      usuario.value.foto = foto.value.trim() || null
    }
  } catch (e) {
    error.value = 'Error de conexión'
  } finally {
    guardando.value = false
  }
}

function volver() {
  window.history.back()
}
</script>

<template>
  <div class="page">
    <div class="container">
      <button class="btn btnSecondary back-btn" @click="volver">← Volver</button>

      <div v-if="cargando" class="loading">Cargando...</div>
      <div v-else class="perfil-card">
        <h1>Configurar perfil</h1>

        <div class="avatar-section">
          <img v-if="foto" :src="foto" class="avatar-preview" />
          <div v-else class="avatar-preview avatar-placeholder">{{ (nombre || 'U')[0].toUpperCase() }}</div>
        </div>

        <div v-if="error" class="msg err">{{ error }}</div>
        <div v-if="exito" class="msg exito">{{ exito }}</div>

        <form @submit.prevent="guardar">
          <label class="field-group">
            Nombre de usuario
            <input class="field" v-model="nombre" maxlength="30" />
          </label>

          <label class="field-group">
            Email
            <input class="field" v-model="email" type="email" maxlength="100" />
          </label>

          <label class="field-group">
            URL de foto de perfil
            <input class="field" v-model="foto" placeholder="https://ejemplo.com/avatar.jpg" />
            <span class="field-hint">Pega una URL de imagen (opcional)</span>
          </label>

          <div class="actions">
            <button type="submit" class="btn btnPrimary" :disabled="guardando">
              {{ guardando ? 'Guardando...' : 'Guardar cambios' }}
            </button>
          </div>
        </form>
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
  max-width: 600px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

.back-btn { margin-bottom: 1.5rem; }

.loading { text-align: center; padding: 2rem; }

.perfil-card {
  background: var(--card);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--radius);
  padding: 2rem;
}

h1 {
  margin: 0 0 1.5rem;
  font-size: 1.5rem;
}

.avatar-section {
  display: flex;
  justify-content: center;
  margin-bottom: 1.5rem;
}

.avatar-preview {
  width: 96px;
  height: 96px;
  border-radius: 50%;
  object-fit: cover;
}

.avatar-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--primary);
  color: #fff;
  font-size: 2rem;
  font-weight: 700;
}

.field-group {
  display: block;
  margin-bottom: 1.25rem;
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
  box-sizing: border-box;
}

.field-hint {
  display: block;
  font-size: 0.8rem;
  color: var(--muted);
  margin-top: 0.3rem;
}

.actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 1.5rem;
}

.msg {
  margin-bottom: 1rem;
}

.err { color: #f87171; }
.exito { color: #10b981; }

@media (max-width: 768px) {
  .page { padding: calc(var(--navh) + 1rem) 0 2rem; }
  .container { padding: 0 1rem; }
  .perfil-card { padding: 1.25rem; }
}
</style>