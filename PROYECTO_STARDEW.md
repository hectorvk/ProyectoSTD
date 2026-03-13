# Proyecto Stardew — Documentación Técnica

---

## Tabla de Contenidos

1. [Introducción](#1-introducción)
2. [Necesidades del Sector Productivo](#2-necesidades-del-sector-productivo)
   - 2.1 [Análisis de la situación actual](#21-análisis-de-la-situación-actual)
   - 2.2 [Necesidades del cliente y oportunidad de negocio](#22-necesidades-del-cliente-y-oportunidad-de-negocio)
   - 2.3 [El nuevo proyecto: Stardew Farm Planner](#23-el-nuevo-proyecto-stardew-farm-planner)
3. [Diseño del Proyecto](#3-diseño-del-proyecto)
   - 3.1 [Fases del proyecto](#31-fases-del-proyecto)
   - 3.2 [Objetivos a conseguir](#32-objetivos-a-conseguir)
   - 3.3 [Previsión de recursos materiales y humanos necesarios](#33-previsión-de-recursos-materiales-y-humanos-necesarios)
   - 3.4 [Presupuesto económico](#34-presupuesto-económico)
4. [Planificación de la Ejecución del Proyecto](#4-planificación-de-la-ejecución-del-proyecto)
   - 4.1 [Fase de Análisis](#41-fase-de-análisis)
   - 4.2 [Fase de Diseño](#42-fase-de-diseño)
   - 4.3 [Fase de Implementación](#43-fase-de-implementación)
   - 4.4 [Fase de Pruebas](#44-fase-de-pruebas)
5. [Definición de Procedimientos de Control y Evaluación](#5-definición-de-procedimientos-de-control-y-evaluación)
6. [Fuentes](#6-fuentes)
7. [Anexos](#7-anexos)
   - 7.1 [Guía de estilo](#71-guía-de-estilo)

---

## 1 INTRODUCCIÓN

**Stardew Farm Planner** es una aplicación web desarrollada como proyecto de fin de ciclo del Grado Superior de Desarrollo de Aplicaciones Multiplataforma (DAM2V) por Héctor y Gonzalo.

La aplicación está orientada a los jugadores del videojuego *Stardew Valley*, un simulador de granja de rol independiente con millones de usuarios activos a nivel mundial. El objetivo es proporcionar una herramienta online que permita planificar, calcular y optimizar las decisiones dentro del juego: desde la rentabilidad de cultivos hasta los recursos necesarios para construir edificios en la granja.

El proyecto abarca el ciclo completo de desarrollo de software: análisis de requisitos, diseño de base de datos y arquitectura, implementación full-stack con PHP + MySQL en el backend y HTML/CSS/JavaScript en el frontend, y validación funcional de cada módulo.

La aplicación incluye:

- **Calculadora de cultivos**: calcula beneficio neto, inversión, ingresos y rendimiento por día según temporada, día de siembra y cantidad de semillas.
- **Calculadora de edificios**: calcula el coste total en materiales y oro para construir uno o varios edificios.
- **Catálogo de personajes (NPCs)**: muestra información de los 34 aldeanos del juego (cumpleaños, regalos, estado de soltería).
- **Catálogo de materiales**: describe los 34+ materiales del juego con fuente, precio y descripción.
- **Panel de administración**: CRUD completo de edificios con gestión de costes y materiales.
- **Autenticación y autorización**: sistema de login con roles (admin / normal) y gestión de sesiones segura.

---

## 2 NECESIDADES DEL SECTOR PRODUCTIVO

### 2.1 Análisis de la situación actual

El videojuego *Stardew Valley* cuenta con una comunidad activa de más de 30 millones de jugadores. La gestión óptima de la granja requiere cálculos complejos: cuántos cultivos plantar, cuándo hacerlo según la temporada (28 días por estación), qué edificios construir y cuántos recursos acumular.

Actualmente los jugadores recurren a:
- Wikis generales (Stardew Valley Wiki) con información estática y sin personalización.
- Hojas de cálculo manuales en Excel/Google Sheets.
- Herramientas dispersas de terceros con interfaces poco amigables o desactualizadas.

Ninguna de estas soluciones integra en un mismo espacio el cálculo de rentabilidad de cultivos, la planificación de construcciones y la consulta de personajes con una interfaz temática coherente.

### 2.2 Necesidades del cliente y oportunidad de negocio

El perfil del usuario objetivo es un jugador de *Stardew Valley* con interés en optimizar su partida. Sus necesidades principales son:

| Necesidad | Solución aportada |
|---|---|
| Calcular qué cultivo es más rentable en una temporada dada | Calculadora de cultivos con datos de las 38 semillas de la BD |
| Saber cuántos materiales necesita para construir edificios | Calculadora de edificios con desglose por material |
| Consultar los gustos y cumpleaños de los aldeanos | Catálogo de 34 personajes con regalos amados/odiados |
| Gestionar el contenido de la aplicación sin tocar código | Panel de administración con CRUD completo |

La oportunidad de negocio reside en ofrecer una plataforma centralizada, con diseño temático atractivo y funcionalidades de usuario registrado, susceptible de monetización mediante suscripciones premium, publicidad o contenido exclusivo.

### 2.3 El nuevo proyecto: Stardew Farm Planner

**Nombre del proyecto:** Stardew Farm Planner — *Proyecto Stardew*

**Descripción:** Aplicación web full-stack de planificación de granja para *Stardew Valley*. Permite a usuarios registrados calcular la rentabilidad de cultivos y el coste de construcciones, consultar información de personajes y materiales, y a administradores gestionar el contenido de la base de datos mediante un panel dedicado.

**Tecnología:**
- Backend: PHP 8.2.12 + MySQL/MariaDB 10.4.32 (compatible con PlanetScale en la nube)
- Frontend: HTML5 + CSS3 + JavaScript (vanilla) + Bootstrap 5.3.2
- API REST interna en PHP con respuestas JSON
- Node.js / Express 5.2.1 para futuras integraciones (asesor IA con OpenAI API)

**Alcance del MVP:**
- Módulo de autenticación con roles
- Calculadora de cultivos (38 cultivos, 6 temporadas)
- Calculadora de edificios (24 tipos de construcción)
- Catálogo de personajes (34 NPCs)
- Catálogo de materiales (34+ items)
- Panel de administración de edificios

---

## 3 DISEÑO DEL PROYECTO

### 3.1 Fases del proyecto

#### 3.1.1 Análisis

Se realizó un análisis de los requisitos funcionales y no funcionales a partir de las necesidades identificadas:

**Requisitos funcionales:**
- RF-01: El sistema permitirá el registro e inicio de sesión de usuarios.
- RF-02: El sistema diferenciará entre usuarios con rol `normal` y rol `admin`.
- RF-03: El usuario podrá seleccionar un cultivo, indicar el día de siembra y la cantidad de semillas para obtener el beneficio estimado.
- RF-04: El usuario podrá seleccionar un edificio e indicar la cantidad para obtener el desglose de materiales y coste en oro.
- RF-05: El sistema mostrará el catálogo completo de personajes con sus preferencias y cumpleaños.
- RF-06: El sistema mostrará el catálogo de materiales con fuente, precio y descripción.
- RF-07: El administrador podrá crear, leer, actualizar y eliminar edificios desde el panel de administración.
- RF-08: El usuario podrá cambiar su contraseña y datos de perfil.

**Requisitos no funcionales:**
- RNF-01: Las contraseñas se almacenarán con hash bcrypt.
- RNF-02: Todas las consultas a la base de datos usarán sentencias preparadas (PDO).
- RNF-03: Las salidas HTML se escaparán con `htmlspecialchars()` para prevenir XSS.
- RNF-04: La interfaz será responsiva y funcional en dispositivos móviles y escritorio.
- RNF-05: Los tiempos de respuesta de la API serán inferiores a 500 ms en condiciones normales.

**Modelo Entidad-Relación (tablas principales):**

```
usuarios        (id, username, password, rol, fecha_registro)
cultivos        (id, nombre, precio_semilla, precio_venta, tiempo_crecimiento, tiempo_regreso, temporada)
edificios       (id, nombre, tiempo_construccion, coste_oro, madera, piedra, madera_noble, fibra, arcilla,
                 lingotes_cobre, lingotes_hierro, lingotes_iridio, cuarzo_refinado, otros_materiales)
ganado          (id, nombre, edificio_requerido, precio_compra, producto_nombre, precio_producto)
personajes      (id, nombre, temporada_cumpleanos, dia_cumpleanos, es_soltero, regalos_amados, regalos_odiados, imagen_url)
materiales      (id, nombre, fuente, precio_venta, descripcion)
```

#### 3.1.2 Diseño

**Arquitectura de la aplicación:**

Se optó por una arquitectura MVC simplificada sobre PHP nativo:

```
┌─────────────────────────────────────────────────────┐
│                     CLIENTE (Browser)                │
│  HTML5 + CSS3 + JavaScript (vanilla) + Bootstrap     │
└──────────────────┬──────────────────────────────────┘
                   │ HTTP / AJAX (JSON)
┌──────────────────▼──────────────────────────────────┐
│                  PHP BACKEND                         │
│  Páginas PHP (vistas + controladores)               │
│  API REST: /api/get_cultivos.php                    │
│            /api/get_edificios.php                   │
│  Auth: comprobarLogin.php / hasLogin.php            │
└──────────────────┬──────────────────────────────────┘
                   │ PDO / mysqli
┌──────────────────▼──────────────────────────────────┐
│            MySQL / MariaDB (local o PlanetScale)     │
│  Base de datos: proyectostardew                     │
└─────────────────────────────────────────────────────┘
```

**Diseño visual:**

La interfaz sigue la estética pixel-art de *Stardew Valley*:
- Tipografía personalizada: fuente `StardewValley` (TTF).
- Paleta cromática definida en variables CSS (verde bosque, pergamino, madera oscura).
- Fondos degradados cielo/hierba y contenedores con bordes textura madera.
- Diseño responsivo con Bootstrap Grid.

**Estructura de archivos:**

```
std sge/
├── api/                     ← Endpoints REST JSON
│   ├── conexion.php
│   ├── get_cultivos.php
│   └── get_edificios.php
├── css/                     ← Hojas de estilo por módulo
├── js/                      ← Lógica cliente (calculadoras, validaciones)
├── src/                     ← Imágenes de la UI
├── imagenes/                ← Imágenes de personajes
├── recursos/                ← Fuentes tipográficas
├── SQL/                     ← Scripts de base de datos
└── *.php                    ← Páginas y controladores raíz
```

#### 3.1.3 Implementación

La implementación se estructuró en los siguientes módulos:

**Módulo de autenticación**
- `index.php` / `comprobarLoginProyectoStardew.php` — login con `password_verify()` y regeneración de sesión.
- `registro.php` / `guardar_usuario.php` — registro con `password_hash()` bcrypt.
- `hasLoginProyectoStardew.php` / `hasAdminProyectoStardew.php` — guards de acceso por rol.
- `logout.php` — destrucción segura de sesión.

**Módulo calculadora de cultivos**
- API `get_cultivos.php` devuelve JSON con los 38 cultivos.
- `calculadora.js` consume la API, calcula cosecha, inversión, ingresos brutos, beneficio neto y ratio oro/día.
- Soporte para cultivos con mecánica de rebrote (`tiempo_regreso`).
- Fórmulas principales:
  ```
  cosechas = Math.floor((diasRestantes - tiempoCrecimiento) / tiempoRegreso) + 1
  beneficioNeto = (cosechas × precioVenta × cantidad) - (precioSemilla × cantidad)
  ```

**Módulo calculadora de edificios**
- API `get_edificios.php` devuelve JSON con los 24 edificios y sus materiales.
- `calculadoraEdificios.js` calcula el total de materiales multiplicando por cantidad.
- Filtrado de materiales con valor 0 para evitar ruido visual.
- Soporte para campo `otros_materiales` con materiales personalizados del administrador.

**Módulo catálogo de personajes**
- `personajes.php` consulta la tabla `personajes` (34 registros) y renderiza tarjetas con imagen, cumpleaños, regalos y estado.

**Módulo catálogo de materiales**
- `materiales.php` consulta la tabla `materiales` (34+ registros) y renderiza tabla con fuente, precio y descripción.

**Panel de administración**
- `admin.php` — vista CRUD de edificios.
- `procesarEdificio.php` — controlador de inserción/actualización.
- `editarEdificio.php` — formulario de edición precargado.
- `borrarEdificio.php` — eliminación con confirmación JS previa.

**Gestión de perfil de usuario**
- `perfil.php` — vista del perfil con nombre de usuario, rol y fecha de registro.
- `cambiarContrasena.php` / `procesarContrasena.php` — cambio de contraseña con verificación de la actual.

#### 3.1.4 Pruebas

No se implementó un framework de testing automatizado formal. La estrategia de validación adoptada fue:

**Validación cliente (JavaScript — `validaciones.js`):**
- Comprobación de campos obligatorios en formularios.
- Verificación de rangos numéricos (día de siembra: 1-28).
- Mensajes de error inline antes del envío.

**Validación servidor (PHP):**
- `guardar_usuario.php`: validación de longitud de username y contraseña, unicidad.
- `comprobarLoginProyectoStardew.php`: verificación de credenciales sin enumerar usuarios.
- `procesarEdificio.php`: comprobación de campos requeridos (nombre, tiempo, coste).
- Respuestas HTTP con códigos de estado apropiados (500 en errores de BD).

**Pruebas manuales realizadas:**
- Flujo completo de registro → login → calculadora → logout.
- Intentos de acceso a rutas protegidas sin sesión activa.
- CRUD completo de edificios desde el panel de administración.
- Verificación de cálculos de cultivos y edificios con datos conocidos del juego.
- Prueba de conexión tanto en entorno local (XAMPP) como en la nube (PlanetScale).

---

### 3.2 Objetivos a conseguir

| # | Objetivo | Indicador de éxito |
|---|---|---|
| O-01 | Sistema de autenticación seguro con roles | Login funcional, hash bcrypt, guards por rol |
| O-02 | Calculadora de cultivos precisa | Resultados coinciden con los valores reales del juego |
| O-03 | Calculadora de edificios con desglose de materiales | Muestra todos los materiales necesarios correctamente |
| O-04 | Catálogo de 34 personajes navegable | Muestra imagen, cumpleaños y preferencias de cada NPC |
| O-05 | Catálogo de materiales completo | 34+ materiales con fuente, precio y descripción |
| O-06 | Panel de administración funcional | CRUD de edificios operativo solo para rol admin |
| O-07 | Seguridad ante inyección SQL y XSS | Uso de PDO preparado y `htmlspecialchars()` en toda salida |
| O-08 | Compatibilidad local y nube | Conexión funcional en XAMPP y PlanetScale/Railway |

### 3.3 Previsión de recursos materiales y humanos necesarios

**Recursos humanos:**

| Persona | Rol | Responsabilidades |
|---|---|---|
| Héctor | Desarrollador Full-Stack | Backend PHP, base de datos, API REST, seguridad |
| Gonzalo | Desarrollador Full-Stack | Frontend HTML/CSS/JS, calculadoras, diseño visual |

**Recursos materiales:**

| Recurso | Descripción | Coste |
|---|---|---|
| Equipos de desarrollo | 2 ordenadores con Windows 11 | Hardware propio |
| XAMPP 8.2 | Entorno local PHP + MySQL | Gratuito (open source) |
| MySQL/MariaDB 10.4 | Base de datos relacional | Gratuito (incluido en XAMPP) |
| PlanetScale | BD MySQL en la nube (plan gratuito) | 0 € (plan Hobby) |
| Railway | Hosting web en la nube (plan gratuito) | 0 € (plan Starter) |
| Visual Studio Code | IDE de desarrollo | Gratuito |
| Bootstrap 5.3.2 | Framework CSS | Gratuito (CDN) |
| Node.js / Express | Entorno para futura integración IA | Gratuito |
| OpenAI API | Futura funcionalidad Asesor IA | Por uso (pay-as-you-go) |
| GitHub | Control de versiones | Gratuito |

**Coste de infraestructura estimado:** 0 € para el MVP (uso de planes gratuitos).

### 3.4 Presupuesto económico

**Desglose de costes:**

| Concepto | Detalle | Coste estimado |
|---|---|---|
| Desarrollo (horas/persona) | 2 desarrolladores × ~120 h × 15 €/h | 3.600 € |
| Infraestructura cloud (año 1) | PlanetScale Hobby + Railway Starter | 0 € |
| Dominio web (año 1) | p. ej. stardewplanner.com | ~12 € |
| Fuente tipográfica StardewValley | Fan-made, uso no comercial | 0 € |
| Activos visuales (imágenes del juego) | Uso educativo/fan project | 0 € |
| **Total MVP** | | **~3.612 €** |

> Nota: el presupuesto de desarrollo refleja el coste de oportunidad del tiempo invertido. Al tratarse de un proyecto educativo, no existe coste monetario real para el equipo de desarrollo.

**Modelo de monetización futuro (post-MVP):**
- Plan Premium con funcionalidades avanzadas (planificador anual, sincronización de partidas).
- Integración del Asesor IA (coste variable con OpenAI API).
- Publicidad no intrusiva para usuarios del plan gratuito.

---

## 4 PLANIFICACIÓN DE LA EJECUCIÓN DEL PROYECTO

### 4.1 Fase de Análisis

**Duración estimada:** 2 semanas

**Tareas:**
1. Definición del alcance del proyecto y selección de funcionalidades del MVP.
2. Estudio del dominio: mecánicas de *Stardew Valley* (temporadas, cultivos, edificios, personajes).
3. Recogida de datos: precios de semillas, tiempos de crecimiento, costes de edificios, materiales, datos de personajes.
4. Definición de los requisitos funcionales (RF-01 a RF-08) y no funcionales (RNF-01 a RNF-05).
5. Diseño del modelo de datos (6 tablas: usuarios, cultivos, edificios, ganado, personajes, materiales).
6. Definición de la arquitectura tecnológica (PHP + MySQL + JS + Bootstrap).

**Entregables:**
- Documento de requisitos.
- Diagrama E-R de la base de datos.
- Scripts SQL iniciales (`proyectostardew.sql`).

### 4.2 Fase de Diseño

**Duración estimada:** 2 semanas

**Tareas:**
1. Diseño de la paleta de colores y guía de estilo visual basada en Stardew Valley.
2. Selección e integración de la fuente personalizada `StardewValley` (TTF).
3. Definición de variables CSS (`--primary-green`, `--parchment`, `--dark-wood`, etc.).
4. Diseño de wireframes para cada página: login, registro, calculadoras, catálogos, admin, perfil.
5. Definición de la estructura de archivos y convenciones de nombrado.
6. Diseño de los endpoints de la API REST (`/api/get_cultivos.php`, `/api/get_edificios.php`).
7. Diseño del flujo de autenticación y guards de sesión.

**Entregables:**
- Guía de estilo (colores, tipografía, componentes).
- Wireframes de todas las páginas.
- Definición de la estructura de carpetas del proyecto.

### 4.3 Fase de Implementación

**Duración estimada:** 6 semanas

**Semana 1-2 — Base del proyecto:**
- Creación de la base de datos con las 6 tablas y datos iniciales.
- Implementación del sistema de autenticación: registro, login, logout, guards.
- Creación del layout base (navbar, estilos globales, fuente personalizada).
- Módulo `conexion.php` con soporte dual local/PlanetScale.

**Semana 3-4 — Calculadoras:**
- Endpoints API: `get_cultivos.php` y `get_edificios.php`.
- `calculadora.js`: lógica de cálculo de rentabilidad con soporte de rebrote.
- `calculadoraEdificios.js`: lógica de desglose de materiales por cantidad.
- Páginas PHP: `calculadoraCultivos.php`, `calculadoraEdificios.php`.

**Semana 5 — Catálogos y perfil:**
- `personajes.php`: catálogo de 34 NPCs con imagen y datos.
- `materiales.php`: tabla de 34+ materiales.
- `perfil.php`, `cambiarContrasena.php`, `procesarContrasena.php`.

**Semana 6 — Panel de administración y ajustes finales:**
- `admin.php`, `procesarEdificio.php`, `editarEdificio.php`, `borrarEdificio.php`.
- Ajustes de seguridad: `htmlspecialchars()`, prepared statements, validaciones.
- Pruebas de integración y corrección de errores.
- Configuración de `.env.example` y `.gitignore`.

### 4.4 Fase de Pruebas

**Duración estimada:** 1 semana

**Plan de pruebas:**

| ID | Caso de prueba | Tipo | Resultado esperado |
|---|---|---|---|
| PT-01 | Registro con username duplicado | Funcional | Mensaje de error, no crea usuario |
| PT-02 | Login con credenciales incorrectas | Seguridad | Mensaje genérico sin enumerar usuario/contraseña |
| PT-03 | Acceso a `/admin.php` sin sesión | Seguridad | Redirección al login |
| PT-04 | Acceso a `/admin.php` con rol `normal` | Autorización | Redirección / página de error |
| PT-05 | Calculadora cultivos: Parsnip en Primavera día 1 | Funcional | Resultado coherente con wiki oficial |
| PT-06 | Calculadora edificios: 3 Gallineros | Funcional | Materiales = 3 × coste unitario |
| PT-07 | Eliminar edificio sin confirmación JS | UX | Modal de confirmación aparece |
| PT-08 | Formulario login con campos vacíos | Validación | Error cliente antes de envío |
| PT-09 | Inyección SQL en campo username | Seguridad | PDO preparado lo neutraliza |
| PT-10 | Conexión a PlanetScale (cloud) | Integración | BD accesible con SSL |

**Correcciones post-pruebas:**
- Ajuste de fórmulas de cálculo con casos límite (día 28, cultivos sin rebrote).
- Revisión de escapado HTML en campos de texto libre.
- Verificación de que todos los guards de sesión están presentes en cada página protegida.

---

## 5 DEFINICIÓN DE PROCEDIMIENTOS DE CONTROL Y EVALUACIÓN

### Control de calidad del código

- **Revisión por pares:** cada módulo implementado por un desarrollador es revisado por el otro antes de integrarse.
- **Convenciones de código:** nombrado en español para variables de dominio, camelCase para JavaScript, snake_case para PHP y SQL.
- **Seguridad:** checklist de seguridad aplicado en cada módulo:
  - [ ] Sentencias preparadas PDO en todas las consultas.
  - [ ] `htmlspecialchars()` en toda salida de datos de usuario.
  - [ ] Guard de sesión al inicio de cada página protegida.
  - [ ] Hash bcrypt en almacenamiento y verificación de contraseñas.

### Control de versiones

- Repositorio Git con ramas por funcionalidad.
- `.gitignore` configurado para excluir `.env`, `node_modules/`, SQL con datos sensibles y `generar_admin.php`.
- Commits descriptivos por módulo.

### Criterios de evaluación del proyecto

| Criterio | Peso | Indicador |
|---|---|---|
| Funcionalidad completa del MVP | 40 % | Los 8 requisitos funcionales están implementados |
| Seguridad | 20 % | 5 requisitos no funcionales de seguridad cumplidos |
| Calidad del código | 15 % | Código limpio, sin duplicaciones innecesarias, comentado |
| Diseño e interfaz | 15 % | UI responsiva, coherente con la temática, intuitiva |
| Documentación | 10 % | Presente y completa |

### Seguimiento del proyecto

- Reuniones semanales de seguimiento entre los dos desarrolladores.
- Actualización del estado de tareas por módulo.
- Registro de bugs encontrados y su resolución.

---

## 6 FUENTES

- **Stardew Valley Wiki** — Datos de cultivos, edificios, personajes y materiales del juego:
  `https://stardewvalleywiki.com`

- **PHP Documentation** — Referencia oficial de PHP 8.2:
  `https://www.php.net/docs.php`

- **PDO Documentation** — PHP Data Objects:
  `https://www.php.net/manual/es/book.pdo.php`

- **Bootstrap 5.3** — Framework CSS:
  `https://getbootstrap.com/docs/5.3`

- **MDN Web Docs** — Referencia HTML5, CSS3 y JavaScript:
  `https://developer.mozilla.org`

- **PlanetScale Documentation** — MySQL serverless en la nube:
  `https://planetscale.com/docs`

- **XAMPP** — Entorno de desarrollo local PHP + MySQL:
  `https://www.apachefriends.org`

- **OWASP Top 10** — Guía de seguridad para aplicaciones web:
  `https://owasp.org/www-project-top-ten/`

- **OpenAI API Documentation** — Para la futura integración del Asesor IA:
  `https://platform.openai.com/docs`

---

## 7 ANEXOS

### 7.1 Guía de Estilo

#### Paleta de colores

| Nombre | Variable CSS | Valor HEX | Uso |
|---|---|---|---|
| Verde bosque | `--primary-green` | `#228b22` | Botones principales, acentos |
| Pergamino | `--parchment` | `#f4e4bc` | Fondos de contenedores |
| Madera oscura | `--dark-wood` | `#3a2010` | Bordes, navbar |
| Madera clara | `--light-wood` | `#8b4513` | Textos de encabezado |
| Cielo | — | `#87ceeb` | Fondo degradado superior |
| Hierba | — | `#90ee90` | Fondo degradado inferior |

#### Tipografía

| Elemento | Fuente | Tamaño |
|---|---|---|
| Títulos principales (h1) | StardewValley (TTF) | 2.5 rem |
| Subtítulos (h2, h3) | StardewValley (TTF) | 1.5–2 rem |
| Texto de cuerpo | StardewValley (TTF) | 1 rem |
| Texto de tablas | StardewValley (TTF) | 0.9 rem |

La fuente `StardewValley.ttf` se carga localmente desde `/recursos/StardewValley.ttf` mediante `@font-face`.

#### Componentes UI

**Contenedor principal:**
```css
background-color: var(--parchment);       /* Fondo pergamino */
border: 3px solid var(--dark-wood);        /* Borde madera */
border-radius: 8px;
box-shadow: 4px 4px 0px var(--dark-wood); /* Sombra estilo pixel */
```

**Botón primario:**
```css
background-color: var(--primary-green);
color: white;
border: 2px solid var(--dark-wood);
font-family: 'StardewValley', sans-serif;
```

**Fondo de página:**
```css
background: linear-gradient(to bottom, #87ceeb, #90ee90);
min-height: 100vh;
```

#### Convenciones de nomenclatura

| Ámbito | Convención | Ejemplo |
|---|---|---|
| Variables PHP | camelCase | `$precioSemilla` |
| Variables JavaScript | camelCase | `bdCultivos`, `catalogoEdificios` |
| Tablas SQL | snake_case plural | `cultivos`, `edificios`, `personajes` |
| Columnas SQL | snake_case | `precio_semilla`, `tiempo_crecimiento` |
| Archivos PHP | camelCase descriptivo | `calculadoraCultivos.php` |
| Archivos CSS | camelCase descriptivo | `estilosProyectoStardew.css` |
| Archivos JS | camelCase descriptivo | `calculadoraEdificios.js` |

#### Estructura de páginas PHP

Todas las páginas protegidas siguen este patrón:

```php
<?php
session_start();
require_once 'hasLoginProyectoStardew.php';  // Guard de sesión
// ... lógica de la página ...
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <!-- Contenido -->
</body>
</html>
```

---

*Documento generado a partir del análisis del código fuente del proyecto — DAM2V*
