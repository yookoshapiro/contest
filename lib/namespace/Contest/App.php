<?php

declare(strict_types=1);

namespace Contest;

use Exception, Throwable;
use DI\{Container, ContainerBuilder};

use Slim\App as Slim;
use Slim\Factory\AppFactory;
use Illuminate\Database\Connection;

use Whoops\Run;
use Contest\Exception\ApiException;
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

        $container = $this->getContainer();
        $app = AppFactory::createFromContainer( $container );

        $container->set(Slim::class, $app);
        $container->get(Connection::class); # Aufruf der Verbindung, damit die Einstellungen geladen werden

        $app->addBodyParsingMiddleware();
        $app->group('', Router::class);

        $this->slim = $app;

    }


    /**
     * Erzeugt den DI-Container.
     *
     * @return Container
     * @throws Exception
     */
    protected function getContainer(): Container
    {

        $builder = new ContainerBuilder();
        $builder->addDefinitions( root_path('lib/files/di.definitions.php') );

        return $builder->build();

    }

}