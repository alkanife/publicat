<?php
namespace Publicat\Controller;

use Publicat\Util\Error\ErrorHandler;
use Publicat\Util\UserUtils;

/**
 * Common class for controllers
 */
class Controller {
    use UserUtils;

    /**
     * @var ErrorHandler Common error handler
     */
    private ErrorHandler $errorHandler;

    public function __construct($errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    /**
     * Get common error handler
     *
     * @return ErrorHandler
     */
    protected function getErrorHandler(): ErrorHandler {
        return $this->errorHandler;
    }

    /**
     * Queue notifications using the session.
     *
     * @param string $id Notification id (can be anything)
     * @param string $message Message
     * @param string $type Notification type ('', error, success)
     * @return void
     */
    protected function queueNotification(string $id, string $message, string $type): void {
        $_SESSION['notifications'][$id] = [
            'message' => $message,
            'type' => $type
        ];
    }
}