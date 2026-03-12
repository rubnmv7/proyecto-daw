<script setup>
defineProps({
  stepItems: {
    type: Array,
    required: true,
  },
})
</script>

<template>
  <section id="pasos" class="section processSection">
    <div class="container">
      <h2>Cómo funciona</h2>
      <div class="cards">
        <div v-for="(step, index) in stepItems" :key="step.title" class="card processCard">
          <span class="stepBadge">{{ index + 1 }}</span>
          <h3>{{ step.title }}</h3>
          <p>{{ step.text }}</p>
        </div>
      </div>
    </div>
  </section>
</template>