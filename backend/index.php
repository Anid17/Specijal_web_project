<?php

require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/config/Database.php';

Flight::set('db', (new Database())->connect());

require_once __DIR__ . '/routes/users.php';
require_once __DIR__ . '/routes/products.php';
require_once __DIR__ . '/routes/orders.php';
require_once __DIR__ . '/routes/reviews.php';
require_once __DIR__ . '/routes/categories.php';
require_once __DIR__ . '/routes/pages.php'; 
require_once __DIR__ . '/routes/swagger.php';

Flight::set('flight.views.path', __DIR__ . '/../frontend/views');

Flight::start();
