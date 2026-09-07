---
name: Modern Slate Real Estate System
colors:
  surface: '#faf8ff'
  surface-dim: '#d2d9f4'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f3ff'
  surface-container: '#eaedff'
  surface-container-high: '#e2e7ff'
  surface-container-highest: '#dae2fd'
  on-surface: '#131b2e'
  on-surface-variant: '#464555'
  inverse-surface: '#283044'
  inverse-on-surface: '#eef0ff'
  outline: '#777587'
  outline-variant: '#c7c4d8'
  surface-tint: '#4d44e3'
  primary: '#3525cd'
  on-primary: '#ffffff'
  primary-container: '#4f46e5'
  on-primary-container: '#dad7ff'
  inverse-primary: '#c3c0ff'
  secondary: '#006c49'
  on-secondary: '#ffffff'
  secondary-container: '#6cf8bb'
  on-secondary-container: '#00714d'
  tertiary: '#571ac0'
  on-tertiary: '#ffffff'
  tertiary-container: '#6f3dd9'
  on-tertiary-container: '#e3d5ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#e2dfff'
  primary-fixed-dim: '#c3c0ff'
  on-primary-fixed: '#0f0069'
  on-primary-fixed-variant: '#3323cc'
  secondary-fixed: '#6ffbbe'
  secondary-fixed-dim: '#4edea3'
  on-secondary-fixed: '#002113'
  on-secondary-fixed-variant: '#005236'
  tertiary-fixed: '#e9ddff'
  tertiary-fixed-dim: '#d0bcff'
  on-tertiary-fixed: '#23005c'
  on-tertiary-fixed-variant: '#5516be'
  background: '#faf8ff'
  on-background: '#131b2e'
  surface-variant: '#dae2fd'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 2rem
    fontWeight: '700'
    lineHeight: 2.5rem
    letterSpacing: -0.025em
  headline-xl-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.5rem
    fontWeight: '700'
    lineHeight: 2rem
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: 2rem
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.25rem
    fontWeight: '600'
    lineHeight: 1.75rem
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.125rem
    fontWeight: '600'
    lineHeight: 1.5rem
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Inter
    fontSize: 1rem
    fontWeight: '400'
    lineHeight: 1.5rem
  body-md:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '400'
    lineHeight: 1.25rem
  body-sm:
    fontFamily: Inter
    fontSize: 0.75rem
    fontWeight: '400'
    lineHeight: 1rem
  label-lg:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '600'
    lineHeight: 1.25rem
    letterSpacing: 0.01em
  label-md:
    fontFamily: Inter
    fontSize: 0.75rem
    fontWeight: '600'
    lineHeight: 1rem
    letterSpacing: 0.02em
  label-caps:
    fontFamily: Plus Jakarta Sans
    fontSize: 0.6875rem
    fontWeight: '700'
    lineHeight: 0.875rem
    letterSpacing: 0.06em
  numeric-metric:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.75rem
    fontWeight: '700'
    lineHeight: 2rem
    letterSpacing: -0.03em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  touch-target: 2.75rem
  gutter-xs: 0.25rem
  gutter-sm: 0.5rem
  gutter-md: 1rem
  gutter-lg: 1.5rem
  gutter-xl: 2rem
  margin-mobile: 1rem
  margin-tablet: 1.5rem
  margin-desktop: 2rem
  sidebar-width-expanded: 16.5rem
  sidebar-width-collapsed: 4.5rem
  bottom-nav-height: 4rem
---

## Brand & Style

This design system upgrades traditional monolithic CRM dashboards into an agile, modern SaaS productivity suite tailored for high-velocity real estate brokerages, agents, and administrators. 

### Brand Personality & Emotional Tone
- **Precision & Authority:** High legibility and crisp data tables instill confidence during financial and client negotiations.
- **Calm Agility:** Replacing the heavy, high-contrast dark AdminLTE sidebar with an airy, slate-tinted chrome reduces visual fatigue across 8-hour broker workflows.
- **Polished Tactility:** Micro-interactions, soft border outlines, and purposeful emerald/violet accents evoke a premier, institutional-grade proptech platform.

### Design Movement
**Modern SaaS Hybrid Minimalist:** A fusion of high-utility corporate SaaS architecture with tactile, soft-edged container hierarchy. It relies on subtle hairline dividers (`slate-200/80`), soft background tints, low-elevation diffusion shadows, and precise pill badges rather than intense saturated blocks.

## Colors

The system uses a calibrated palette engineered for readability, visual hierarchy, and real estate operational states:

- **Primary (`#4f46e5` - Indigo 600):** Drives intentional user focus—active navigation states, primary action triggers, links, and selected states.
- **Secondary (`#10b981` - Emerald 500):** Anchors operational health—active property statuses, transaction completions, positive delta metrics, and deal pipelines.
- **Tertiary (`#8b5cf6` - Violet 500):** Accents analytics, secondary KPIs, insights, and website integration badges.
- **Neutral Core (`#0f172a` - Slate 900 to `#f8fafc` - Slate 50):** 
  - Canvas Background: `#f8fafc` (Slate 50)
  - Card & Container Surface: `#ffffff` (Pure White)
  - Sidebar / Chrome Elevated Surface: `#ffffff` with a subtle hairline separator of `#e2e8f0` (Slate 200)
  - Primary Text: `#0f172a` (Slate 900)
  - Muted/Secondary Text: `#64748b` (Slate 500)
- **Functional Semantics:**
  - Amber (`#f59e0b`): Pending tasks, upcoming appointments, client follow-up indicators.
  - Rose (`#f43f5e`): Expired listings, canceled escrows, destructive actions.
  - Cyan (`#06b6d4`): Buyer tags, incoming tenant inquiries.

## Typography

The type system balances **Plus Jakarta Sans** for clear, open geometric headings and operational KPI metrics with **Inter** for dense tabular data layouts, forms, and administrative metadata.

- **Headline Scale:** Used for primary dashboard metrics, module titles, and drawer headers. Headings utilize tight tracking (`-0.025em`) for modern density.
- **Label Caps:** Designed specifically for category groupings in the sidebar (`CONFIGURACIÓN`, `ESTADÍSTICAS`), table headers, and status pill badges. Always transformed to uppercase with elevated letter spacing (`0.06em`).
- **Tabular Numerics:** Inter and Plus Jakarta Sans feature proportional lining numbers enabled with font features (`tnum`) across all pricing and property inventory matrices to ensure vertical digit alignment.

## Layout & Spacing

The framework employs an 8pt rhythmic grid system embedded inside a fluid, modular app-shell structure.

### App Shell Architecture
- **Desktop (>= 1024px):** Dual-tier sidebar (expandable to `16.5rem`, icon-only mini mode `4.5rem`), top persistent action utility bar (`4rem` height), and fluid multi-column content frame with `2rem` outer padding.
- **Tablet (768px - 1023px):** Collapsible off-canvas drawer triggered via header bar, with a 2-column KPI grid and responsive scrollable data tables.
- **Mobile (< 768px):** Clean single-column layout with a fixed bottom navigation bar (`4rem` height) housing high-frequency destinations, while deep administrative routes reside in a bottom sheet / slide-over drawer with swipe gestures.

### Ergonomics & Touch Guidelines
- **Strict Touch Target Minimum:** All interactive buttons, navigation links, filters, and icon triggers maintain a minimum touch bounding box of `44px` (`2.75rem`), with at least `8px` separation.
- **Bottom Navigation Priority:** Mobile thumb-zone optimization guarantees that primary views (Dashboard, Propiedades, Contactos, Notificaciones, Menú) are reachable within single-hand thumb radius.

## Elevation & Depth

This system moves away from heavy, pitch-black shadows and outdated high-contrast borders in favor of diffused slate ambiance and layered tonal surfaces:

- **Level 0 (Flat Canvas):** `#f8fafc` (Slate 50). Background container for all viewports.
- **Level 1 (Card & Module Surfaces):** Pure White (`#ffffff`) bounded by a subtle `1px` hairline stroke of `rgba(226, 232, 240, 0.8)` (`slate-200/80`) paired with a micro-ambient shadow: `0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 1px 2px -1px rgba(15, 23, 42, 0.02)`.
- **Level 2 (Hovered Cards & Interactive Controls):** Elevated with `0 4px 6px -1px rgba(15, 23, 42, 0.06), 0 2px 4px -2px rgba(15, 23, 42, 0.04)`. Card border transitions to `rgba(99, 102, 241, 0.2)` on agent interaction.
- **Level 3 (Dropdowns & Popovers):** Elevated floating layers featuring `0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.03)` with `1px` border of `rgba(226, 232, 240, 1)`.
- **Level 4 (Slide-over Drawer & Modal Shell):** Smooth backdrop overlay using `rgba(15, 23, 42, 0.4)` with 4px backdrop-blur filter (`backdrop-blur-sm`), casting a directional shadow `0 25px 50px -12px rgba(15, 23, 42, 0.25)`.

## Shapes

The geometric architecture uses balanced, modern soft radii (`Level 2 - Rounded`):

- **Controls & Form Inputs:** `rounded-lg` (`0.5rem` / `8px`) provides balanced alignment between labels, inputs, and inline action buttons.
- **Cards, Panels & Containers:** `rounded-xl` (`0.75rem` / `12px`) softens data-dense dashboards while keeping grid alignment sharp.
- **Badges, Status Pills & Avatar Rings:** `rounded-full` (`9999px`) creates clean contrast against rectangular cards.
- **Drawers & Bottom Sheets:** `rounded-t-2xl` (`1rem` / `16px`) on mobile viewports reinforces sheet physics and natural ergonomics.

## Components

### Navigation Architecture
- **Desktop Sidebar:** Clean slate/white background with an organized hierarchy:
  - Top: Organization identity, avatar dropdown, and global real estate search shortcut (`Cmd + K`).
  - Section Headings: Subtle `label-caps` in `#64748b` (Slate 500) with generous top spacing (`1.5rem`).
  - Nav Items: Min-height `44px`, `rounded-lg`, subtle hover background (`slate-100/70`). Active link utilizes primary indigo tint (`bg-indigo-50 text-indigo-700 font-semibold`) accented by a vertical `3px` left-edge indigo pill bar.
  - Hierarchy Sections:
    1. **Principal:** Dashboard, Reportes
    2. **Inventario & Clientes:** Propiedades, Contactos
    3. **Operaciones:** Tareas, Agenda, Website
    4. **Administración:** Sistema, Configuración
- **Mobile Bottom Navigation:** Fixed `64px` height bar with 5 key quick-actions. Active icon sits above a subtle `4px` glowing dot; labels rendered in `11px` medium font.

### Buttons & Action Bars
- **Primary Button:** Solid Indigo (`#4f46e5`), hover (`#4338ca`), crisp text (`#ffffff`), `h-10` or `h-11`, with `px-4` and subtle inner highlight shadow (`inset 0 1px 0 rgba(255,255,255,0.15)`).
- **Secondary / Ghost Button:** Transparent background, hairline border (`slate-300`), text in `slate-700`, active state transitions to `bg-slate-50`.
- **Quick Action Bar:** Replaces disparate multi-colored buttons with a unified, cohesive segmented toolbar: soft `slate-100` housing with rounded buttons, consistent iconography, and clean label hierarchy.

### Cards & KPI Tiles
- Metric value in `numeric-metric` (`Plus Jakarta Sans Bold`), paired with an icon housed in an ambient tinted circle (e.g., emerald background `bg-emerald-50 text-emerald-600` for properties, violet `bg-violet-50 text-violet-600` for metrics).
- Footer trends show delta badges (`+10 activas`) with inline status micro-dots.

### Data Tables & List Views
- **Header:** Background `slate-50/75`, border bottom `1px solid slate-200`, text `label-caps` in `slate-500`.
- **Row:** Minimum row height `56px` for touch accessibility. Alternating subtle border-bottom, hover highlight (`bg-slate-50/50`).
- **Status Badges:** 
  - `Activa` (Active listing): `bg-emerald-50 text-emerald-700 border border-emerald-200/60`
  - `Comprador` (Buyer): `bg-sky-50 text-sky-700 border border-sky-200/60`
  - `Arrendatario` (Tenant): `bg-violet-50 text-violet-700 border border-violet-200/60`
  - `Pendiente` (Pending): `bg-amber-50 text-amber-700 border border-amber-200/60`

### Input Fields & Controls
- Height `44px` (`h-11`) for finger and cursor targets. Border in `slate-300`, focused state adopts `border-indigo-500` and `ring-4 ring-indigo-500/10` halo for accessible focus management. Placeholder in `slate-400`.