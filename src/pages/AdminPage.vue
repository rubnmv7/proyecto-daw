<script setup>
import { ref, onMounted } from 'vue'

const tab = ref('dashboard')
const loading = ref(false)

const authed = ref(false)

const stats = ref(null)

const users = ref([])
const userSearch = ref('')
const editingUser = ref(null)
const userForm = ref({ nombre: '', email: '', tipo: '' })

const fanfics = ref([])
const fanficSearch = ref('')
const fanficEstado = ref('')

const genres = ref([])
const genreInput = ref('')
const editingGenre = ref(null)

onMounted(async () => {
	const res = await fetch('/backend/admin/check_admin.php')
	if (!res.ok) {
		window.location.href = '/'
		return
	}
	authed.value = true
	cargarTab('dashboard')
})

function cargarTab(t) {
	tab.value = t
	loading.value = true
	if (t === 'dashboard') cargarDashboard()
	else if (t === 'usuarios') cargarUsuarios()
	else if (t === 'fanfics') cargarFanfics()
	else if (t === 'generos') cargarGeneros()
	else loading.value = false
}


async function cargarDashboard() {
	const res = await fetch('/backend/admin/stats.php')
	stats.value = await res.json()
	loading.value = false
}

function maxEstados() {
	if (!stats.value?.fanfics_by_estado) return 1
	return Math.max(...Object.values(stats.value.fanfics_by_estado), 1)
}


async function cargarUsuarios() {
	const params = userSearch.value ? `?search=${encodeURIComponent(userSearch.value)}` : ''
	const res = await fetch(`/backend/admin/get_users.php${params}`)
	users.value = await res.json() || []
	loading.value = false
}

function abrirEditarUsuario(u) {
	editingUser.value = u
	userForm.value = { nombre: u.nombre, email: u.email, tipo: u.tipo }
}

function cerrarEditarUsuario() {
	editingUser.value = null
}

async function guardarUsuario() {
	if (!userForm.value.nombre || !userForm.value.email) return

	const res = await fetch('/backend/admin/update_user.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			id: editingUser.value.id,
			nombre: userForm.value.nombre.trim(),
			email: userForm.value.email.trim(),
			tipo: userForm.value.tipo,
		}),
	})
	const data = await res.json()

	if (data.success) {
		cerrarEditarUsuario()
		cargarUsuarios()
	}
}

async function eliminarUsuario(id) {
	if (!confirm('¿Eliminar este usuario? Se borrarán todos sus fanfics.')) return
	const res = await fetch('/backend/admin/delete_user.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: `id=${id}`,
	})
	const data = await res.json()
	if (data.success) cargarUsuarios()
}


async function cargarFanfics() {
	const params = new URLSearchParams()
	if (fanficSearch.value) params.set('search', fanficSearch.value)
	if (fanficEstado.value) params.set('estado', fanficEstado.value)
	const res = await fetch(`/backend/admin/get_fanfics.php?${params}`)
	fanfics.value = await res.json() || []
	loading.value = false
}

async function eliminarFanfic(id) {
	if (!confirm('¿Eliminar este fanfic? Esta acción no se puede deshacer.')) return
	const res = await fetch('/backend/admin/delete_fanfic.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: `id=${id}`,
	})
	const data = await res.json()
	if (data.success) cargarFanfics()
}

function verFanfic(id) {
	window.open(`/fanfic/${id}`, '_blank')
}


async function cargarGeneros() {
	const res = await fetch('/backend/admin/get_genres.php')
	genres.value = await res.json() || []
	loading.value = false
}

function editarGenero(g) {
	editingGenre.value = { ...g }
	genreInput.value = g.nombre
}

function cancelarEditarGenero() {
	editingGenre.value = null
	genreInput.value = ''
}

async function guardarGenero() {
	const nombre = genreInput.value.trim()
	if (!nombre) return

	const body = editingGenre.value
		? { id: editingGenre.value.id, nombre }
		: { nombre }

	const res = await fetch('/backend/admin/save_genre.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(body),
	})
	const data = await res.json()

	if (data.success) {
		genreInput.value = ''
		editingGenre.value = null
		cargarGeneros()
	}
}

async function eliminarGenero(id) {
	if (!confirm('¿Eliminar este género?')) return
	const res = await fetch('/backend/admin/delete_genre.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: `id=${id}`,
	})
	const data = await res.json()
	if (data.success) cargarGeneros()
}

function getEstadoColor(estado) {
	const colores = { Borrador: '#94a3b8', 'En progreso': '#f59e0b', Terminado: '#10b981' }
	return colores[estado] || '#94a3b8'
}
</script>

<template>
	<div class="admin-page" v-if="authed">
		<div class="admin-header">
			<div class="container">
				<h1>Panel de Administración</h1>
				<nav class="admin-tabs">
					<button :class="['tab', { active: tab === 'dashboard' }]" @click="cargarTab('dashboard')">
						Dashboard
					</button>
					<button :class="['tab', { active: tab === 'usuarios' }]" @click="cargarTab('usuarios')">
						Usuarios
					</button>
					<button :class="['tab', { active: tab === 'fanfics' }]" @click="cargarTab('fanfics')">
						Fanfics
					</button>
					<button :class="['tab', { active: tab === 'generos' }]" @click="cargarTab('generos')">
						Géneros
					</button>
				</nav>
			</div>
		</div>

		<div class="container admin-body">
			<div v-if="loading" class="loading">Cargando...</div>

			<div v-else-if="tab === 'dashboard' && stats">
				<div class="stat-grid">
					<div class="stat-card">
						<span class="stat-num">{{ stats.total_users }}</span>
						<span class="stat-label">Usuarios</span>
					</div>
					<div class="stat-card">
						<span class="stat-num">{{ stats.total_fanfics }}</span>
						<span class="stat-label">Fanfics</span>
					</div>
					<div class="stat-card">
						<span class="stat-num">{{ stats.total_valoraciones }}</span>
						<span class="stat-label">Valoraciones</span>
					</div>
					<div class="stat-card">
						<span class="stat-num">{{ stats.total_capitulos }}</span>
						<span class="stat-label">Capítulos</span>
					</div>
					<div class="stat-card">
						<span class="stat-num">{{ stats.total_generos }}</span>
						<span class="stat-label">Géneros</span>
					</div>
				</div>

				<div class="charts-grid">
					<div class="chart-card">
						<h3>Fanfics por estado</h3>
						<div class="bar-chart">
							<div v-for="(count, key) in stats.fanfics_by_estado" :key="key" class="bar-row">
								<span class="bar-label">{{ key }}</span>
								<div class="bar-track">
									<div class="bar-fill" :style="{ width: (count / maxEstados() * 100) + '%', background: getEstadoColor(key) }"></div>
								</div>
								<span class="bar-value">{{ count }}</span>
							</div>
							<p v-if="!Object.keys(stats.fanfics_by_estado).length" class="muted">Sin datos</p>
						</div>
					</div>

					<div class="chart-card">
						<h3>Usuarios por mes</h3>
						<div class="bar-chart">
							<div v-for="item in stats.users_by_month" :key="item.mes" class="bar-row">
								<span class="bar-label">{{ item.mes }}</span>
								<div class="bar-track">
									<div class="bar-fill bar-fill-alt" :style="{ width: Math.min(item.total / 5 * 100, 100) + '%' }"></div>
								</div>
								<span class="bar-value">{{ item.total }}</span>
							</div>
							<p v-if="!stats.users_by_month.length" class="muted">Sin datos</p>
						</div>
					</div>
				</div>

				<div class="chart-card full">
					<h3>Top fanfics por valoraciones</h3>
					<div v-if="stats.top_fanfics.length" class="table-wrap"><table class="admin-table">
						<thead>
							<tr><th>#</th><th>Título</th><th>Autor</th><th>Valoraciones</th></tr>
						</thead>
						<tbody>
							<tr v-for="(f, i) in stats.top_fanfics" :key="f.id">
								<td>{{ i + 1 }}</td>
								<td><a :href="'/fanfic/' + f.id" class="link">{{ f.titulo }}</a></td>
								<td>{{ f.autor }}</td>
								<td>{{ f.total }}</td>
							</tr>
						</tbody>
					</table></div>
					<p v-if="!stats.top_fanfics.length" class="muted">Sin datos</p>
				</div>
			</div>

			<div v-else-if="tab === 'usuarios'">
				<div class="toolbar">
					<input class="field" v-model="userSearch" placeholder="Buscar por nombre o email..." @input="cargarUsuarios" />
				</div>

				<div class="table-wrap"><table class="admin-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Email</th>
							<th>Tipo</th>
							<th>Fecha</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="u in users" :key="u.id">
							<td>{{ u.id }}</td>
							<td>{{ u.nombre }}</td>
							<td>{{ u.email }}</td>
							<td><span :class="['badge', u.tipo === 'Admin' ? 'badge-admin' : 'badge-user']">{{ u.tipo }}</span></td>
							<td>{{ u.fecha }}</td>
							<td class="actions-cell">
								<button class="btn btnSmall" @click="abrirEditarUsuario(u)">Editar</button>
								<button class="btn btnSmall btnDanger" @click="eliminarUsuario(u.id)">Eliminar</button>
							</td>
						</tr>
						<tr v-if="!users.length"><td colspan="6" class="muted center">No hay usuarios.</td></tr>
					</tbody>
				</table></div>
			</div>

			<div v-else-if="tab === 'fanfics'">
				<div class="toolbar">
					<input class="field" v-model="fanficSearch" placeholder="Buscar por título o autor..." @input="cargarFanfics" />
					<select class="field" v-model="fanficEstado" @change="cargarFanfics">
						<option value="">Todos los estados</option>
						<option value="Borrador">Borrador</option>
						<option value="En progreso">En progreso</option>
						<option value="Terminado">Terminado</option>
					</select>
				</div>

				<div class="table-wrap"><table class="admin-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Título</th>
							<th>Autor</th>
							<th>Estado</th>
							<th>Capítulos</th>
							<th>Valoraciones</th>
							<th>Fecha</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="f in fanfics" :key="f.id">
							<td>{{ f.id }}</td>
							<td>{{ f.titulo }}</td>
							<td>{{ f.autor }}</td>
							<td>
								<span class="badge" :style="{ background: getEstadoColor(f.estado) }">{{ f.estado }}</span>
							</td>
							<td>{{ f.capitulos }}</td>
							<td>{{ f.valoraciones }}</td>
							<td>{{ f.fecha }}</td>
							<td class="actions-cell">
								<button class="btn btnSmall" @click="verFanfic(f.id)">Ver</button>
								<button class="btn btnSmall btnDanger" @click="eliminarFanfic(f.id)">Eliminar</button>
							</td>
						</tr>
						<tr v-if="!fanfics.length"><td colspan="8" class="muted center">No hay fanfics.</td></tr>
					</tbody>
				</table></div>
			</div>

			<div v-else-if="tab === 'generos'">
				<div class="genre-form">
					<input class="field" v-model="genreInput" :placeholder="editingGenre ? 'Nuevo nombre...' : 'Nuevo género...'"
						@keyup.enter="guardarGenero" />
					<button class="btn btnPrimary" @click="guardarGenero" :disabled="!genreInput.trim()">
						{{ editingGenre ? 'Actualizar' : 'Añadir' }}
					</button>
					<button v-if="editingGenre" class="btn btnSecondary" @click="cancelarEditarGenero">Cancelar</button>
				</div>

				<div class="table-wrap"><table class="admin-table">
					<thead>
						<tr><th>ID</th><th>Nombre</th><th>Fanfics</th><th>Acciones</th></tr>
					</thead>
					<tbody>
						<tr v-for="g in genres" :key="g.id">
							<td>{{ g.id }}</td>
							<td>{{ g.nombre }}</td>
							<td>{{ g.total_fanfics }}</td>
							<td class="actions-cell">
								<button class="btn btnSmall" @click="editarGenero(g)">Editar</button>
								<button class="btn btnSmall btnDanger" @click="eliminarGenero(g.id)" :disabled="g.total_fanfics > 0">Eliminar</button>
							</td>
						</tr>
						<tr v-if="!genres.length"><td colspan="4" class="muted center">No hay géneros.</td></tr>
					</tbody>
				</table></div>
			</div>
		</div>
	</div>

	<div v-if="editingUser" class="modal-overlay" @click.self="cerrarEditarUsuario">
		<div class="modal-card">
			<h3>Editar usuario #{{ editingUser.id }}</h3>
			<form @submit.prevent="guardarUsuario" class="modal-form">
				<label class="field-group">
					Nombre
					<input class="field" v-model="userForm.nombre" required />
				</label>
				<label class="field-group">
					Email
					<input class="field" v-model="userForm.email" type="email" required />
				</label>
				<label class="field-group">
					Tipo
					<select class="field" v-model="userForm.tipo">
						<option value="Normal">Normal</option>
						<option value="Admin">Admin</option>
					</select>
				</label>
				<div class="modal-actions">
					<button type="button" class="btn btnSecondary" @click="cerrarEditarUsuario">Cancelar</button>
					<button type="submit" class="btn btnPrimary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</template>

<style scoped>
.admin-page {
	padding-top: var(--navh);
	min-height: 100vh;
}

.admin-header {
	background: var(--card);
	border-bottom: 1px solid var(--panel-border);
	padding: 1.5rem 0 0;
}

.admin-header h1 {
	font-size: 1.5rem;
	margin-bottom: 1rem;
}

.admin-tabs {
	display: flex;
	gap: 0;
	border-bottom: 1px solid var(--panel-border);
	overflow-x: auto;
	-webkit-overflow-scrolling: touch;
	scrollbar-width: none;
}

.admin-tabs::-webkit-scrollbar {
	display: none;
}

.tab {
	position: relative;
	padding: 0.7rem 1.5rem;
	border: none;
	background: transparent;
	color: var(--muted);
	cursor: pointer;
	font-size: 0.95rem;
	transition: 0.2s;
	white-space: nowrap;
}

.tab:hover {
	color: var(--primary);
}

.tab.active {
	color: var(--primary);
	font-weight: 600;
}

.tab.active::after {
	content: '';
	position: absolute;
	bottom: -1px;
	left: 0;
	right: 0;
	height: 2px;
	background: var(--primary);
}

.admin-body {
	padding: 2rem 0;
}

.loading {
	text-align: center;
	color: var(--muted);
	padding: 3rem 0;
}

.stat-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
	gap: 1rem;
	margin-bottom: 1.5rem;
}

.stat-card {
	background: var(--card);
	border: 1px solid var(--panel-border);
	border-radius: var(--radius);
	padding: 1.4rem;
	text-align: center;
}

.stat-num {
	display: block;
	font-size: 2rem;
	font-weight: 800;
	color: var(--primary);
}

.stat-label {
	display: block;
	font-size: 0.85rem;
	color: var(--muted);
	margin-top: 0.3rem;
}

.charts-grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 1rem;
	margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
	.charts-grid {
		grid-template-columns: 1fr;
	}

	.genre-form {
		flex-direction: column;
	}

	.genre-form .field {
		min-width: 0;
	}

	.toolbar {
		flex-direction: column;
	}

	.toolbar .field {
		min-width: 0;
	}

	.admin-table th,
	.admin-table td {
		padding: 0.5rem 0.6rem;
		font-size: 0.8rem;
	}

	.actions-cell {
		flex-direction: column;
		gap: 0.3rem;
	}

	.stat-grid {
		grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
	}

	.bar-label {
		width: 70px;
		font-size: 0.75rem;
	}
}

@media (max-width: 480px) {
	.admin-header h1 {
		font-size: 1.2rem;
	}

	.tab {
		padding: 0.6rem 1rem;
		font-size: 0.85rem;
	}

	.stat-grid {
		grid-template-columns: repeat(2, 1fr);
	}

	.stat-num {
		font-size: 1.5rem;
	}
}

.chart-card {
	background: var(--card);
	border: 1px solid var(--panel-border);
	border-radius: var(--radius);
	padding: 1.4rem;
}

.chart-card.full {
	grid-column: 1 / -1;
}

.chart-card h3 {
	font-size: 1rem;
	margin-bottom: 1rem;
	color: var(--text);
}

.bar-chart {
	display: flex;
	flex-direction: column;
	gap: 0.6rem;
}

.bar-row {
	display: flex;
	align-items: center;
	gap: 0.6rem;
}

.bar-label {
	width: 100px;
	font-size: 0.85rem;
	color: var(--muted);
	flex-shrink: 0;
}

.bar-track {
	flex: 1;
	height: 20px;
	background: var(--bg);
	border-radius: 6px;
	overflow: hidden;
}

.bar-fill {
	height: 100%;
	border-radius: 6px;
	transition: width 0.5s;
}

.bar-fill-alt {
	background: var(--primary);
}

.bar-value {
	width: 30px;
	text-align: right;
	font-size: 0.85rem;
	color: var(--muted);
}

.admin-table {
	width: 100%;
	border-collapse: collapse;
	background: var(--card);
	border: 1px solid var(--panel-border);
	border-radius: var(--radius);
	overflow: hidden;
}

.admin-table th,
.admin-table td {
	padding: 0.7rem 1rem;
	text-align: left;
	border-bottom: 1px solid var(--panel-border);
}

.admin-table th {
	color: var(--muted);
	font-weight: 600;
	font-size: 0.8rem;
	text-transform: uppercase;
	letter-spacing: 0.05em;
	background: rgba(0, 0, 0, 0.15);
}

.admin-table td {
	color: var(--text);
	font-size: 0.9rem;
}

.admin-table tbody tr:hover {
	background: rgba(126, 60, 255, 0.04);
}

.admin-table tbody tr:last-child td {
	border-bottom: none;
}

.center {
	text-align: center;
}

.table-wrap {
	overflow-x: auto;
	-webkit-overflow-scrolling: touch;
	border-radius: var(--radius);
}

.toolbar {
	display: flex;
	gap: 0.8rem;
	margin-bottom: 1rem;
	flex-wrap: wrap;
}

.toolbar .field {
	flex: 1;
	min-width: 200px;
}

.field-group {
	display: flex;
	flex-direction: column;
	gap: 0.3rem;
	font-size: 0.9rem;
	color: var(--muted);
}

.badge {
	display: inline-block;
	padding: 0.2rem 0.6rem;
	border-radius: 12px;
	font-size: 0.8rem;
	font-weight: 600;
	color: #fff;
}

.badge-user {
	background: #475569;
}

.badge-admin {
	background: var(--primary);
}

.actions-cell {
	display: flex;
	gap: 0.4rem;
}

.btnSmall {
	padding: 0.35rem 0.75rem;
	border: 1px solid var(--panel-border);
	border-radius: var(--radius);
	background: transparent;
	color: var(--text);
	font-size: 0.8rem;
	cursor: pointer;
	transition: 0.2s;
}

.btnSmall:hover {
	border-color: var(--primary);
	color: var(--primary);
}

.btnDanger {
	border-color: rgba(239, 68, 68, 0.3);
	color: #ef4444;
}

.btnDanger:hover {
	color: #ef4444;
	border-color: rgba(239, 68, 68, 0.3);
	transform: translateY(-1px);
}

.link {
	color: var(--primary);
}

.link:hover {
	text-decoration: underline;
}

.muted {
	color: var(--muted);
}

.genre-form {
	display: flex;
	gap: 0.6rem;
	margin-bottom: 1rem;
	flex-wrap: wrap;
}

.genre-form .field {
	flex: 1;
	min-width: 200px;
}

.modal-overlay {
	position: fixed;
	inset: 0;
	z-index: 300;
	display: flex;
	align-items: center;
	justify-content: center;
	background: rgba(0, 0, 0, 0.6);
}

.modal-card {
	width: 100%;
	max-width: 420px;
	background: var(--card);
	border: 1px solid var(--panel-border);
	border-radius: var(--radius);
	padding: 2rem;
}

.modal-card h3 {
	margin-bottom: 1.2rem;
	font-size: 1.2rem;
}

.modal-form {
	display: flex;
	flex-direction: column;
	gap: 1rem;
}

.modal-actions {
	display: flex;
	gap: 0.8rem;
	justify-content: flex-end;
	margin-top: 0.5rem;
}

.field {
	width: 100%;
	padding: 0.65rem 0.85rem;
	border: 1px solid var(--panel-border);
	border-radius: var(--radius);
	background: var(--bg);
	color: var(--text);
	font-size: 0.9rem;
	outline: none;
	transition: border-color 0.2s;
}

.field:focus {
	border-color: var(--primary);
}

.btn {
	display: inline-block;
	padding: 0.65rem 1.4rem;
	border: none;
	border-radius: var(--radius);
	font-size: 0.9rem;
	font-weight: 600;
	cursor: pointer;
	transition: 0.2s;
	white-space: nowrap;
}

.btnPrimary {
	background: var(--primary);
	color: #fff;
}

.btnPrimary:hover {
	background: var(--primary-dark);
}

.btnPrimary:disabled {
	opacity: 0.5;
	cursor: not-allowed;
}

.btnSecondary {
	background: transparent;
	border: 1px solid var(--panel-border);
	color: var(--text);
}

.btnSecondary:hover {
	border-color: var(--primary);
	color: var(--primary);
}
</style>
