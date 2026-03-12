<script setup>
import SiteNavbar from './components/SiteNavbar.vue'
import HeroSection from './components/HeroSection.vue'
import FeaturesSection from './components/FeaturesSection.vue'
import StepsSection from './components/StepsSection.vue'
import CommunitySection from './components/CommunitySection.vue'
import DifferenceSection from './components/DifferenceSection.vue'
import SampleSection from './components/SampleSection.vue'
import ExploreSection from './components/ExploreSection.vue'
import CtaSection from './components/CtaSection.vue'
import SiteFooter from './components/SiteFooter.vue'
import { landingContent } from './content/landingContent'
import { ref, onMounted, onBeforeUnmount } from 'vue'

const isNavSolid = ref(false)

function onScroll() {
  isNavSolid.value = window.scrollY > 40
}

onMounted(() => {
  window.addEventListener('scroll', onScroll)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', onScroll)
})
</script>

<template>
  <SiteNavbar :menu-links="landingContent.menuLinks" :is-nav-solid="isNavSolid" />
  <HeroSection :hero-content="landingContent.heroContent" />
  <FeaturesSection :feature-content="landingContent.featureContent" />
  <StepsSection :step-items="landingContent.stepItems" />
  <CommunitySection :quote-items="landingContent.quoteItems" />
  <DifferenceSection :comparison-content="landingContent.comparisonContent" />
  <SampleSection :preview-content="landingContent.previewContent" />
  <ExploreSection :fandom-content="landingContent.fandomContent" />
  <CtaSection :closing-content="landingContent.closingContent" />
  <SiteFooter :footer-content="landingContent.footerContent" />
</template>