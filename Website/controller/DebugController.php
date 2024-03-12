<?php
namespace Publicat\Controller;

use Publicat\Util\Error\ErrorHandler;
use PDO;
use Publicat\Util\InputUtils;
use Publicat\Util\Render;
use Throwable;

/**
 * Handle /debug route
 */
class DebugController extends Controller {
    use Render;
    use InputUtils;

    /**
     * Main debug page.
     * Method: ALL - Route: /debug
     *
     * @return void
     * @throws Throwable
     */
    public function main(): void {
        $this->renderStart();
        $this->renderCSS('debug/debug.css');
        $this->renderTitle('Debug panel');
        $this->renderView('debug/Debug.php');
        $this->renderEnd();
    }

    /**
     * View a specific error page.
     * Method: ALL - Route: /debug/view-error/{code}
     *
     * @param $code
     * @return void
     */
    public function viewError($code): void {
        $this->getErrorHandler()->displayViewAndDie(intval($code));
    }

    /**
     * Test the advanced error page.
     * Method: ALL - Route: /debug/test-advanced-error
     *
     * @return void
     */
    public function testAdvancedError(): void {
        $this->getErrorHandler()->addError('Test1', 'Message');
        $this->getErrorHandler()->addError('Test2', 'Message 1');
        $this->getErrorHandler()->addError('Test2', 'Message 2');

        try {
            new PDO('meow.');
        } catch (Throwable $t) {
            $this->getErrorHandler()->catchError($t);
        }

        $this->getErrorHandler()->displayViewAndDie();
    }

    /**
     * Print all lang keys.
     * Method: ALL - Route: /debug/lang
     *
     * @return void
     * @throws Throwable
     */
    public function lang(): void {
        $this->renderStart();
        $this->renderCSS('debug/debug.css');
        $this->renderJavascript('debug/table-toggle.js');
        $this->renderTitle('Lang');
        $this->renderView('debug/Lang.php');
        $this->renderEnd();
    }

    /**
     * Print phpinfo().
     * Method: ALL - Route: /debug/phpinfo
     *
     * @return void
     */
    public function php_info(): void {
        phpinfo();
    }

    /**
     * Destroy session
     * Method: ALL - Route: /debug/destroy-session
     *
     * @return void
     */
    public function destroySession(): void {
        session_unset();
        session_destroy();
        header('location: /debug');
    }

    /**
     * Dump variables
     * Method: ALL - Route: /debug/dump
     *
     * @return void
     * @throws Throwable
     */
    public function dump(): void {
        $this->renderStart();
        $this->renderCSS('debug/debug.css');
        $this->renderJavascript('debug/table-toggle.js');
        $this->renderTitle('Dump');
        $this->renderView('debug/Dump.php');
        $this->renderEnd();
    }

    /**
     * Register override
     * Method: ALL - Route: /debug/register
     *
     * @return void
     * @throws Throwable
     */
    public function register(): void {
        $this->renderStart();
        $this->renderCSS('debug/debug.css');
        $this->renderTitle('Register');
        $this->renderView('debug/Register.php');
        $this->renderEnd();
    }

    /**
     * Login override
     * Method: ALL - Route: /debug/login
     *
     * @return void
     * @throws Throwable
     */
    public function login(): void {
        $this->renderStart();
        $this->renderCSS('debug/debug.css');
        $this->renderTitle('Login');
        $this->renderView('debug/Login.php');
        $this->renderEnd();
    }

    /**
     * Hash password
     * Method: ALL - Route: /debug/hash-password
     *
     * @return void
     * @throws Throwable
     */
    public function hashPassword(): void {
        $hashedPassword = null;

        if (!empty($_POST)) {
            if (isset($_POST['password'])) {
                $hashedPassword = $this->hashUserPassword($_POST['password']);
            }
        }

        $this->renderStart();
        $this->renderCSS('debug/debug.css');
        $this->renderTitle('Hash password');
        $this->renderView('debug/HashPassword.php');
        $this->addArgument('password', $hashedPassword);
        $this->renderEnd();
    }

    /**
     * Print array values to table rows
     *
     * @param array $array
     * @param string $parentKey
     * @return void
     */
    public function printArrayValuesRow(array $array, string $parentKey = ''): void {
        foreach ($array as $key => $value) {
            $currentKey = $parentKey ? ($parentKey . '.' . $key) : $key;

            if (is_array($value)) {
                $this->printArrayValuesRow($value, $currentKey);
            } else {
                echo '<div class="row"><div>' . $currentKey . '</div><div><p class="orange">' . $value . '</p></div></div>';
            }
        }
    }
}