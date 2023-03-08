<?php

declare(strict_types=1);

/**
 * Gibt den Pfad zum Root-Ordner wieder.
 *
 * @param string|null $path
 * @return string
 */
function root_path(?string $path = null): string {
    return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $path;
}