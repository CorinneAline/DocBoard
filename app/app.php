<?php


use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;


// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();


// Register service providers
$app->register(new Silex\Provider\DoctrineServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new DocBoard\DAO\UserDAO($app['db']);
            },
        ),
    ),    
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider());

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/docboard.log',
    'monolog.name' => 'DocBoard',
    'monolog.level' => $app['monolog.level']
));

$app->register(new Silex\Provider\ValidatorServiceProvider());


// Register services
$app['dao.book'] = function ($app) {
    $bookDAO = new DocBoard\DAO\BookDAO($app['db']);    
    $bookDAO->setAuthorDAO($app['dao.author']);    
    return $bookDAO;
};

$app['dao.author'] = function ($app) {
    return new DocBoard\DAO\AuthorDAO($app['db']);
};

$app['dao.article'] = function ($app) {

    return new DocBoard\DAO\ArticleDAO($app['db']);

};

$app['dao.user'] = function ($app) {
    return new DocBoard\DAO\UserDAO($app['db']);
};

$app['dao.comment'] = function ($app) {
    $commentDAO = new DocBoard\DAO\CommentDAO($app['db']);
    $commentDAO->setArticleDAO($app['dao.article']);
    $commentDAO->setUserDAO($app['dao.user']);
    return $commentDAO;
};

$app['dao.link'] = function ($app) {
    $linkDAO = new DocBoard\DAO\LinkDAO($app['db']);
    $linkDAO->setUserDAO($app['dao.user']);
    return $linkDAO;
};

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});

// Register JSON data decoder for JSON requests
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});


//Custom encoder factory
$app['security.default_encoder'] = function ($app) {
    return $app['security.encoder.digest'];
};

// Register error handler
$app->error(function (Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = 'Something went wrong.';
    }
    return $app['twig']->render('error.html.twig', array(
        'message' => $message
    ));
});