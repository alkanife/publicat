<?php
namespace Publicat\Controller\JSON;

/**
 * Common class for JSON controllers
 */
class Middleware extends JSONController {

    /**
     * Absolutely all content returned by /json is JSON.
     *
     * @return void
     */
    public function middleware(): void {
        header('Content-Type: application/json');
    }
}