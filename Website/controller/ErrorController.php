<?php
namespace Publicat\Controller;

use Publicat\Util\Render;
use Throwable;

/**
 * Handle /error & 404
 */
class ErrorController extends Controller {
    use Render;

    /**
     * Handle error from HTTP response code (called by .htaccess, normally)
     * Method: GET|POST - Route: /error
     *
     * @return void
     */
    public function error() : void {
        $code = http_response_code();

        // If someone wants to access /error voluntarily, redirects to 404
        if ($code == 200)
            http_response_code(404);

        $this->getErrorHandler()->displayViewAndDie(http_response_code());
    }

    /**
     * Called by the router on Not Found errors.
     * Method: ALL - Route: ALL
     *
     * @return void
     * @throws Throwable
     */
    public function handle404() : void {
        $this->renderStartPage();
        $this->renderTitle($this->t('error.code.404.title'));
        $this->renderCSS('error/404.css');
        $this->renderView('error/404.php');
        $this->renderEnd();
    }
}