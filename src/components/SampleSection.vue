<script setup>
defineProps({
  previewContent: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <section id="crear" class="section librarySection">
    <div class="container">
      <h2>{{ previewContent.title }}</h2>
      <p class="sectionLead">{{ previewContent.intro }}</p>
      <div class="libraryLayout">
        <article class="featuredStoryCard">
          <div class="featuredStoryCover">{{ previewContent.featured.imageLabel }}</div>
          <div class="featuredStoryInfo">
            <h3>{{ previewContent.featured.title }}</h3>
            <p>{{ previewContent.featured.text }}</p>
          </div>
        </article>
        <div class="storyList">
          <article v-for="(item, index) in previewContent.items" :key="index" class="storyRow">
            <div class="storyThumb">Fanfic</div>
            <div class="storyInfo">
              <strong>{{ item.title }}</strong>
              <p>{{ item.text }}</p>
              <div class="storyMeta">
                <span class="storyMetaItem">👁 {{ item.views }}</span>
                <span class="storyMetaItem">✔ {{ item.likes }}</span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
</template>