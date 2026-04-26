---
applyTo: "app/**/*.php,routes/**/*.php,config/**/*.php,database/**/*.php,tests/**/*.php"
description: "Estandares backend Laravel para robustez, seguridad y mantenibilidad del CRM inmobiliario."
---

Cuando trabajes en backend Laravel:

Arquitectura y dominio:

- Mantiene controladores delgados.
- Extrae reglas de negocio a Services o Actions si superan complejidad media.
- Usa Form Requests para validacion.
- Usa Policies y Gates para autorizacion por recurso.

Datos y BD:

- Disena migraciones seguras y reversibles.
- Usa indices en columnas de busqueda y filtro frecuentes.
- Evita N+1 con eager loading.
- Usa transacciones en operaciones criticas.

Errores y seguridad:

- Maneja errores de forma explicita y con logs utiles.
- No expongas informacion sensible en respuestas.
- Sanitiza y valida entradas siempre.
- Considera rate limiting en endpoints sensibles.

Estilo de codigo:

- Usa nombres expresivos en clases, metodos y variables.
- Mantiene metodos cortos y con responsabilidad unica.
- Reduce condicionales anidadas complejas.
- Evita logica de negocio en helpers globales.

Testing recomendado:

- Cubre casos felices, errores y casos limite.
- Prioriza pruebas de integracion para flujos criticos del CRM (clientes, propiedades, estados, notificaciones).
- Anade prueba de regresion cuando se corrige un bug.
