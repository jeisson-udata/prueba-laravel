<p align="center"><a href="/" target="_blank"><img src="https://cdn-icons-png.flaticon.com/512/1039/1039328.png" width="100" alt="Prueba técnica"></a></p>

# PRUEBA TÉCNICA BACKEND

JEISSON ESTEBAN ANDRADE LEON - CC1031137700

> **TECNOLOGIAS:**
>
> LARAVEL 11 - PHP 8.2 - MYSQL 8.0


## Arquitectura del proyecto LARAVEL


Laravel está construido sobre una arquitectura MVC (Modelo-Vista-Controlador), lo que facilita una separación clara entre la lógica de la aplicación y la interfaz de usuario. Esta estructura es eficiente y ayuda a que el código sea más fácil de mantener y testear

<img src="https://dam.org.es/wp-content/uploads/2021/04/arquitectura.png" alt="arquitectura" />

### Configuración de servidor sugerida
A continuación se describe la infraestructura recomendada para desplegar la solución:

<img src="./documentation/servidor.drawio.png" alt="db-model-diagram" />

### Modelo de clases
A continuación se muestra el modelo de base de clases de la aplicación:

<img src="./documentation/clases.drawio.png" alt="clases-diagram" />


### Modelo de base de datos
A continuación se muestra el modelo de base de datos de la aplicación:

<img src="./documentation/db-model-diagram.drawio.png" alt="db-model-diagram" />

## Run Docker

> **Nota:**
>
> Asegúrate de que los puertos **9215** y **3306** estén libres en la máquina de ejecución antes de iniciar los contenedores Docker.


### 1. Ejecutar Docker
```bash
docker-compose up -d
```

### 2. Instalar Composer
```bash
docker exec -it laravel_app /bin/sh -c "cd /var/www/html && composer install"
```

### 3. Prueba
Los servicios API se encuentran disponibles en la siguiente URL:
```
http://localhost:9215
```

### 4. Documentación de la API

La documentación SWAGGER de la API se encuentra disponible en la siguiente URL:
[http://localhost:9215/swagger/index.html](http://localhost:9215/swagger/index.html).


### 5. Ejecutar pruebas unitarias

```bash
docker exec -it laravel_app /bin/sh -c "cd /var/www/html && php artisan test"
```

Resultado de pruebas:

<img src="./documentation/tests.png" alt="tests" />

Donde la prueba:

- **it not can create a reservation when is unavailable** Comprueba que no pueda crear una reservación cuando no esta disponible.
- **it can create a reservation when is cancelled** Comprueba que pueda crear una reservación cuando se cancela.
- **it can cancelled a reservation** Comprueba que pueda cancelar una reservación.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
