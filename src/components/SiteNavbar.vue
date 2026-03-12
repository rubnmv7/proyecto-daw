<script setup>
import logoUrl from '../../images/logo.svg'

defineProps({
  menuLinks: {
    type: Array,
    required: true,
  },
  isNavSolid: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <nav class="mainNav" :class="{ isSolid: isNavSolid }">
    <div class="container navLayout">
      <a class="brandLink" href="#inicio" aria-label="Ir al inicio de Fanfia">
        <img :src="logoUrl" alt="Fanfia" class="brandLogo" />
        <span>Fanfia</span>
      </a>

      <ul class="navMenu">
        <li v-for="link in menuLinks" :key="link.href">
          <a :href="link.href">{{ link.label }}</a>
        </li>
      </ul>

      <div class="navActions">
        <a href="#crear" class="navButton navButtonPrimary">Crear con IA</a>
        <a href="#contacto" class="navButton">Iniciar sesión</a>
      </div>
    </div>
  </nav>
</template>