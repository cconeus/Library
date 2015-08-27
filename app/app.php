<? php
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../src/Librarian.php";
require_once __DIR__."/../src/Patron.php";

$app = new Silex\Application();

$server = 'mysql:host=localhost:8889;dbname=Library';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

?>
