# Leroy Merlin backend teste

## Instalação

#### Variaveis de ambiente
Crie o arquivo `.env` na pasta root do projeto

```
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=sqlite

QUEUE_CONNECTION=database
```

```
$ php artisan key:generate
```

#### Dependências
```
$ composer install
```

#### Migrações do banco
Se usar SQLite, criar arquivo `database.sqlite` na pasta database
```
$ php artisan migrate --seed
```

#### Inicializar server
```
$ php artisan serve
```

#### Inicializar fila
```
$ php artisan queue:work
```

#### Visualizar rotas
```
$ php artisan route:list
```

#### Api headers
```
Accept application/json
Content-Type application/json
```

#### Inserir produtos
```
POST api/v1/products
```
spreadsheet `file:xlsx`

#### Atualizar produtos
```
PUT|PATCH api/v1/products/{lm}
```
lm `int`
category_id `int`
name `string`
free_shipping `boolean`
description `string`
price `float`

#### Testes
```
$ vendor/bin/phpunit
```