# Pokédex (Laravel + Livewire)

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4-FB70A9?style=flat-square&logo=livewire&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-CDN-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![PokeAPI](https://img.shields.io/badge/PokeAPI-v2-EF5350?style=flat-square&logo=pokemon&logoColor=white)

Una Pokédex interactiva que consume la PokeAPI en tiempo real. Construida con Laravel 13, Livewire 4 y estilizada con TailwindCSS.

## Características

- Búsqueda en tiempo real.
- Filtros por tipo de Pokémon.
- Paginación avanzada con opción de saltar a una página específica.
- Detalles del Pokémon con estadísticas base, habilidades, peso, altura y descripción en español.
- Sistema de favoritos asociado al usuario (si está autenticado) o a la sesión del visitante.
- Optimización de peticiones con caché de 24 horas en las consultas a la PokeAPI.

## Capturas de pantalla

### Vista principal / Lista
![Lista de Pokémon](screenshots/pokemon-list.png)

### Detalle de Pokémon
![Detalle de Pokémon](screenshots/pokemon-detail.png)

### Búsqueda de Pokémon
![Búsqueda de Pokémon](screenshots/pokemon-search.png)

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/jhannlozano934-hub/pokeDex.git
   cd pokeDex
   ```

2. Instalar las dependencias de Composer:
   ```bash
   composer install
   ```

3. Configurar el entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   *Nota: Configura las credenciales de tu base de datos en el archivo `.env`.*

4. Ejecutar las migraciones:
   ```bash
   php artisan migrate
   ```

5. Levantar el servidor:
   ```bash
   php artisan serve
   ```
