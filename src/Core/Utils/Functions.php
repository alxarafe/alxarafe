<?php

/**
 * Crea una carpeta con los permisos seleccionados.
 *
 * @author  Rafael San José Tovar <rafael.sanjose@x-netdigital.com>
 * @version 2022.1216
 *
 * @param string $directory
 * @param int    $permissions
 * @param bool   $recursive
 *
 * @return bool
 */
function createDir(string $directory, int $permissions = 0777, bool $recursive = true): bool
{
    return (\is_dir($directory) || @\mkdir($directory, $permissions, $recursive) || \is_dir($directory));
}
