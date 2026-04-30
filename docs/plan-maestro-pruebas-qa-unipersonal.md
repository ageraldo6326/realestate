# Guia de Demo Segura y Checklist Operativa

Fecha: 2026-04-27  
Version: 2.0  
Objetivo: que una sola persona pueda validar rapido el sistema antes de una demo, evitando errores inesperados frente a clientes.

## Como usar esta guia

1. Corre primero la checklist rapida de 15 minutos.
2. Si la demo es importante, corre tambien la checklist completa de 60 minutos.
3. Si algun punto falla, no improvises en vivo: usa el protocolo de contingencia del final.

Estados para marcar cada item:

- [ ] Pendiente
- [x] OK
- [!] Falla

---

## A. Checklist rapida de 15 minutos (obligatoria antes de demo)

### A1. Acceso y estabilidad minima

- [ ] Puedo entrar con usuario admin.
- [ ] Puedo entrar con usuario asesor.
- [ ] El login no muestra errores raros ni pantalla en blanco.
- [ ] El logout funciona y vuelve al login.

### A2. Frontend publico (cara del cliente)

- [ ] Home carga sin error 500.
- [ ] Listado de propiedades carga y muestra cards.
- [ ] Detalle de una propiedad abre bien (fotos, titulo, precio, contacto).
- [ ] Se ve asesor o contacto comercial en card/detalle.

### A3. Modulo asesor (operacion diaria)

- [ ] Asesor puede ver su dashboard.
- [ ] Asesor puede crear un cliente.
- [ ] Asesor puede crear una tarea.
- [ ] Asesor puede crear o editar una propiedad sin error de validacion inesperado.

### A4. Modulo admin (control del negocio)

- [ ] Admin puede ver listado de usuarios.
- [ ] Admin puede ver listado de propiedades.
- [ ] Admin puede ver propiedades pendientes por aprobacion.
- [ ] Admin puede entrar a configuracion de empresa.

### A5. Regla critica de aprobacion

- [ ] Si empresa requiere aprobacion, una propiedad nueva queda pendiente.
- [ ] Si usuario tiene override sin aprobacion, su propiedad puede salir publicada.

---

## B. Checklist completa de 60 minutos (demo importante)

## B1. Frontend (cliente final)

### Navegacion

- [ ] Home
- [ ] Propiedades
- [ ] Detalle propiedad
- [ ] Equipo
- [ ] Contacto
- [ ] Blog

### Calidad visible

- [ ] No hay textos rotos, variables sin reemplazar o elementos montados.
- [ ] Las imagenes principales cargan correctamente.
- [ ] Los botones clave hacen lo esperado.
- [ ] No hay errores de estilo graves en mobile.

## B2. Asesor (backend asesor)

### Clientes

- [ ] Crear cliente.
- [ ] Editar cliente.
- [ ] Ver cliente en listado.

### Tareas

- [ ] Crear tarea.
- [ ] Cambiar estatus pendiente/completada.

### Propiedades

- [ ] Crear propiedad con portada.
- [ ] Agregar fotos adicionales.
- [ ] Editar propiedad sin perder fotos por validacion.
- [ ] Confirmar que no aparece error SQL por comision.

## B3. Admin (backend admin)

### Usuarios

- [ ] Crear usuario.
- [ ] Editar usuario.
- [ ] Ver opcion de aprobacion por usuario en crear/editar.
- [ ] Confirmar default usuario: no requiere aprobacion.

### Empresa

- [ ] Editar datos de empresa.
- [ ] Ver toggle de aprobacion global.
- [ ] Confirmar default empresa: requiere aprobacion activado.

### Propiedades

- [ ] Ver pendientes por aprobacion.
- [ ] Aprobar una pendiente.
- [ ] Confirmar que aparece en frontend despues de aprobar.
- [ ] Validar slug unico al crear propiedades con titulo repetido.

## B4. Integridad minima de demo

- [ ] /sitemap.xml responde.
- [ ] No hay error 500 en rutas principales.
- [ ] No hay error critico nuevo en logs recientes.

---

## C. Mapa simple de modulos y que validar

| Area     | Modulo                 | Validacion minima                      |
| -------- | ---------------------- | -------------------------------------- |
| Frontend | Home                   | Carga, cards y links principales       |
| Frontend | Listado de propiedades | Filtros/lista responden                |
| Frontend | Detalle propiedad      | Datos, fotos y contacto correctos      |
| Frontend | Paginas informativas   | Equipo, contacto, blog cargan          |
| Asesor   | Dashboard              | Acceso y datos basicos                 |
| Asesor   | Clientes               | Crear/editar/listar                    |
| Asesor   | Tareas                 | Crear y cambiar estado                 |
| Asesor   | Propiedades            | Crear/editar con imagenes              |
| Admin    | Usuarios               | CRUD basico y roles                    |
| Admin    | Empresa                | Configuracion y aprobacion global      |
| Admin    | Propiedades            | Pendientes, aprobacion, publicacion    |
| Admin    | Catalogos              | Zonas, estados, tipos, disponible para |

---

## D. Señales de riesgo (cancelar demo tecnica o cambiar guion)

Si pasa alguno de estos puntos, evita una demo tecnica profunda y usa guion corto:

- [!] Error 500 en Home, listado o detalle de propiedad.
- [!] No se puede crear propiedad.
- [!] No se puede iniciar sesion con admin.
- [!] Se rompen imagenes principales.
- [!] Fallan reglas de aprobacion (publica lo que no debe o viceversa).

---

## E. Protocolo de contingencia para demo en vivo

## E1. Si algo falla frente al cliente

1. No depures en vivo.
2. Cambia al flujo funcional que si esta estable (frontend o dashboard de solo lectura).
3. Usa un registro ya creado para mostrar resultado final.
4. Comunica: "Mostrare el flujo estable y dejamos esta parte para entorno de QA".

## E2. Guion de respaldo recomendado

- Mostrar Home + listados + detalle.
- Entrar admin solo a vistas de listado.
- Mostrar una propiedad ya aprobada.
- Mostrar dashboard y reportes sin editar datos en vivo.

---

## F. Plantilla de registro de corrida (copiar y pegar)

Fecha:
Responsable:
Tipo de corrida: Rapida 15 min / Completa 60 min
Resultado general: OK / Con riesgo / No apta para demo

Hallazgos:

-   1.
-   2.
-   3.

Decision final:

- [ ] Demo aprobada
- [ ] Demo aprobada con guion limitado
- [ ] Demo no aprobada
