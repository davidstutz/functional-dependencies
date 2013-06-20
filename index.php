<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim( array(
    'templates.path' => './Views',
    'view' => new \Slim\View(),
    'base' => 'functional-dependencies',
));

\Slim\I18n::setPath('I18n');

if (!function_exists('__')) {
    /**
     * Translation function
     *
     * Will translate given string into current set language.
     */
    function __($string, array $args = NULL) {
        $translation = \Slim\I18n::getTranslation($string);

        return is_null($args) ? $translation : strtr($translation, $args);
    }

}

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get('/', function() use ($app) {
    $app->redirect($app->config('base') . $app->router()->urlFor('demo'));
});

/**
 * Theory.
 */
$app->get('/theory', function() use ($app) {
    
})->name('theory');

/**
 * Demo.
 */
$app->get('/demo', function() use ($app) {
    $app->render('Demo.php', array('app' => $app));
})->name('demo');

$app->post('/demo', function() use ($app) {
    $attributes = $app->request()->post('attributes');
    $dependencies = $app->request()->post('dependencies');
    
    $attributes = new \Libraries\Set(array_map('trim', explode(';', trim($attributes))));
    $dependencies = array_map('trim', explode(';', trim($dependencies)));
    
    $schema = new \Libraries\RelationalSchema($attributes);
    
    foreach ($dependencies as $dependency) {
        $dependency = array_map('trim', explode('->', trim($dependency)));
        $left = new \Libraries\Set(array_map('trim', explode(',', array_shift($dependency))));
        $right = new \Libraries\Set(array_map('trim', explode(',', array_pop($dependency))));
        $functionalDependency = new \Libraries\FunctionalDependency($left, $right);
        $schema->getFunctionalDependencies()->add($functionalDependency);
    }
    
    $app->render('Demo.php', array('app' => $app, 'schema' => $schema));
});

/**
 * Credtis.
 */
$app->get('/credits', function() use ($app) {
    $app->render('Credits.php', array('app' => $app));
})->name('credits');

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
