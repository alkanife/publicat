<?php
namespace Publicat\Util;

/**
 * Some input utilities
 */
trait InputUtils {

    /**
     * Will hash the given string
     *
     * @param string $password Password
     * @return string Hash password
     */
    public function hashUserPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}