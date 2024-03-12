<?php
namespace Publicat\Util;

use Publicat\Util\Error\ErrorHandler;
use Throwable;

/**
 * Class for loading files and creating common classes and tools
 */
class Loader {

    /**
     * @var bool Will die if ANY errors is encountered
     */
    protected bool $dieOnError = true;

    /**
     * @var ErrorHandler Error handler
     */
    protected ErrorHandler $errorHandler;

    /**
     * Entry point - Will load all the required files and exit if an error is encountered
     *
     * @return void
     */
    public function load(): void {
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $publicatUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/';
        define('PUBLICAT_URL', $publicatUrl);
        define('PUBLICAT_PUBLIC_PATH', $publicatUrl . 'public/');

        $this->requireFolder('config/');
        $this->requireFile('lang/' . PUBLICAT_LANG . '.php');

        $this->requireFile('util/Lang.php');
        $this->requireFile('util/PathFinder.php');
        $this->requireFile('util/InputUtils.php');
        $this->requireFile('util/InputValidation.php');
        $this->requireFile('util/FileUploads.php');
        $this->requireFile('util/Render.php');
        $this->requireFile('util/UserUtils.php');

        $this->requireFile('util/error/ErrorFormatter.php');
        $this->requireFile('util/error/ErrorHandler.php');

        $this->requireFile('util/Router.php');

        $this->errorHandler = new ErrorHandler();
        $this->dieOnError = false;

        // Die if the website is in Maintenance mode
        if (PUBLICAT_MAINTENANCE) {
            http_response_code(503);
            $this->errorHandler->displayViewAndDie(503);
        }

        $this->requireFolder('controller/');
        $this->requireFolder('model/');

        // Die if errors are caught
        if ($this->errorHandler->hasAnyErrors())
            $this->errorHandler->displayViewAndDie(500);
    }

    /**
     * Require a file without warnings
     *
     * @param string $fileName The complete file name
     * @return void
     */
    private function requireFile(string $fileName): void {
        try {
            @require_once $fileName;
        } catch (Throwable $t) {
            $this->handleError('The file "' . $fileName . '" was not found or caused an error.', $t);
        }
    }

    /**
     * Require folder content without warnings (recursive)
     *
     * @param string $folderName The complete folder name (with /)
     * @param array $exclude Files to not require
     * @return void
     */
    private function requireFolder(string $folderName, array $exclude = []): void {
        if (!file_exists($folderName)) {
            $this->handleError('The folder "' . $folderName . '" does not exists.');
            return;
        }

        if (!is_dir($folderName)) {
            $this->handleError('The folder "' . $folderName . '" is not a folder.');
            return;
        }

        $files = scandir($folderName);
        $files = array_diff($files, array('.', '..'));

        if (empty($files)) {
            $this->handleError('The folder "' . $folderName . '" is empty.');
            return;
        }

        foreach ($files as $file) {
            if (in_array($file, $exclude))
                continue;

            $filePath = $folderName . $file;

            if (is_dir($filePath))
                $this->requireFolder($filePath . '/');
            else
                $this->requireFile($filePath);
        }
    }

    /**
     * Handle errors
     *
     * @param string $message Error message
     * @param mixed $trace Error traces
     * @return void
     */
    private function handleError(string $message, $trace = null): void {
        if ($this->dieOnError) {
            http_response_code(500);

            if (PUBLICAT_DEV) {
                ?>
                <style>* {font-family: monospace;}</style>
                <h3>
                    ----------------------------------------------------------------------------------------------------<br>
                    /!\ A core file is missing or caused an error, which prevented Publicat from processing the request.<br>
                    ----------------------------------------------------------------------------------------------------
                </h3>
                <p><?= $message ?></p>
                <?php

                if ($trace != null)
                    echo '<table>' . @$trace->xdebug_message . '</table>';

                die();
            } else {
                die("Internal Server Error");
            }
        }

        if (isset($trace))
            $this->errorHandler->catchError($trace);
        else
            $this->errorHandler->addError('loader', $message);
    }

    /**
     * @return ErrorHandler Created ErrorHandler
     */
    public function getErrorHandler(): ErrorHandler {
        return $this->errorHandler;
    }
}