<?php

declare(strict_types=1);

use App\Http;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseFactoryInterface;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

$builder = new DI\ContainerBuilder();

$builder->addDefinitions([
    'config' => [
        'debug' => (bool)getenv('APP_DEBUG'),
    ],
]);

$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware($container->get('config')['debug'], true, true);

$app->get('/', Http\Action\HomeAction::class);

$app->run();