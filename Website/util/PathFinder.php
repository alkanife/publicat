<?php
namespace Publicat\Util;

/**
 * Class for accessing /public directory (shorthand collection)
 */
trait PathFinder {

    /**
     * Get a public file's path
     *
     * @param string $path The path after 'public/'
     * @return string The public path
     */
    public function getPublicFile(string $path): string {
        return PUBLICAT_PUBLIC_PATH . $path;
    }

    /**
     * Shorthand for public files in style/
     *
     * @param string $file The file name
     * @return string The public path
     */
    public function css(string $file): string {
        return $this->getPublicFile('style/' . $file);
    }

    /**
     * Shorthand for public files in javascript/
     *
     * @param string $file The file name
     * @return string The public path
     */
    public function js(string $file): string {
        return $this->getPublicFile('javascript/' . $file);
    }

    /**
     * Shorthand for public files in media/
     *
     * @param string $file The file name
     * @return string The public path
     */
    public function media(string $file): string {
        return $this->getPublicFile('media/' . $file);
    }

    /**
     * Shorthand for public files in media/icon/
     *
     * @param string $file The file name
     * @return string The public path
     */
    public function icon(string $file): string {
        return $this->media('icon/' . $file);
    }

    /**
     * Shorthand for public files in media/logo/full/
     *
     * @param string $file The file name
     * @return string The public path
     */
    public function fullLogo(string $file): string {
        return $this->media('logo/full/' . $file);
    }

    /**
     * Shorthand for public files in media/logo/cat/
     *
     * @param string $file The file name
     * @return string The public path
     */
    public function catLogo(string $file): string {
        return $this->media('logo/cat/' . $file);
    }
}






