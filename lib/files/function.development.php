<?php

declare(strict_types=1);

if( ! function_exists('dd'))
{
    /**
     * Gibt den übergebenen Wert durch die var_dump-Funktion aus und beendet das Skript.
     *
     * @param mixed ...$values
     * @return never
     **/
    function dd(mixed ...$values): never
    {

        foreach($values as $val)
        {
            echo '<pre class="dd">';
            var_dump( $val );
            echo '</pre>';
        }

        echo '<pre style="display: none">';
        debug_print_backtrace();
        echo '</pre>';

        die();

    }

}

if( ! function_exists('vdp'))
{
    /**
     * Gibt den übergebenen Wert durch die var_dump-Funktion aus.
     *
     * @param mixed ...$values
     * @return void
     **/
    function vdp(mixed ...$values): void
    {

        foreach($values as $val)
        {
            echo '<pre class="dd">';
            var_dump( $val );
            echo '</pre>';
        }

    }

}
