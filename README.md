## Requisitos

- PHP 8.*
- Composer 2.*
- Docker e Docker Compose

## Pacotes

- Sanctum - API Auth
- Pest - Testes
- Laravel Pint - Code Style

## Commands
- composer test
- composer format

## Docker 

- MYSQL 
- REDIS
- MAILHOG

## Inicie

- Clone o projeto
- Copie o .env.example para .env
- Instale os pacotes: 
```
    composer install
```
- Execute o Docker:
```
    docker compose up
```
- Execute as migrations e seeders:
```
    php artisan migrate:fresh --seed
```
- Um usuário será criado com o seguinte acesso
```
    'email' => 'dev@test.com',
    'password' => '123123123'
```
- Ligue o servidor
```
    php artisan serve
```
