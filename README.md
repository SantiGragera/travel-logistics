# 🚚 Travel Logistics - Sistema de Gestión de Flotas

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

Travel Logistics es una plataforma web integral diseñada para administrar, despachar y monitorear flotas de camiones y choferes. Construida con PHP puro y MySQL, destaca por una interfaz de usuario (UI) moderna, limpia y desarrollada 100% con CSS nativo (sin frameworks).

## ✨ Características Principales

* **Panel Operativo:** Panel de control con métricas en tiempo real sobre viajes activos, camiones disponibles y choferes operativos.
* **Lógica de Estados Automática:** Los viajes cambian de estado ("Planeado", "En Progreso", "Completado") automáticamente basándose en la fecha del sistema (`CURDATE()`), sin intervención manual.
* **Prevención de Double-Booking:** El motor de base de datos filtra de forma inteligente a los camiones y choferes que ya se encuentran "En Viaje", evitando asignaciones duplicadas para una misma fecha.
* **Cálculo de Comisiones:** Motor interno para calcular automáticamente las ganancias del conductor basándose en porcentajes y costos totales del flete.
* **Diseño UI/UX Premium:** Tablas de datos fluidas con avatares dinámicos, insignias (badges) de estado por colores y diseño responsivo, todo construido desde cero.

## 📸 Capturas de Pantalla

| Panel de Control | Listado de Choferes | Formulario de Carga |
| :---: | :---: | :---: |
| <img src="ruta/a/tu/captura-capturaPanel.png" width="300"/> | <img src="ruta/a/tu/listadoChoferes.png" width="300"/> | <img src="ruta/a/tu/cargaViajes.png" width="300"/> |

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP (Programación procedimental limpia y estructurada)
* **Base de Datos:** MySQL (Relacional, con llaves foráneas y consultas complejas de exclusión)
* **Frontend:** HTML5 semántico y CSS3 puro (Flexbox, Grid, variables, UI moderna)
* **Iconografía:** Bootstrap Icons

**Credenciales de prueba (Administrador):**
* **Usuario:** admin
* **Clave:** 1234