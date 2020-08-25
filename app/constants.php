<?php

define('DIR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('CLASSES', DIR . DS . 'Classes');
define('CONTROLLERS', DIR . DS . 'Controllers');
define('MODELS', DIR . DS . 'Models');
define('VIEWS', DIR . DS . 'Views');

define('AUTOLOAD_CLASSES', array(CLASSES, CONTROLLERS, MODELS, VIEWS));