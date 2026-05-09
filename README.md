# ZonaPOS (Sistema de Punto de Venta)

Sistema de gestión comercial (POS) desarrollado en Laravel, Livewire y TailwindCSS, optimizado para el mercado paraguayo (facturación, moneda PYG, RUC).

## 🚀 Características Principales

*   **Punto de Venta (POS)**: Interfaz rápida, control de stock, escáner de productos por código.
*   **Gestión de Caja**: Apertura y Arqueo de caja ciego con control de diferencias.
*   **Catálogo**: Productos, Categorías y Clientes (con validación básica).
*   **Reportes**: Historial de ventas y cierres de caja exportables a Excel.
*   **Impresión**: Tickets en formato térmico (80mm) y A4.
*   **Seguridad**: Roles de Administrador y Cajero.

## 🛠️ Requisitos del Sistema

*   PHP 8.1 o superior
*   PostgreSQL 14+ (recomendado) o MySQL 8
*   Composer
*   Node.js & NPM

## 📦 Instalación

1.  **Clonar el repositorio**
    ```bash
    git clone https://github.com/tu-usuario/zonapos.git
    cd zonaposnew
    ```

2.  **Instalar dependencias**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Configurar entorno**
    Copiar `.env.example` a `.env` y configurar la base de datos:
    ```ini
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=zonapos
    DB_USERNAME=postgres
    DB_PASSWORD=tu_password
    ```

4.  **Inicializar base de datos**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
    *El comando `--seed` creará un usuario administrador por defecto y datos de prueba.*

## 👤 Credenciales por Defecto (Seeder)

*   **Usuario**: admin@zonapos.com
*   **Contraseña**: password

## 📝 Uso Básico

### 1. Iniciar Operaciones
Entrar al **POS**. Si no hay una sesión abierta, el sistema pedirá el "Monto Inicial" (fondo de caja).

### 2. Vender
*   Buscar productos por nombre o SKU.
*   Presionar (+) o (-) para ajustar cantidad.
*   Seleccionar cliente (o dejar Consumidor Final).
*   Dar clic en **COBRAR**.

### 3. Cerrar Caja
Al finalizar el turno, ir a **Caja**, ingresar el monto físico contado en "Monto Real". El sistema calculará la diferencia y cerrará el turno.

## 📄 Licencia

Software propietario desarrollado para gestión interna.
