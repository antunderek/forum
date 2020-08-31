<?php

define('DS', DIRECTORY_SEPARATOR);
define('DIR', __DIR__ . DS . '..');
define('CLASSES', DIR . DS . 'classes');
define('CONTROLLERS', DIR . DS . 'controllers');
define('MODELS', DIR . DS . 'models');
define('VIEWS', DIR . DS . 'views');
define('EXCEPTIONS', DIR . DS . 'exceptions');
define('CORE', DIR . DS . 'core');

define('AUTOLOAD_CLASSES', array(CLASSES, CONTROLLERS, MODELS, VIEWS, EXCEPTIONS, CORE));