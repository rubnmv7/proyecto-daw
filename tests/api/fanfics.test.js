import { describe, test, expect } from 'vitest'
import { BASE_URL } from './setup.js'

// ── Pruebas de fanfics (públicas, sin autenticación) ──

describe('Fanfics', () => {

  test('Obtener géneros devuelve un array', async () => {
    const res = await fetch(`${BASE_URL}/get_genres.php`)
    const data = await res.json()
    expect(Array.isArray(data)).toBe(true)
  })

  test('Cada género tiene id y nombre', async () => {
    const res = await fetch(`${BASE_URL}/get_genres.php`)
    const data = await res.json()
    if (data.length > 0) {
      expect(data[0]).toHaveProperty('id')
      expect(data[0]).toHaveProperty('nombre')
    }
  })

  test('Contar fanfics devuelve un número', async () => {
    const res = await fetch(`${BASE_URL}/fanfic_count.php`)
    const data = await res.json()
    expect(data).toHaveProperty('total')
    expect(typeof data.total).toBe('number')
  })

  test('Top fanfics devuelve array con límite respetado', async () => {
    const res = await fetch(`${BASE_URL}/top_fanfics.php?limit=2`)
    const data = await res.json()
    expect(Array.isArray(data)).toBe(true)
    expect(data.length).toBeLessThanOrEqual(2)
    if (data.length > 0) {
      expect(data[0]).toHaveProperty('titulo')
      expect(data[0]).toHaveProperty('autor')
    }
  })

  test('Explorar devuelve fanfics y generos', async () => {
    const res = await fetch(`${BASE_URL}/explore_fanfics.php`)
    const data = await res.json()
    expect(data).toHaveProperty('fanfics')
    expect(data).toHaveProperty('generos')
    expect(Array.isArray(data.fanfics)).toBe(true)
    expect(Array.isArray(data.generos)).toBe(true)
  })

  test('Buscar fanfics por texto no falla', async () => {
    const res = await fetch(`${BASE_URL}/explore_fanfics.php?buscar=test`)
    const data = await res.json()
    expect(data).toHaveProperty('fanfics')
  })

  test('Filtrar fanfics por género no falla', async () => {
    const res = await fetch(`${BASE_URL}/explore_fanfics.php?genero=1`)
    const data = await res.json()
    expect(data).toHaveProperty('fanfics')
  })
})
