# Auditoría: señales de generación por IA
**Proyecto:** Stardew Farm Planner
**Fecha:** 2026-03-12
**Archivos analizados:** PHP, JS, CSS, HTML, SQL

---

## Índice de criticidad

| Nivel | Hallazgos |
|---|---|
| CRÍTICO | 4 |
| ALTO | 5 |
| MEDIO | 3 |

---

## CRÍTICO

### 1. Comentario que explicita "toque humano"

**`stdStilo.css` línea 31**
```css
transform: rotate(-1deg); /* Toque humano: imperfección visual */
```
Una IA que recibe la instrucción "humaniza el código" a veces deja rastro textual de esa instrucción dentro del propio output. Este es el ejemplo más directo del proyecto. Un desarrollador humano simplemente escribiría `rotate(-1deg)` sin necesidad de justificarlo.

---

### 2. Funciones con nombres narrativos de roleplay

**`motorAD.js` líneas 22, 28, 38–50**
```javascript
prepararEscena();
escribirEfectoTeletipo(respuestaRaw);
llamarAlOraculoReal(preguntaUsuario);
```
Y el objeto de configuración global:
```javascript
const OraculoConfig = { ... }
```
Ningún desarrollador humano nombra sus funciones como si fueran actos de teatro. Es un patrón típico de IA que, al generar código temático, extiende la metáfora al naming.

---

### 3. UI text poético en interfaces funcionales

**`tablonProyectoStardew.php` líneas 47 y 79**
```html
<p class="text-muted">Buscando cartas en el buzón...</p>
<p class="text-muted m-0">El aire se siente cargado de magia... pregunta algo.</p>
```
**`motorAD.js` línea 49**
```javascript
}, 30); // Velocidad de escritura humana
```
**`BannerSteam.html` línea 98**
```javascript
throw new Error("Parece que el servidor de Pierre está cerrado (Error de red).");
```
**`BannerSteam.html` línea 102**
```javascript
throw new Error("El cartero se perdió en el bosque.");
```
Los mensajes de error y los textos de carga están escritos como narrativa de Stardew Valley, incluyendo errores técnicos que un desarrollador real dejaría en inglés plano o con códigos HTTP.

---

### 4. Comentarios que justifican decisiones arquitectónicas

Este es el patrón más extendido. Una IA generadora de código explica *por qué* tomó cada decisión; un humano escribe código y raramente lo justifica en el mismo commit.

**`js/calculadora.js` líneas 10, 18, 32**
```javascript
// r.ok false aquí es casi siempre un 500 del servidor, no un fallo de red
// BD vacía es válido técnicamente pero raro — significa que el admin limpió la tabla
// No lanzamos alert() — en producción sería molesto. Console es suficiente en dev
```
**`js/calculadora.js` líneas 55–57**
```javascript
// rendimiento_por_cosecha no existe en el schema actual — fallback a 1
// cuando se añada la columna, este || 1 lo recoge sin tocar nada más
const rendimientoCosecha = parseFloat(cultivoTarget.rendimiento_por_cosecha) || 1;
```
**`comprobarLoginProyectoStardew.php` líneas 5, 14, 22**
```php
// Versiones anteriores duplicaban el PDO lo que generaba conflictos de charset en sesión
// password_verify es timing-safe; nunca comparar hashes con === directamente
// No especificamos si falló usuario o contraseña — prevención de user enumeration
```
**`guardar_usuario.php` líneas 14–15**
```php
// Verificamos duplicado ANTES de hashear — bcrypt es costoso y no tiene sentido calcularlo
// si el username ya existe en BD
```
**`procesarEdificio.php` líneas 10–11**
```php
// Estas columnas van 1:1 con la tabla edificios en BD
// Si se añade una columna nueva, se añade aquí y el bind dinámico de abajo la recoge solo
```

---

## ALTO

### 5. Separadores decorativos uniformes en todos los archivos JS

**`tablonProyectoStardew.php` líneas 106, 176, 258**
```javascript
// ── Noticias de Steam ──────────────────────────────────────────
// ── Oráculo / chat IA ──────────────────────────────────────────
// ── Arranque ──────────────────────────────────────────────────
```
**`tablon.css` líneas 23 y 71**
```css
/* ─── Tarjetas de noticias de Steam ─── */
/* ─── Sección del oráculo (chat IA) ─── */
```
Este patrón de separadores con em-dashes (`─`, `═`) aparece consistentemente en proyectos generados por Claude y GPT-4. Un humano cansado usa `//---` o simplemente no pone separadores.

---

### 6. CSS perfectamente sectionado con comentarios en proyecto pequeño

**`estilosProyectoStardew.css`** tiene 13 secciones comentadas:
```css
/*Contenedores centrales*/
/*Títulos*/
/*Labels e Inputs*/
/* Botones*/
/*Navegación principal*/
/*Paneles de calculadoras / GIFs*/
/* Personajes*/
/*Edificios */
/* Tarjetas y nav-index*/
/*Footer general */
/* Diseño Responsive*/
/* Fondo de la tabla y bordes generales */
```
La inconsistencia en el espacio después de `/*` (a veces hay, a veces no) sugiere múltiples sesiones de generación, no un humano con criterio propio.

**`tablon.css` líneas 1–4**
```css
/* tablon.css
   Estilos propios de la página tablonProyectoStardew.php
   Depende de: estilosProyectoStardew.css, stdStilo.css
*/
```
Documentar dependencias de CSS en el propio archivo es práctica de IA documental, no de estudiante.

---

### 7. HTML semántico avanzado inconsistente con el resto del nivel

**`tablonProyectoStardew.php`**
```html
<section class="tablon-pierre-wrapper mb-5">
<article class="tarjeta-noticia h-100 shadow-sm d-flex flex-column">
<a href="${noticia.link}" target="_blank" rel="noopener"
<div class="spinner-grow spinner-noticias" role="status"></div>
```
Uso correcto de `<section>`, `<article>`, `rel="noopener"` en `target="_blank"` y `role="status"` para accesibilidad. Son buenas prácticas que un estudiante no aplica de forma consistente por sí solo; las aplica si un LLM genera el HTML.

---

### 8. Naming temático coherente en todo el proyecto

Variables y funciones en distintos archivos mantienen una coherencia narrativa imposible de sostener en sesiones de trabajo humanas dispersas:

| Archivo | Nombre | Observación |
|---|---|---|
| `motorAD.js` | `OraculoConfig` | Temático |
| `motorAD.js` | `prepararEscena` | Teatral |
| `motorAD.js` | `escribirEfectoTeletipo` | Descriptivo-poético |
| `BannerSteam.html` | `pedirUpdate` | "para evitar patrones repetitivos que detectan algoritmos de IA" — el propio comentario lo dice |
| `BannerSteam.html` | `dibujarNoticias` | Artístico |
| `BannerSteam.html` | `pizarra`, `cartas`, `noticiasFrescas` | Metáfora extendida |
| `BannerSteam.html` | `fechaReal` | Redundante pero explicativo |

**`BannerSteam.html` línea 83–86** — el comentario más revelador del proyecto:
```javascript
/**
 * He decidido llamar a la función 'pedirUpdate' en lugar de 'fetchNews'
 * para evitar patrones repetitivos que detectan los algoritmos de IA.
 */
```
Una IA intentando ocultar que es IA, documentando ese intento dentro del código.

---

### 9. Código boilerplate profesional mezclado con errores básicos

**`DBProyectoStardew.php` líneas 7–12** — SSL condicional para PlanetScale:
```php
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
if (strpos($servername, 'psdb.cloud') !== false) {
    $options[PDO::MYSQL_ATTR_SSL_CA] = '/etc/ssl/certs/ca-bundle.crt';
    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
}
```
**`procesarEdificio.php` línea 38** — arrow function para SQL dinámico:
```php
$clausulasSet = array_map(fn($c) => "$c = :$c", $columnasBD);
```

Pero en el mismo proyecto:

**`isAdminProyectoStardew.php` línea 3** — comparación débil:
```php
if($_SESSION["rol"] != "admin")  // debería ser !==
```
**`js/validaciones.js`** — uso de `alert()` para validación en lugar de feedback en DOM.

La coexistencia de técnicas avanzadas (PDO con SSL, arrow functions, password_hash, timing-safe comparison) con errores de principiante sugiere generación por IA con distintos prompts, sin revisión humana unificada.

---

## MEDIO

### 10. JSDoc en archivo de 70 líneas

**`motorAD.js` líneas 1–4**
```javascript
/**
 * motor-logico.js
 * Gestiona el flujo de datos entre la UI y la API de OpenAI
 */
```
JSDoc para un archivo que no exporta nada ni tiene API pública. Es documentación generada por reflejo, no por necesidad.

---

### 11. Comentarios que documentan compatibilidad futura

**`api/get_cultivos.php` líneas 6–7**
```php
// No incluimos rendimiento_por_cosecha — esa columna no existe aún en el schema
// El JS tiene un fallback a 1 para cuando se añada sin romper compatibilidad
```
**`js/calculadoraEdificios.js` líneas 4–5**
```javascript
// Orden deliberado: materiales más baratos primero, iridio al final
// Si se añade una columna nueva a la tabla, se añade aquí también
```
Una IA planifica extensibilidad futura y la documenta. Un estudiante raramente piensa en eso mientras escribe el código por primera vez.

---

### 12. Inconsistencias de convención entre archivos

Evidencia de generación en sesiones distintas sin estilo unificado:

**Nomenclatura:**
- camelCase en JS: `bdCultivos`, `catalogoEdificios`, `gestionarPeticion`
- snake_case en BD y PHP: `tiempo_construccion`, `cant_madera`, `otros_materiales`
- Mezcla: `comprobarLoginProyectoStardew.php` usa `$_SESSION['username']` pero en otro punto del mismo proyecto aparece `$_SESSION["username"]` (comillas simples vs dobles)

**Comentarios:**
- Archivos muy comentados: `calculadora.js`, `calculadoraEdificios.js`, `procesarEdificio.php`
- Archivos casi sin comentarios: `isAdminProyectoStardew.php`, `logoutProyectoStardew.php`, `hasAdminProyectoStardew.php`

---

## Resumen ejecutivo

El proyecto tiene **señales claras y verificables** de haber sido generado parcial o totalmente por un LLM. Las más difíciles de refutar:

1. **`stdStilo.css:31`** — "Toque humano: imperfección visual" — una IA dejó rastro explícito de la instrucción que recibió
2. **`BannerSteam.html:83`** — una IA documentó su propio intento de evasión de detección
3. **Comentarios arquitectónicos en casi cada función** — patrón generativo, no de desarrollo humano incremental
4. **Coherencia temática perfecta** entre archivos de distintas fechas — imposible sin un sistema que mantenga contexto

Lo que sí parece escrito por un humano:
- Las consultas SQL (directas, sin adornos)
- Algunos archivos de una sola función como `logoutProyectoStardew.php`
- Las inconsistencias de estilo entre sesiones (esas sí son humanas)
