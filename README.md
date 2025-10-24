# 🏛️ SystemPOA – Sistema Institucional para la Gestión del Plan Operativo Anual (Monolito Modular Laravel)

## Contexto Institucional

El **SystemPOA** es un desarrollo institucional de la **Fundación de Estudios Superiores Comfanorte (FESC)**, liderado por la **Unidad de Desarrollo de Software**, con el propósito de apoyar la **gestión, seguimiento y evaluación del Plan Operativo Anual (POA)**.

Este sistema nace como respuesta a la necesidad de **digitalizar y automatizar** los procesos de planeación institucional, alineados con el **Plan Estratégico FESC 2023–2028** y bajo el enfoque del **modelo PHVA (Planear, Hacer, Verificar, Actuar)**.  

El objetivo general es ofrecer una herramienta que permita consolidar la información de los procesos institucionales, fortalecer la trazabilidad de los avances y facilitar el control del cumplimiento de metas y objetivos de los diferentes niveles administrativos.

---

## Propósito del Proyecto

El SystemPOA busca unificar la formulación, ejecución y evaluación del POA institucional dentro de una misma plataforma, permitiendo a las dependencias y programas académicos registrar, supervisar y evidenciar sus avances de forma estructurada, auditada y alineada con los **pilares estratégicos** del plan de desarrollo institucional.

---

## Alineación con los Pilares Estratégicos FESC 2023–2028

El sistema estará orientado a los **cinco pilares fundamentales** definidos por la FESC, sirviendo como herramienta de medición y seguimiento para cada uno:

1. **Gestión Académica e Investigación.**  
2. **Gestión Administrativa y Financiera.**  
3. **Gestión del Talento Humano.**  
4. **Gestión de Bienestar Universitario.**  
5. **Gestión de Proyección Social y Extensión.**

Cada pilar representará una estructura de metas, objetivos e indicadores específicos, cuya evolución trimestral será registrada en el sistema por los responsables de área y los equipos de apoyo designados.

---

## Estructura Conceptual del Sistema

El SystemPOA implementará una **arquitectura monolítica modular**, construida en **Laravel 10**, donde cada módulo agrupará sus propias entidades, controladores, servicios, vistas y rutas.

La modularidad permitirá mantener independencia entre las áreas funcionales del sistema, garantizando una estructura escalable y organizada, sin recurrir a un desacoplamiento total entre backend y frontend.

### Capas principales:
- **Domain:** Entidades, reglas de negocio e interfaces de persistencia.  
- **Application:** Casos de uso, validaciones y servicios de aplicación.  
- **Infrastructure:** Repositorios, manejo de archivos, utilidades internas y servicios externos.  
- **Interfaces (HTTP):** Controladores, policies, requests, vistas Blade y rutas.

### Ejemplo de organización modular:
```
modules/
│
├── Core/
│   ├── Http/
│   ├── Models/
│   ├── Services/
│   ├── Database/
│   └── routes.php
│
├── Formulacion/
│   ├── Http/
│   ├── Models/
│   ├── Services/
│   ├── Database/
│   └── routes.php
│
├── Seguimiento/
│   ├── Http/
│   ├── Models/
│   ├── Services/
│   ├── Database/
│   └── routes.php
│
└── Evaluacion/
    ├── Http/
    ├── Models/
    ├── Services/
    ├── Database/
    └── routes.php
```

Cada módulo gestionará sus propios datos, lógica y control de accesos, permitiendo mantener una clara separación de responsabilidades dentro del monolito.

---

## Alcance Institucional

- Digitalización del proceso de formulación del POA institucional.  
- Estandarización de la información asociada a pilares, objetivos, alcances, metas e indicadores.  
- Seguimiento y evaluación trimestral centralizada.  
- Registro de evidencias institucionales.  
- Control de acceso según perfiles y dependencias.  
- Auditoría de los procesos y trazabilidad de cambios.

---

## Roles Institucionales y Responsabilidades

El proyecto contará con una estructura de roles inspirada en la organización real del proceso POA, tanto en la operación del sistema como en su desarrollo técnico.


### Roles del equipo de desarrollo (FESC):
Todos los integrantes participan con el mismo nivel de responsabilidad técnica como **Desarrolladores Full**, compartiendo la construcción del sistema en sus componentes funcionales, arquitectónicos y visuales.

| Nombre | Rol | Responsabilidad |
|---------|-----|-----------------|
| **Erick Sebastián Pérez Carvajal** | Desarrollador Full | Arquitectura, desarrollo integral y soporte técnico. |
| **Santiago Rueda Quintero** | Desarrollador Full | Desarrollo integral, diseño y optimización de vistas. |
| **Yeison Rolón** | Desarrollador Full | Desarrollo integral, control de calidad y soporte técnico. |

**Supervisión Institucional:**  
- **Ing. Jesús Antonio Figueroa Guerrero** – Director del Programa de Ingeniería de Software – FESC.  

---

## Stack Base del Proyecto

- **Framework:** Laravel 10.x  
- **Lenguaje:** PHP 8.2+  
- **Base de datos:** MySQL 8.x  
- **Frontend:** Blade + TailwindCSS 3.x  
- **Autenticación:** Laravel Breeze  
- **Gestión de roles y permisos:** Spatie Laravel Permission  
- **Procesamiento de imágenes:** Intervention Image  
- **Testing:** PHPUnit  

---

## Licencia y Propiedad Institucional

El SystemPOA es un proyecto de desarrollo institucional bajo licencia **FESC – Unidad de Desarrollo de Software**.  
El uso, redistribución o comercialización fuera de los fines académicos y administrativos de la institución está restringido sin autorización escrita.
