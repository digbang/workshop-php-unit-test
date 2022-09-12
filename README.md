# PHPUnit Workshop

## 1. Entorno
- PHP
- Composer

### Instalación PHPUnit
`composer require phpunit/phpunit --dev`

### Packages útiles para el ejercicio
`composer require symfony/var-dumper --dev`

`composer require illuminate/collection`

`composer require moneyphp/money`

### Estructura de carpetas
```
mfilipoff/test-workshop
│   composer.json    
│   phpunit.xml
│   ...
│
└───src
|   │   ...
│
└───tests
    │   factories.php
    │
    └───Feature
    │   │   XTest.php
    │
    └───Unit
        │   XTest.php
```

## 2. Suites
Contamos con dos suites configuradas en el archivo phpunit.xml: **Feature** y **Unit**.

## 3. Los tests deben ser
- Independientes entre sí
- Rápidos
- De caja negra

## 4. Naming
Utilizando **TDD** (Test Driven Development) es una práctica no nombrar significativamente los tests de entrada, ya que posiblemente no tengamos conocimiento suficiente del dominio como para definirlos claramente, por eso mismo a los TestCase los voy a nombrar `XTest`, mientras que a cada test lo voy a enumerar, empezando por `test_001`.

Recordemos que PHPUnit necesita que el test cominece con `test_` o en su defecto decorarlo con `@Test`.

## 5. Ejercicio
Desarrollaremos un carrito de compra y simularemos el flujo desde que tomo el carrito de compras hasta que paso por caja y obtengo el total a pagar.

Con que clases bamos a trabajar?
- Cart
- Catalog
- Checkout

## 6. Ejecución
`./vendor/bin/phpunit tests/Unit --random-order`
