<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;

$log = new Logger('logger');

//This is a handler from the monolog library and in this case is use to print the logs in the stdout with the JSON format
$stdoutHandler = new \Monolog\Handler\ErrorLogHandler();
$formatter = new \Monolog\Formatter\JsonFormatter();
$stdoutHandler->setFormatter($formatter);


//This is a handler to create files for the logs of the application
//This is a Rotating handler, meaning that will generate a different file for every day by sufixing the date on the name tha we specify
$fileHandler = new \Monolog\Handler\RotatingFileHandler('../../logs/app.log', 0, Logger::DEBUG);
$fileHandler->setFormatter($formatter);

/*
$elasticClient = new \Elastica\Client(
    [
        "host" => "elasticsearch",
        "port" => 9200
    ]
);


//This is a handler from the monolog plugin called elastica that will send the logs to the elasticsearch
$elasticSearchHandler = new \Monolog\Handler\ElasticSearchHandler(
    $elasticClient,
    [
        'index' => 'test_index'
    ]
);
*/


//Here we push the handlers that we've created to the logger in order to have both ways to visualize the logs
$log->pushHandler($stdoutHandler);
$log->pushHandler($fileHandler);


//$log->pushHandler($elasticSearchHandler);

$log->info(
    'my first log',
		[
		    'app_name' => 'test app',
            'other_param' => 'some other value'
		]
);

$log->error(
    '¡Mi primer log error en Elasticsearch! (¡Y con emojis! 😬)',
		[
		    'app_name' => 'codelytv',
            'other_param' => 'CodelyTV FTW!'
		]
);