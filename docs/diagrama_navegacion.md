# Diagrama de navegación

## Estructura de la web

Landing (/) 
  ├── Hero
  ├── Características
  ├── Cómo funciona
  ├── Testimonios
  ├── Comparativa IA vs Fanfia
  ├── Fanfics populares
  ├── CTA final
  └── Footer (/explorar, /crear)

/crear       → Formulario de generar fanfic con IA
/explorar    → Buscador de fanfics públicos
/mis-fanfics → Mis fanfics (requiere login)
/fanfic/{id} → Ver fanfic + valorar
/perfil      → Editar perfil (requiere login)
/admin       → Panel de administración (solo Admin)

Flujo usuario no logueado:
  Landing → LoginModal → login/register → recarga→ sesión activa

Flujo usuario logueado:
  Menú dropdown → /perfil, /mis-fanfics, /admin, cerrar sesión

Rutas protegidas:
  /mis-fanfics → redirige a / si no hay sesión
  /perfil → redirige a / si no hay sesión
  /admin → redirige a / si no es Admin