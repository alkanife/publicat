<?php
namespace Publicat\Controller;

use Publicat\Util\Render;
use Throwable;

class HomeController extends Controller {
    use Render;

    /**
     * Redirect to homepage.
     * Method: GET|POST - Route: /
     *
     * @return void
     */
    public function index(): void {
        header('location: /home');
    }

    /**
     * Handle homepage.
     * Method: GET|POST - Route: /
     *
     * @return void
     * @throws Throwable
     */
    public function home(): void {
        $this->renderStartPage();

        $pageTitleState = 'home.title.' . ($this->isUserConnected() ? 'connected' : 'notConnected');

        $this->renderTitle($this->t($pageTitleState));
        $this->renderCSS('home/home.css');
        $this->renderView('home/Home.php');

        if (!empty($_GET['register'])) {
            $this->addRawJavascript('openModal(\'register-modal\')');
        } else if (!empty($_GET['login'])) {
            $this->addRawJavascript('openModal(\'login-modal\')');
        }

        if (!empty($_POST)) {
            if (isset($_POST['logMeOut'])) {
                if (!empty($this->getLoggedUser())) {
                    $this->setLoggedUser(null);
                    $this->createNotification($this->t('nav.profile.connected.logout.success'), 'success');
                }
            }
        }

        $this->renderEnd();
    }

    /**
     * Redirect to homepage (trigger register modal)
     * Method: GET - Route: /register
     *
     * @return void
     */
    public function register(): void {
        header('location: /home?register=1');
    }

    /**
     * Redirect to homepage (trigger login modal)
     * Method: GET - Route: /login
     *
     * @return void
     */
    public function login(): void {
        header('location: /home?login=1');
    }

}