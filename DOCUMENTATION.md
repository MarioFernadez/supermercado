# Documentación General y Manual Operativo: ZonaShop v2.0

**ZonaShop** es una plataforma integral de Punto de Venta (POS), Gestión de Inventario, Finanzas y Ecommerce construida sobre el **TALL Stack** (Tailwind CSS, Alpine.js, Laravel 11, Livewire 3).

---

## 📑 Tabla de Contenidos
1. [Arquitectura y Tipos de Negocio](#1-arquitectura-y-tipos-de-negocio)
2. [Roles y Permisos](#2-roles-y-permisos)
3. [Módulo de Ventas y Caja POS](#3-módulo-de-ventas-y-caja-pos)
4. [Módulos Especializados por Industria](#4-módulos-especializados-por-industria)
   - [Restaurante y Gastronomía](#41-restaurante-y-gastronomía)
   - [Minimercado y Carnicería (Desposte)](#42-minimercado-y-carnicería-desposte)
   - [Boutique (Tallas y Colores)](#43-boutique-tallas-y-colores)
   - [Perfumería (Fraccionamiento / Decants)](#44-perfumería-fraccionamiento--decants)
5. [Módulo de Tienda y Catálogo](#5-módulo-de-tienda-y-catálogo)
6. [Módulo de Finanzas y Cobranzas](#6-módulo-de-finanzas-y-cobranzas)
7. [Módulo de Reportes](#7-módulo-de-reportes)
8. [Módulo de Configuración del Sistema](#8-módulo-de-configuración-del-sistema)

---

## 1. Arquitectura y Tipos de Negocio

El sistema cuenta con un motor modular dinámico gobernado por la configuración `business_type`. Al cambiar el tipo de negocio en **Configuración › Ajustes Generales**, el sistema habilita o deshabilita herramientas sin pérdida de datos históricos.

```
┌─────────────────────────────────────────────────────────────┐
│                    ZONASHOP CORE ENGINE                     │
│  (Ventas, Stock Multirama, Clientes, Finanzas, Reportes)    │
└───────────────┬─────────────────────────────┬───────────────┘
                ▼                             ▼
┌───────────────────────────────┐ ┌───────────────────────────┐
│     Módulos Especializados    │ │   Canales de Venta        │
│ • Restaurante (Mesas/Comandas)│ │ • Caja POS Táctil         │
│ • Carnicería (Taller Desposte)│ │ • Tienda Online Ecommerce │
│ • Boutique (Variaciones)      │ │ • Pedidos por WhatsApp    │
│ • Perfumería (Decants/Mililit)│ │                           │
└───────────────────────────────┘ └───────────────────────────┘
```

---

## 2. Roles y Permisos

| Rol / Nivel | Alcance y Funcionalidades |
| :--- | :--- |
| **Administrador (`admin`)** | Acceso total al sistema: Ajustes generales, usuarios, sucursales, cajas, configuración de licencias y personalización web. |
| **Gerente (`gerente`)** | Gestión operativa: Catálogo completo, compras, proveedores, taller de desposte, reportes analíticos, ranking de vendedores y cobranzas. |
| **Cajero / Vendedor** | Operativa de caja: Apertura/cierre de turno, realizar ventas en POS, registrar clientes y consultar stock. |
| **Master / Developer** | Gestión de licenciamiento y control maestro multitenant (`/master/licensing`). |

---

## 3. Módulo de Ventas y Caja POS

### 3.1 Sesiones de Caja (`/cash`)
* **Apertura de Caja:** El cajero declara el fondo inicial en efectivo (guaraníes) para iniciar su turno.
* **Control de Movimientos:** Registro de ingresos manuales (ej. cambio extra) y egresos (pagos menores a proveedores, retiros de efectivo).
* **Arqueo y Cierre:** Resumen consolidado del dinero esperado vs. dinero real contado por método de pago.

### 3.2 Interfaz de Venta POS (`/pos`)
* **Búsqueda Ultrarrápida:** Búsqueda en tiempo real por nombre, código de barras SKU o lectora láser.
* **Soporte de Balanzas:** Compatible con lectura directa de peso y códigos de barras de balanza troquelada.
* **Multimoneda con Conversión Automática:** Cobro simultáneo en Guaraníes (PYG), Dólares (USD), Reales (BRL) y Pesos Argentinos (ARS) con tipos de cambio configurables.
* **Métodos de Pago Soportados:**
  * Efectivo (PYG y divisas extranjeras con cálculo de vuelto).
  * Tarjetas de Débito / Crédito.
  * Transferencias y pagos QR (Pix, billeteras electrónicas).
  * Cheques (con registro de banco, número de cheque y fecha de vencimiento).
  * Pagos Múltiples / Mixtos (ej. mitad tarjeta, mitad efectivo).
  * Venta a Crédito (con imputación automática a la cuenta corriente del cliente).
* **Integración con Ecommerce:** Recepción de pedidos web de la tienda online con un clic para facturar en caja.

---

## 4. Módulos Especializados por Industria

### 4.1 Restaurante y Gastronomía
* **Configuración de Salón (`/settings/restaurant`):** Creación de sectores, mesas fijas y mozos activos.
* **Mapa de Mesas en POS:** Visualización gráfica del estado de cada mesa (Libre / Ocupada con mozo asignado y total acumulado).
* **Marchar Comandas Térmicas:**
  * Cada producto tiene asignada su zona de producción: **Cocina**, **Barra/Bebidas** o **General**.
  * Al presionar *"Marchar Comanda"*, el sistema genera la comanda para impresión térmica en formato 80mm agrupada por zonas.
* **Facturación:** Al cobrar la cuenta en la caja, la mesa se libera automáticamente y la comanda pendiente se archiva.

### 4.2 Minimercado y Carnicería (Desposte)
* **Materia Prima vs. Cortes:** Permite marcar productos base (ej. *Media Res* en kg) y productos finales vendibles (ej. *Costilla*, *Vacío*, *Lomito*).
* **Taller de Desposte (`/admin/deboning`):**
  * Registra el peso inicial de la pieza.
  * Distribuye los kilogramos obtenidos en los diferentes cortes.
  * Calcula automáticamente el **Rendimiento** y la **Merma / Desperdicio** (grasa, hueso no aprovechable).
  * Realiza el balance de stock atómico: descuenta los kg de la media res y suma los kg de cada corte al inventario vendible.

### 4.3 Boutique (Tallas y Colores)
* **Gestión de Variantes:** Creación de combinaciones de productos (ej. *Remera Polo* -> Talle M / Color Azul) con stock y SKU independiente por variante.

### 4.4 Perfumería (Fraccionamiento / Decants)
* **Fraccionamiento Automático:** Permite vender muestras/decants (ej. 5ml, 10ml) descontando proporcionalmente los mililitros de la botella o envase matriz.

---

## 5. Módulo de Tienda y Catálogo

* **Gestión de Productos (`/products`):** Registro de costos, precios mayoristas/minoristas, impuestos (IVA 10%, IVA 5%, Exentas), stock mínimo y alertas.
* **Control Multirama (`branch_stocks`):** Control de inventario independiente para cada sucursal de la empresa.
* **Impresión de Etiquetas y Códigos de Barras:**
  * Generación de códigos EAN/Code128 con JsBarcode.
  * Formato de rollo continuo térmico (ej. 50x30mm) y hojas A4 troqueladas.
* **Categorías (`/categories`):** Organización jerárquica de productos con slugs amigables para ecommerce.
* **Compras y Entradas (`/purchases`):** Carga de facturas de proveedores con actualización automática de costo ponderado y reposición de inventario.
* **Proveedores (`/suppliers`):** Directorio de contactos comerciales, RUC y plazos de pago.

---

## 6. Módulo de Finanzas y Cobranzas

* **Gastos Operativos (`/expenses`):** Clasificación de egresos por categorías (alquiler, luz, salarios, insumos) con reportes de periodo.
* **Cobranzas de Clientes (`/admin/collections`):**
  * Control de saldos deudores de clientes a crédito.
  * Registro de recibos de cobro y amortizaciones parciales/totales.
  * Historial de transacciones de débito y crédito por cliente.

---

## 7. Módulo de Reportes

* **Detalle de Ventas (`/reports/sales`):** Filtros por rango de fechas, sucursal, cajero, cliente y método de pago con exportación a Excel e impresión.
* **Ranking de Vendedores (`/reports/salesperson`):** Medición de rendimiento comercial y cálculo de comisiones.
* **Estado de Inventario (`/reports/inventory`):** Valorización monetaria del inventario a precio de costo y precio de venta, con semáforo de quiebre de stock.
* **Saldos deudores (`/reports/debtors`):** Informe de antigüedad de deudas de clientes.

---

## 8. Módulo de Configuración del Sistema

* **Ajustes Generales (`/settings/general`):**
  * Nombre del comercio, logo, RUC, teléfono, dirección y moneda base.
  * Selección del Tipo de Negocio (Retail, Minimercado, Boutique, Perfumería, Restaurante).
  * Cotizaciones de divisas extranjeras (USD, BRL, ARS, EUR).
  * Configuración de redondeos e impuestos.
* **Sucursales y Cajas (`/settings/branches`, `/settings/registers`):** Creación de locales físicos y terminales de punto de venta.
* **Usuarios y Vendedores (`/users`, `/sellers`):** Administración de credenciales de acceso y asignación de roles.
* **Personalización Web y CMS (`/settings/customization`):** Banners, páginas estáticas, enlaces de redes sociales y catálogo online para pedidos WhatsApp.
