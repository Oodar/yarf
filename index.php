<?php  

ini_set('display_errors', 1);
ini_set('html_errors', 1);

$vendor = getcwd() . '/vendor';
require $vendor . '/autoload.php';

$app = new yarf\App();

$app->get('/')->to(function() {
    echo "Index";
});

$app->get('/example')->to('Example#collection');
$app->get('/example/:id')->to('Example#collectionById');

$app->run();


?>