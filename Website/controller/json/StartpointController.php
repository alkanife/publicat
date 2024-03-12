<?php
namespace Publicat\Controller\JSON;

/**
 * Controller for the /json startpoint
 */
class StartpointController extends JSONController {

    /**
     * Base endpoint.
     * Method: ALL - Route: /json
     *
     * @return void
     */
    public function startpoint(): void {
        $this->triggerNotFound();
    }
}