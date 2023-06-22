<?php

namespace App\Utils;

class RouteHelper
{
    public static function includeRouteFiles(string $folder): void
    {
        // Iterate through the v1 folder recursively for route files

        $dirIterator = new \RecursiveDirectoryIterator($folder);

        /** @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator $it */
        $it = new \RecursiveIteratorIterator($dirIterator);
        // require the file in each iteration

        while ($it->valid()) {
            if(!$it->isDot()
                && $it->isFile()
                && $it->isReadable()
                && $it->current()->getExtension() === 'php' )
            {
                require $it->key();
            }
            $it->next();
        }
    }
}
