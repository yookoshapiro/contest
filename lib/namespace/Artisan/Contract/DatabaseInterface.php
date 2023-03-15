<?php

declare(strict_types=1);

namespace Artisan\Contract;

interface DatabaseInterface
{

    /**
     * Leert die Datenbank, wenn nötig.
     *
     * @return void
     */
    public function down(): void;


    /**
     * Befüllt die Datenbank mit zufälligen Daten.
     *
     * @return void
     */
    public function up(): void;

}