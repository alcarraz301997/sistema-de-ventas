# Sistema de Ventas - API Laravel

## 🚀 **Índice**

1. [Descripción del Proyecto](#-descripción-del-proyecto)
2. [Requisitos Previos](#-requisitos-previos)
3. [Instalación y Configuración](#-instalación-y-configuración)
4. [Ejecución del Proyecto](#-ejecución-del-proyecto)
5. [Endpoints Principales](#-endpoints-principales)
6. [Diseño y Decisiones Técnicas](#-diseño-y-decisiones-técnicas)
7. [Diagrama ERD (Entidad-Relación)](#-diagrama-erd-entidad-relación)
8. [Contribuciones](#-contribuciones)
9. [Licencia](#-licencia)

---

## 📄 **Descripción del Proyecto**

Este proyecto es una API RESTful desarrollada con Laravel para la gestión de ventas. Incluye funcionalidades de administración de productos, registro de ventas, generación de reportes en formatos JSON y XLSX, y un sistema de roles y permisos para diferenciar accesos entre administradores y vendedores.

---

## 📋 **Requisitos Previos**

Asegúrate de tener instalados los siguientes programas:

- PHP ^8.1
- Composer
- MySQL
- Laravel ^10

---

## ⚙️ **Instalación y Configuración**

1. **Clonar el repositorio:**

```bash
git clone https://github.com/alcarraz301997/sistema-de-ventas.git
cd sistema-de-ventas
```

2. **Instalar dependencias:**

```bash
composer install
```

3. **Configurar el archivo **``**:**

```bash
cp .env.example .env
```

- Configura las credenciales de la base de datos en el archivo `.env`.

4. **Generar la clave de la aplicación:**

```bash
php artisan key:generate
```

5. **Ejecutar las migraciones y seeders:**

```bash
php artisan migrate
```

6. **Instalar dependencias de Excel para reportes:**

```bash
composer require maatwebsite/excel
```

---

## 🚀 **Ejecución del Proyecto**

1. Inicia el servidor de desarrollo:

```bash
php artisan serve
```

2. Accede a la API en:

```
http://127.0.0.1:8000/api
```

---

## 📡 **Endpoints Principales**

- **Autenticación:** Registro, login y logout.
- **Productos:** CRUD de productos, incremento de stock.
- **Ventas:** Registro de ventas y control de stock.
- **Reportes:** Exportación de ventas en JSON y XLSX.
- **Usuarios:** Gestión de roles y permisos.

Documentación detallada disponible con Laravel Swagger o Postman.

---

## 🛠️ **Diseño y Decisiones Técnicas**

1. **Arquitectura:**

   - Arquitectura de 3 capas (capas de Controller, Service y Repository).
   - Uso de Policies para autorización.

2. **Base de Datos:**

   - Relación uno a muchos entre `sales` y `sale_products`.
   - Relación muchos a muchos entre `users` y `roles`.

3. **Paquetes Clave:**

   - `maatwebsite/excel` para reportes.
   - `spatie/laravel-permission` para roles y permisos.

---

## 📊 **Diagrama ERD (Entidad-Relación)**

*El siguiente es un diagrama ERD que describe la estructura de la base de datos.*

![Diagrama ERD](D:\Proyectos\sistema-de-ventas\Diagrama.png)

---