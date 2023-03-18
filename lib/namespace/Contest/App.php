<?php

declare(strict_types=1);

namespace Contest;

use Contest\Exception\ApiException;
use Exception, Throwable;
use Slim\App as Slim;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Whoops\Run;
use Whoops\Handler\{PrettyPageHandler, JsonResponseHandler};

readonly class App
{

    protected Slim $slim;


    /**
     * Startet die Anwendung.
     *
     * @return void
     * @throws Throwable
     */
    public static function run(): void
    {

        try {
            (new self)->slim->run();
        }

        catch (Throwable $ex) {
            static::handleException($ex);
        }

        finally {
            static::endApplication();
        }

    }


    /**
     * Verarbeitet eine Fehlermeldung.
     *
     * @param Throwable $ex
     * @return void
     * @throws Throwable
     */
    protected static function handleException(Throwable $ex): void
    {

        $whoops = new Run;

        if ($ex instanceof ApiException) {
            $whoops->pushHandler( new JsonResponseHandler );
        }
        else {
            $whoops->pushHandler( new PrettyPageHandler );
        }

        $whoops->register();

        throw $ex;

    }


    /**
     * Ausführung am Ende der Anwendung, nachdem der Benutzer bereits eine Rückmeldung bekommen hat.
     *
     * @return void
     */
    protected static function endApplication(): void {
        // do something
    }


    /**
     * Erzeugt diese Klasse.
     *
     * @throws Exception
     */
    protected function __construct()
    {

        $container = require_once root_path('lib/files/bootstrap.php');
        $app = AppFactory::createFromContainer( $container );

        $container->set(Slim::class, $app);

        $app->addBodyParsingMiddleware();
        $app->add( $container->get(TwigMiddleware::class) );
        $app->group('', Router::class);

        $this->slim = $app;

    }

}