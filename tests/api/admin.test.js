import { describe, test, expect } from 'vitest'
import { BASE_URL } from './setup.js'

// ── Pruebas del panel de administración (sin sesión) ──

describe('Admin - sin autenticar', () => {

  test('check_admin deniega acceso sin sesión', async () => {
    const res = await fetch(`${BASE_URL}/admin/check_admin.php`)
    const data = await res.json()
    expect(data).toHaveProperty('error')
  })

  test('stats deniega acceso sin sesión', async () => {
    const res = await fetch(`${BASE_URL}/admin/stats.php`)
    const data = await res.json()
    expect(data).toHaveProperty('error')
  })

  test('get_users deniega acceso sin sesión', async () => {
    const res = await fetch(`${BASE_URL}/admin/get_users.php`)
    const data = await res.json()
    expect(data).toHaveProperty('error')
  })

  test('get_fanfics deniega acceso sin sesión', async () => {
    const res = await fetch(`${BASE_URL}/admin/get_fanfics.php`)
    const data = await res.json()
    expect(data).toHaveProperty('error')
  })

  test('get_genres deniega acceso sin sesión', async () => {
    const res = await fetch(`${BASE_URL}/admin/get_genres.php`)
    const data = await res.json()
    expect(data).toHaveProperty('error')
  })
})
