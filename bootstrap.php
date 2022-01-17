<?php

use Clue\React\SQLite\DatabaseInterface;
use Clue\React\SQLite\Factory;
use React\ChildProcess\Process;
use React\EventLoop\Loop;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

require __DIR__ . '/vendor/autoload.php';

const SQLITE_DB_PATH = __DIR__ . '/sqlite.db';
const TEMPLATE_FOLDER = __DIR__ . '/resources/views/';
const MIGRATION_JOB = __DIR__ . '/migrate.php';

/**
 * @return DatabaseInterface
 */
function sqliteConnection()
{
    static $db = null;

    if (is_null($db)) {
        $factory = new Factory();
        $db = $factory->openLazy(SQLITE_DB_PATH);
    }

    return $db;
}

/**
 * @return Environment
 */
function getTwig()
{
    static $twig = null;

    if (is_null($twig)) {
        $absolute = realpath(TEMPLATE_FOLDER);
        $directory = new RecursiveDirectoryIterator($absolute);
        $iterator = new RecursiveIteratorIterator($directory);
        $regex = new RegexIterator($iterator, '/^.+\.twig/i', RegexIterator::GET_MATCH);

        $templates = array_reduce(iterator_to_array($regex), function ($carry, $item) use ($absolute) {
            $filePath = reset($item);
            $templateName = trim(str_replace($absolute, '', $filePath), '/');
            $carry[$templateName] = file_get_contents($filePath);
            return $carry;
        }, []);

        $loader = new ArrayLoader($templates);
        $twig = new Environment($loader);

//        $twig->addFilter(new TwigFilter('route', function () {
//        }));
    }
    return $twig;
}

function resetMigration()
{
    $process = new Process(sprintf('php %s', MIGRATION_JOB));
    Loop::addPeriodicTimer(60 * 30, function () use ($process) {
        $process->start();
    });
}

// cache templates
getTwig();
