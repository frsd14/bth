<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php';
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

$di->set('FormController', function () use ($di) {
    $controller = new \Anax\HTMLForm\FormController();
    $controller->setDI($di);
    return $controller;
});

// Prepare the page content
/*
$app->theme->setVariable('title', "Hello World Pagecontroller")
           ->setVariable('main', "
    <h1>Hello World Pagecontroller</h1>
    <p>This is a sample pagecontroller that shows how to use Anax.</p>
");
*/

$app->router->add('', function() use ($app) {

  $app->theme->setTitle("Redovisning");

  $content = $app->fileContent->get('home.md');
  $byline  = $app->fileContent->get('byline.md');

  $app->views->add('me/page', [
      'content' => $content,
      'byline' => $byline,
  ]);
});

$app->router->add('redovisning', function() use ($app) {

    $app->theme->setTitle("Redovisning");

    $content = $app->fileContent->get('redovisning.md');
      $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

      $byline = $app->fileContent->get('byline.md');
      $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

});

$app->router->add('source', function() use ($app) {

    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir' => '..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);

});

$app->router->handle();

// Render the response using theme engine.
$app->theme->render();
