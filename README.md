<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About:

Project for activity management API

Summary:

With the Laravel and Sanctum toolset, an API is developed that allows the creation of projects, tasks and activities, it also allows the management of roles per project, ensuring that several users manage the tasks depending on the assigned roles.


Scheme:

Project->Task->Activities


Steps:
1) Create project (By default the user remains as administrator)
2) Enter the tasks of the created project.
3) Create tasks
4) Enter activities
5) Within activities, activities will be created indicating the start time of the activity and its end.

In this way each project will have a set of tasks and in turn these will have their associated activities.

Inside my github is the front end repository called "front_todolist"

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
