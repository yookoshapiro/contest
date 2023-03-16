<?php

declare(strict_types=1);

namespace Artisan\Contract;

interface DatabaseMigrateInterface
{
    
    /**
     * Funktion wird genutzt, um eine Tabelle zu zerstören.
     *
     * @return void
     */
    public function destroy(): void;


    /**
     * Funktion wird aufgerufen, um eine Tabelle zu erzeugen.
     *
     * @return void
     */
    public function create(): void;

}