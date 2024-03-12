<?php
namespace Publicat\Util;

use Throwable;

/**
 * Manage and display views
 */
trait Render {
    use Lang;
    use PathFinder;

    /**
     * @var string Page title (not a key, real text)
     */
    private string $pageTitle;

    /**
     * @var array A list of css files
     */
    private array $css;

    /**
     * @var array A list of javascript files
     */
    private array $javascript;

    /**
     * @var array A list of raw javascript code, each of the values will have their own <script> tag
     */
    private array $rawJavascript;

    /**
     * @var array A list of files inside the view/ directory
     */
    private array $files;

    /**
     * @var bool If true the renderer will include common scripts and navbar
     */
    private bool $renderPage;

    /**
     * @var array Render arguments, used by the controller to send data to the views
     */
    private array $args;

    /**
     * Start the render process.
     * @return void
     */
    public function renderStart(): void {
        $this->pageTitle = 'Publicat';
        $this->css = [];
        $this->javascript = [];
        $this->files = [];
        $this->renderPage = false;
        $this->args = [];
    }

    /**
     * Start the render process of a page. Includes common parts like navbar
     * @return void
     */
    public function renderStartPage(): void {
        $this->renderStart();
        $this->renderPage = true;
    }

    /**
     * @return bool True if the page must have common parts (like default scripts and nav)
     */
    public function isPage(): bool {
        return $this->renderPage;
    }

    /**
     * Add a file to render
     *
     * @param string $file The file inside the view/ directory
     * @return void
     */
    public function renderView(string $file): void {
        $this->files[] = $file;
    }

    /**
     * The page title
     *
     * @param string $title The page title (not a key, real texte)
     * @return void
     */
    public function renderTitle(string $title): void {
        $this->pageTitle = $title;
    }

    /**
     * Add CSS files.
     *
     * @param ...$css string A list of CSS files
     * @return void
     */
    public function renderCSS(...$css): void {
        $this->css = $css;
    }

    /**
     * Add javascript files.
     *
     * @param ...$javascript string A list of JS files
     * @return void
     */
    public function renderJavascript(...$javascript): void {
        $this->javascript = $javascript;
    }

    /**
     * Add raw javascript code
     *
     * @param $jsCode string Raw javascript code, without <script> tag
     * @return void
     */
    public function addRawJavascript(string $jsCode): void {
        $this->rawJavascript[] = $jsCode;
    }

    /**
     * Get render arguments
     *
     * @return array
     */
    public function getArgs(): array {
        return $this->args;
    }

    /**
     * Add a render argument
     *
     * @param string $name Argument name
     * @param mixed $value Argument value
     * @return void
     */
    public function addArgument(string $name, mixed $value): void {
        $this->args[$name] = $value;
    }

    /**
     * Get a render argument
     *
     * @param string $name Argument name
     * @return mixed Null if nonexistent
     */
    public function getArg(string $name): mixed {
        if (array_key_exists($name, $this->args))
            return $this->args[$name];

        return null;
    }

    /**
     * Render the page
     * @return void
     * @throws Throwable
     */
    public function renderEnd(): void {
        // This function is a special case for error handling,
        // In order to display correctly error pages, and not the views AND the error page:
        // Turn on output buffering
        ob_start();

        try {
            // Handle queued notifications
            if (isset($_SESSION['notifications'])) {
                foreach ($_SESSION['notifications'] as $notification) {
                    $this->createNotification($notification['message'], $notification['type']);
                }

                $_SESSION['notifications'] = [];
            }

            // Include all required files
            $this->renderViewNow('commons/Header.php');

            foreach ($this->files as $file) {
                $this->renderViewNow($file);
            }

            $this->renderViewNow('commons/Footer.php');

            // Turn off output buffering and display everything
            ob_end_flush();
        } catch (Throwable $throwable) {
            // Turn off out buffering and erase previous content,
            ob_end_clean();

            // Then, throw the error and let the default error handler do its thing
            throw $throwable;
        }
    }

    /**
     * Directly include the file
     * @param string $file The file in the view/ directory
     * @return void
     */
    public function renderViewNow(string $file): void {
        include 'view/' . $file;
    }

    /**
     * Create a javascript notification at page render
     *
     * @param string $message Message
     * @param string $type Notification type (error, success)
     * @return void
     */
    public function createNotification(string $message, string $type = ''): void {
        $this->addRawJavascript("createNotification(\"$message\", \"$type\")");
    }

    /**
     * Format a given dateTime according to the LANG
     *
     * @param string $dateTime yyyy-mm-dd hh:mm:ss
     * @return string
     */
    public function formatUserDateTime(string $dateTime): string {
        $date = explode(' ', $dateTime)[0];
        $splitDate = explode('-', $date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $day = $splitDate[2];

        return $day . ' ' . $this->t('months.' . $month) . ' ' . $year;
    }
}











