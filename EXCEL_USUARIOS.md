# Instrucciones para crear el archivo Excel de usuarios

Este archivo Excel se utilizará para cargar múltiples usuarios en el sistema de manera masiva. A continuación, se detallan las instrucciones para estructurar correctamente el archivo.

## Formato del Archivo

El archivo Excel debe contener los siguientes encabezados en la primera fila:

| Columna | Encabezado          | Descripción                                                                 |
|---------|---------------------|-----------------------------------------------------------------------------|
| A       | `nombre_apellidos`  | Nombre completo del usuario (obligatorio).                                  |
| B       | `rol`               | Rol del usuario (`maestra`, `alumna` o `admin`) (obligatorio).              |
| C       | `fecha_nacimiento`  | Fecha de nacimiento en formato `YYYY-MM-DD`.                                |
| D       | `celula`            | Número de cédula o identificación (opcional).                               |
| E       | `fecha_ingreso`     | Fecha de ingreso en formato `YYYY-MM-DD`.                                   |
| F       | `fecha_graduacion`  | Fecha de graduación en formato `YYYY-MM-DD` (opcional).                     |
| G       | `email`             | Correo electrónico del usuario (obligatorio).                               |
| H       | `color`             | Nivel o color asignado al usuario (opcional para alumnas, obligatorio para maestras). |
| I       | `password`          | Contraseña del usuario (obligatorio).                                       |
| J       | `telefonos`         | Lista de teléfonos separados por comas (opcional).                          |
| K       | `niveles`           | IDs de los niveles en los que enseña la maestra, separados por comas (solo para maestras). |
| L       | `funciones`         | Función en cada nivel (`titular` o `auxiliar`), correspondiente a los IDs en la columna K (solo para maestras). |

## Ejemplo de Archivo

El archivo debe seguir esta estructura:

| nombre_apellidos    | rol      | fecha_nacimiento | celula  | fecha_ingreso | fecha_graduacion | email            | color  | password  | telefonos          | niveles | funciones                |
|---------------------|----------|------------------|---------|---------------|------------------|------------------|--------|-----------|---------------------|---------|--------------------------|
| Juan Pérez García   | maestra  | 1990-01-01       | 123456  | 2020-01-01    | 2022-01-01       | juan@example.com | azul   | pass1234  | 555-1234,555-5678   | 1,2,3   | titular,auxiliar,auxiliar |
| María Rodríguez     | alumna   | 1995-02-02       | 654321  | 2021-02-02    | 2023-02-02       | maria@example.com| rojo   | pass5678  | 555-9876,555-4321   |         |                          |

### Notas:

1. **nombre_apellidos**: Nombre completo del usuario. Este campo es obligatorio.
2. **rol**: Define el rol del usuario. Puede ser `maestra`, `alumna` o `admin`. Este campo es obligatorio.
3. **fecha_nacimiento**: Fecha de nacimiento del usuario en el formato `YYYY-MM-DD`.
4. **celula**: Número de identificación o cédula. Este campo es opcional.
5. **fecha_ingreso**: Fecha en la que el usuario ingresó al sistema, en el formato `YYYY-MM-DD`.
6. **fecha_graduacion**: Fecha en la que el usuario se graduó (si aplica), en el formato `YYYY-MM-DD`.
7. **email**: Correo electrónico del usuario. Este campo es obligatorio y debe ser único.
8. **color**: Nivel o color asignado. Este campo es obligatorio para maestras y opcional para alumnas.
9. **password**: Contraseña que se asignará al usuario. Este campo es obligatorio.
10. **telefonos**: Lista de teléfonos separados por comas. Este campo es opcional.
11. **niveles**: IDs de los niveles en los que enseña la maestra, separados por comas. Este campo es obligatorio si el rol es `maestra`.
12. **funciones**: Función en cada nivel (`titular` o `auxiliar`), correspondiente a los IDs en la columna `niveles`. Este campo es obligatorio si el rol es `maestra`.

## Guardado del Archivo

Guarda el archivo en formato `XLSX` con un nombre descriptivo, por ejemplo, `usuarios.xlsx`.

## Consideraciones Finales

- Asegúrate de que todos los datos sean correctos y que cada usuario tenga un correo electrónico único.
- Verifica que los niveles y funciones estén correctamente asociados si estás agregando maestras.
- Evita dejar celdas en blanco en campos obligatorios.

Una vez que el archivo esté listo, podrás cargarlo en el sistema utilizando la opción de "Cargar Usuarios desde Excel".
