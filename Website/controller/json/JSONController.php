<?php
namespace Publicat\Controller\JSON;

use Publicat\Controller\Controller;

/**
 * Common class for JSON controllers
 */
class JSONController extends Controller {

    /**
     * Trigger a 404 error
     *
     * @return void
     */
    public function triggerNotFound(): void {
        http_response_code(404);
        $this->getErrorHandler()->setJsonMessage('The requested endpoint has not been found, or has no content.');
        $this->getErrorHandler()->displayViewAndDie(404);
    }

    /**
     * Trigger a 405 error
     *
     * @return void
     */
    public function triggerNotAllowed(): void {
        http_response_code(405);
        $this->getErrorHandler()->displayViewAndDie(405);
    }

    /**
     * Decode JSON request
     *
     * @return array
     */
    public function getRequest(): array {
        $content = trim(file_get_contents("php://input"));
        return json_decode($content, true);
    }

    /**
     * Generates an JSON error.
     *
     * @param int $code
     * @param string|null $message
     * @return void
     */
    public function apiError(int $code, ?string $message = null): void {
        http_response_code($code);

        if ($message != null)
            $this->getErrorHandler()->setJsonMessage($message);

        $this->getErrorHandler()->displayViewAndDie($code);
    }
}