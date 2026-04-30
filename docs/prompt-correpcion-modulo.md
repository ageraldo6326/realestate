Actúa como un desarrollador Senior Full Stack experto en Laravel, Vue.js y MySQL, especializado en hardening de módulos CRUD empresariales.

Necesito que audites, corrijas y refuerces completamente el módulo que te indique (o cualquier módulo similar) para eliminar errores de creación, edición, actualización y eliminación de registros.

Tu objetivo principal es garantizar que el módulo funcione de forma robusta, segura y sin fallos tanto en frontend como backend.

### Áreas que debes revisar y corregir obligatoriamente:

## 1. FRONTEND (Vue.js)

Analiza formularios, componentes, modales y pantallas relacionadas.

### Validaciones requeridas:

- Campos obligatorios vacíos.
- Strings con espacios en blanco.
- Emails inválidos.
- Contraseñas débiles.
- Confirmación de contraseña.
- Selects sin opción seleccionada.
- Checkboxes requeridos.
- Fechas inválidas.
- Números fuera de rango.
- Longitud mínima y máxima.
- Inputs duplicados antes de enviar (email, username, etc).
- Inputs deshabilitados que no envían datos.
- Campos readonly inconsistentes.
- Problemas con v-model null/undefined.
- Datos reactivos no inicializados.
- Errores de watchers.
- Problemas en props.
- Estado roto después de cerrar modales.
- Formularios que permiten doble submit.
- Botones sin loading state.
- Manejo incorrecto de errores 422.
- Toasts inconsistentes.
- Falta de feedback visual.

### Debes implementar:

- Validación en tiempo real.
- Mensajes claros por campo.
- Deshabilitar botón mientras procesa.
- Spinner/loading.
- Reset limpio del formulario.
- Confirmaciones al eliminar.
- Manejo global de errores Axios/Fetch.
- Protección contra múltiples clics.
- UX profesional.

---

## 2. BACKEND (Laravel)

Revisa Controllers, Form Requests, Models, Services y Policies.

Si el modulo usa modal, cambiarlo a pantallas o vistas separadas segun las funciones (crear, editar)

### Validaciones requeridas:

- required
- nullable correctamente usado
- string
- integer
- boolean
- email
- exists
- unique
- confirmed
- min / max
- regex
- sometimes
- array
- date
- after / before
- required_if
- required_without
- unique ignorando update

### Corregir:

- Mass Assignment ($fillable / $guarded)
- Campos null inesperados
- Valores vacíos guardados como null
- Password sin hash
- Updates parciales defectuosos
- Datos duplicados
- Race conditions
- Transacciones faltantes
- Try/catch ausente
- Respuestas JSON inconsistentes
- Códigos HTTP incorrectos
- Logs inexistentes
- Soft delete mal implementado
- Relaciones rotas
- N+1 queries
- Errores 500 evitables
- Policies / permisos faltantes
- Sanitización de input
- Trim automático
- Casts faltantes

### Debes implementar:

- FormRequest para store/update
- DB::transaction donde aplique
- Logs estructurados
- Responses estandarizadas
- Manejo elegante de excepciones
- Validaciones reutilizables
- Código limpio SOLID

---

## 3. BASE DE DATOS (MySQL)

Audita estructura de tablas.

### Revisar:

- Campos VARCHAR demasiado pequeños
- Campos innecesariamente grandes
- Nullables incorrectos
- Índices faltantes
- Unique indexes faltantes
- Foreign keys faltantes
- Default values incorrectos
- Charset / collation
- Tipos de datos incorrectos
- Campos timestamp
- SoftDeletes
- Integridad referencial

### Debes proponer migraciones correctivas.

---

## 4. SEGURIDAD

Corregir vulnerabilidades:

- SQL Injection
- XSS
- Mass assignment
- CSRF
- Exposición de errores sensibles
- Enumeración de registros
- Rate limiting faltante
- Passwords débiles
- Escalada de privilegios
- IDOR

---

## 5. EXPERIENCIA DE USUARIO

Optimiza:

- Mensajes claros
- Flujo rápido
- Menos clics
- Formularios intuitivos
- Errores entendibles
- Confirmaciones útiles
- Diseño profesional

---

## 6. TESTING OBLIGATORIO

Genera:

### Laravel PHPUnit / Pest:

- Crear registro válido
- Campos faltantes
- Email duplicado si aplica
- Password inválido si aplica
- Update correcto
- Delete correcto
- Unauthorized access

### Vue:

- Render formulario
- Validación frontend
- Submit correcto
- Loading states
- Error API

---

## 7. OUTPUT ESPERADO

Quiero que entregues:

1. Diagnóstico de errores encontrados.
2. Riesgo de cada error.
3. Código corregido completo.
4. Mejoras recomendadas.
5. Refactor profesional.
6. Código listo para producción.

---

## 8. FORMA DE TRABAJO

No expliques teoría innecesaria.

Quiero soluciones directas, código limpio, arquitectura profesional y prevención total de errores futuros.

Analiza todo archivo relacionado aunque no lo mencione:

- routes
- controller
- request
- model
- migration
- vue component
- composables
- store
- api service
- tests

Si detectas malas prácticas, corrígelas automáticamente.

Si algo puede romperse en producción, priorízalo.

Empieza auditando este módulo ahora:
