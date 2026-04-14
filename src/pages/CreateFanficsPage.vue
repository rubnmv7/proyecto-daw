<script setup>
</script>

<template>
  <div class="section" style="min-height:80vh;padding:calc(var(--navh) + 2rem) 0 3rem;">
    <div class="container" style="display:flex;gap:2rem;align-items:flex-start;">
      <aside style="width:320px;">
        <div class="card" style="padding:1rem;">
          <h3>¿Cómo quieres el fanfic?</h3>
          <label>Genero<input class="loginInput" placeholder="Género" /></label>
          <label>Tipo<input class="loginInput" placeholder="Tipo" /></label>
          <label>Duración<input class="loginInput" placeholder="Duración" /></label>
          <label>Universo<input class="loginInput" placeholder="Universo" /></label>
          <label>Aportaciones extra<textarea class="loginInput" rows="6"></textarea></label>
        </div>
      </aside>

      <main style="flex:1;">
        <div class="card" style="min-height:420px;padding:1.25rem;display:flex;flex-direction:column;">
          <h2>Crear fanfic con IA</h2>
          <div style="flex:1;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.02);border-radius:8px;margin-top:0.75rem;">
            <div style="color:var(--muted);">Texto generado por la IA</div>
          </div>
          <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
            <button class="btn btnPrimary">Generar</button>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<style scoped>
.loginInput { width:100%; padding:0.6rem; border-radius:6px; border:1px solid rgba(255,255,255,0.06); background:transparent; color:var(--text); }

aside label,
main label {
  display: block;
  color: var(--text);
  margin-bottom: 0.75rem;
}

aside label .loginInput,
main label .loginInput {
  margin-top: 0.5rem;
}

aside label + label,
main label + label {
  margin-top: 0.75rem;
}
</style>
