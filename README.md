# PHP-Plotter2d

A PHP Library to plot graphs and figures on a xy(-two-dimensional)-plane.

## 1. Features

## 2. Contents

- [1. Features](#1-features)
- 2\. Contents
- [3. Requirements](#3-requirements)
- [4. Installation](#4-installation)
- [5. Usage](#5-usage)
- [6. Examples](#6-example)
- [7. LICENSE](#7-license)

## 3. Requirements

- PHP 8.1 or later
- Imagick PHP Extention
- Composer

## 4. Installation

```bash
composer require macocci7/php-plotter2d
```

## 5. Usage

### 5-1. Basic Usage

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$plotter = Plotter::make(
    canvas: ['width' => 800, 'height' => 400],  // required
    viewport: ['x' => [-5, 5], 'y' => [-5, 5]], // required
);
```

### 5-2. Adjusting plot area

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$plotter = Plotter::make(
    canvasSize: [
        'width' => 800,     // required
        'height' => 400,    // required
    ],
    viewport: [
        'x' => [-5, 5],     // required
        'y' => [-5, 5],     // required
    ],
    plotarea: [ // optional
        // 20pix from left edge, 30pix from top edge
        // default=(10% of the canvas)
        'offset' => [20, 30],
        'width' => 640, // in pix, default=(80% of the canvas)
        'height' => 360 // in pix, default=(80% of the canvas)
    ],
    backgroundColor: '#0000cc',  // optional, default='#ffffff'
);
```

### 5-3. Adjusting

## 6. Exampoles

## 7. LICENSE

***

*Copyright 2024 macocci7*
