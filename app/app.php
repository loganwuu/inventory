<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/inventory.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=inventory';
    $username= 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('inventories.html.twig', array('inventories' => Inventory::getAll()));
    });

    $app->post("/inventories", function() use ($app) {
      $inventory = new Inventory($_POST['description']);
      $inventory->save();
      return $app['twig']->render('create_inventories.html.twig', array('new_inventory' => $inventory));
    });

    $app->post("/delete_inventories", function() use ($app) {
      Inventory::deleteAll();
      return $app['twig']->render('delete_inventories.html.twig');
    });

    $app->get("/search", function() use ($app) {
        $search_result = Inventory::find($_POST['search']);
        return $app['twig']->render('search_results.html.twig', array('search' => $search_result));
    });

    return $app;
?>
