<script setup>
import logoUrl from '../../images/logo.svg'

defineProps({
  featureContent: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <section id="caracteristicas" class="section featureSection">
    <div class="container featureLayout">
      <div class="featureTextBlock">
        <h2>{{ featureContent.title }}</h2>
        <p class="sectionLead">{{ featureContent.intro }}</p>
        <ul class="featureList">
          <li v-for="feature in featureContent.items" :key="feature.title">
            <div class="featureMarker"></div>
            <div>
              <strong>{{ feature.title }}</strong>
              <p>{{ feature.text }}</p>
            </div>
          </li>
        </ul>
      </div>
      <div class="featureVisual">
        <img :src="logoUrl" alt="Logotipo de Fanfia" />
      </div>
    </div>
  </section>
</template>