<script setup>
// ── Secciones de la landing ──
import SiteNavbar from './components/SiteNavbar.vue'
import HeroSection from './components/HeroSection.vue'
import FeaturesSection from './components/FeaturesSection.vue'
import StepsSection from './components/StepsSection.vue'
import CommunitySection from './components/CommunitySection.vue'
import DifferenceSection from './components/DifferenceSection.vue'
import SampleSection from './components/SampleSection.vue'
import CtaSection from './components/CtaSection.vue'
import SiteFooter from './components/SiteFooter.vue'

// ── Páginas principales ──
import CreateFanficsPage from './pages/CreateFanficsPage.vue'
import MyFanficsPage from './pages/MyFanficsPage.vue'
import FanficDetail from './pages/FanficDetail.vue'
import ProfilePage from './pages/ProfilePage.vue'
import ExplorePage from './pages/ExplorePage.vue'
import AdminPage from './pages/AdminPage.vue'

// ── Contenido de texto de la landing ──
import { landingContent } from './content/landingContent'
import { ref, onMounted, onBeforeUnmount } from 'vue'

const isNavSolid = ref(false) // fondo sólido al hacer scroll
const route = ref(window.location.pathname || '/')

function onPopState() {
	route.value = window.location.pathname || '/'
}

function onScroll() {
	isNavSolid.value = window.scrollY > 40
}

onMounted(() => {
	window.addEventListener('scroll', onScroll)
	window.addEventListener('popstate', onPopState)
})

onBeforeUnmount(() => {
	window.removeEventListener('scroll', onScroll)
	window.removeEventListener('popstate', onPopState)
})
</script>

<template>
	<SiteNavbar :menu-links="landingContent.menuLinks" :is-nav-solid="isNavSolid" />

	<!-- ─── RUTAS: cada página se muestra según la URL ─── -->
	<CreateFanficsPage v-if="route === '/crear'" />
	<MyFanficsPage v-else-if="route === '/mis-fanfics'" />
	<FanficDetail v-else-if="route.startsWith('/fanfic/')" />
	<ProfilePage v-else-if="route === '/perfil'" />
	<ExplorePage v-else-if="route === '/explorar'" />
	<AdminPage v-else-if="route === '/admin'" />

	<!-- ─── LANDING: si no es ninguna ruta, se muestra la página principal ─── -->
	<div v-else>
		<HeroSection :hero-content="landingContent.heroContent" />
		<FeaturesSection :feature-content="landingContent.featureContent" />
		<StepsSection :step-items="landingContent.stepItems" />
		<CommunitySection :quote-items="landingContent.quoteItems" />
		<DifferenceSection :comparison-content="landingContent.comparisonContent" />
		<SampleSection :preview-content="landingContent.previewContent" />
		<CtaSection :closing-content="landingContent.closingContent" />
		<SiteFooter :footer-content="landingContent.footerContent" />
	</div>
</template>
