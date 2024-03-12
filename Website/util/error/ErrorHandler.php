<?php
namespace Publicat\Util\Error;

use Publicat\Util\Lang;
use Publicat\Util\Render;
use Throwable;

/**
 * Manage errors
 */
class ErrorHandler {
    use Render;

    /**
     * @var array Simple errors with no Throwables
     */
    private array $errors = [];

    /**
     * @var array Errors that were caught in a try/catch block
     */
    private array $caughtErrors = [];

    /**
     * @var array The error to display to the user
     */
    private array $displayError = [
        'code' => null,
        'title' => null,
        'message' => null
    ];

    /**
     * @var string|null This message will be shown on JSON errors
     */
    private string|null $jsonMessage = null;

    /**
     * Set the display error to 'unknown' by default
     */
    public function __construct() {
        $this->setDisplayError(0);
    }

    /**
     * Get simple errors with no throwables
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * @param string $for
     * @return array|null
     */
    public function getErrorsFor(string $for): array|null {
        if ($this->hasErrors($for)) {
            return $this->getErrors()[$for];
        }

        return null;
    }

    /**
     * Returns true if there is errors.
     * @param string|null $for
     * @return bool
     */
    public function hasErrors(string $for = null): bool {
        if ($for == null) {
            return !empty($this->errors);
        }

        if (array_key_exists($for, $this->errors)) {
            return !empty($this->errors[$for]);
        }

        return false;
    }

    /**
     * Add a simple error with no throwable
     *
     * @param $key string Error key
     * @param $value string Message
     * @return void
     */
    public function addError(string $key, string $value): void {
        $this->errors[$key][] = $value;
    }

    /**
     * Get errors with throwables
     * @return array
     */
    public function getCaughtErrors(): array {
        return $this->caughtErrors;
    }

    /**
     * @return array of html-formatted errors with trace
     */
    public function getHtmlCaughtErrors(): array {
        $formatter = new ErrorFormatter();

        if (!$this->hasCaughtErrors())
            return [];

        $htmlErrors = [];

        foreach ($this->getCaughtErrors() as $throwable)
            $htmlErrors[] = $formatter->traceToHTML($throwable);

        return $htmlErrors;
    }

    /**
     * Returns true if there is errors that where caught in a try/catch block.
     * @return bool
     */
    public function hasCaughtErrors(): bool {
        return !empty($this->caughtErrors);
    }

    /**
     * Catch an error (try/catch block)
     *
     * @param Throwable $throwable Caught
     * @return void
     */
    public function catchError(Throwable $throwable): void {
        $this->caughtErrors[] = $throwable;
    }

    /**
     * Returns true if there is either normal or caught errors.
     * @return bool
     */
    public function hasAnyErrors(): bool {
        return $this->hasErrors() || $this->hasCaughtErrors();
    }

    /**
     * Get the error that will be shown in the view
     * @return array
     */
    public function getDisplayError(): array {
        return $this->displayError;
    }

    /**
     * @param string $message Set the message that display with /api endpoints errors
     * @return void
     */
    public function setJsonMessage(string $message): void {
        $this->jsonMessage = $message;
    }

    /**
     * If the error triggers on a API request, it will display this message.
     * @return string|null
     */
    public function getJsonMessage(): string|null {
        return $this->jsonMessage;
    }

    /**
     * Set messages from error code.
     * The error code will be verified in a list of valid error codes, if the code is not found, this function will the set the 'unknown' value.
     * If a title or a message is given, they will override the code's default message.
     *
     * @param $code int the error code (404, 500...)
     * @param $title string|null Override error title
     * @param $message string|null Override error message
     * @return void
     */
    public function setDisplayError(int $code, string|null $title = null, string|null $message = null): void {
        $validErrorCodes = [400, 401, 403, 404, 405, 406, 407, 412, 414, 415, 418, 500, 501, 502, 503];

        $key = 'unknown';

        if (in_array($code, $validErrorCodes))
            $key = 'code.' . $code;

        if (!isset($title))
            $title = 'error.' . $key . '.title';

        if (!isset($message))
            $message = 'error.' . $key . '.message';

        $this->displayError = [
            'code' => $code,
            'title' => $title,
            'message' => $message
        ];

    }

    /**
     * Render the error page with the display error
     *
     * @param $errorCode int shorthand for setDisplayError
     * @return void
     */
    public function displayViewAndDie(int $errorCode = 0): void {
        if (http_response_code() == 200)
            http_response_code(500);

        if ($errorCode != 0)
            $this->setDisplayError($errorCode);

        // If the error is from an API request, return JSON
        if (str_starts_with($_SERVER['REQUEST_URI'], '/json')) {
            try {
                $formatter = new ErrorFormatter();

                echo json_encode($formatter->createJsonResponse($errorCode, $this));
            } catch (Throwable $t) {
                echo json_encode(['error' => ['code' => 500]]);
            }
        }

        // Otherwise render error page
        else {
            try {
                $this->renderStart();
                $this->renderTitle($this->t($this->displayError['title']));

                if ($this->hasAnyErrors() && PUBLICAT_DEV) {
                    $this->renderCSS('error/advanced-error.css');
                    $this->renderJavascript('debug/table-toggle.js');
                    $this->renderView('error/AdvancedError.php');
                } else {
                    $this->renderCSS('error/error.css');
                    $this->renderView('error/Error.php');
                }

                $this->renderEnd();
            } catch (Throwable $t) {
                if (PUBLICAT_DEV)
                    die('Can not display error (ErrorHandler)');
                else
                    die('Internal Server Error');
            }
        }

        die();
    }
}