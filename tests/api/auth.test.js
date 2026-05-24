import { describe, test, expect, beforeAll } from 'vitest'
import { BASE_URL } from './setup.js'

const email = `test_${Date.now()}@fanfia.com`
const password = 'Test1234'
const nombre = `User_${Date.now()}`

// ── Pruebas de autenticación ──

describe('Autenticación', () => {

  test('Registrar usuario devuelve ok', async () => {
    const form = new URLSearchParams()
    form.append('email', email)
    form.append('password', password)
    form.append('nombre', nombre)

    const res = await fetch(`${BASE_URL}/register.php`, {
      method: 'POST',
      body: form,
    })
    const text = await res.text()
    expect(text).toBe('ok')
  })

  test('Registrar mismo email devuelve ya_existe', async () => {
    const form = new URLSearchParams()
    form.append('email', email)
    form.append('password', password)
    form.append('nombre', `Otro_${Date.now()}`)

    const res = await fetch(`${BASE_URL}/register.php`, {
      method: 'POST',
      body: form,
    })
    const text = await res.text()
    expect(text).toBe('ya_existe')
  })

  test('Login correcto devuelve ok', async () => {
    const form = new URLSearchParams()
    form.append('email', email)
    form.append('password', password)

    const res = await fetch(`${BASE_URL}/login.php`, {
      method: 'POST',
      body: form,
    })
    const text = await res.text()
    expect(text).toBe('ok')
  })

  test('Login incorrecto devuelve credenciales_incorrectas', async () => {
    const form = new URLSearchParams()
    form.append('email', email)
    form.append('password', 'contraseñafalsa')

    const res = await fetch(`${BASE_URL}/login.php`, {
      method: 'POST',
      body: form,
    })
    const text = await res.text()
    expect(text).toBe('credenciales_incorrectas')
  })

  test('Login sin email devuelve faltan_campos', async () => {
    const form = new URLSearchParams()
    form.append('password', password)

    const res = await fetch(`${BASE_URL}/login.php`, {
      method: 'POST',
      body: form,
    })
    const text = await res.text()
    expect(text).toBe('faltan_campos')
  })
})
