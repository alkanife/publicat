<?php
namespace Publicat\Util;

use Throwable;
use ValueError;

/**
 * Manage LANG translations
 */
trait Lang {

    /**
     * Will translate the given key to the correct string
     *
     * @param string $langPath The path to the translation
     * @param string ...$args Optional arguments (%s)
     * @return string Translated string & formatted string
     */
    public function t(string $langPath, string ...$args): string {
        $value = $this->getValue($langPath);

        if (!isset($value)) {
            return $this->invalidTag('Missing translation: \'' . $langPath . '\'');
        }

        if (is_array($value)) {
            return $this->invalidTag('Array: \'' . $langPath . '\'');
        }

        if (!empty($args)) {
            try {
                return vsprintf($value, $args);
            } catch (ValueError $e) {
                return $this->invalidTag('Less arguments: \'' . $langPath . '\'');
            }
        }

        try {
            return $value;
        } catch (Throwable $e) {
            return $this->invalidTag('Error: \'' . $langPath . '\'');
        }
    }

    /**
     * Will return all values of the provided path as an array
     *
     * @param string $langPath The path to the translation
     * @param bool $stringOnly If true, will exclude other arrays
     * @return array An array of the values (string)
     */
    public function t_array(string $langPath, bool $stringOnly = false): array {
        $value = $this->getValue($langPath);

        if (!isset($value)) {
            return [$this->invalidTag('Missing array: \'' . $langPath . '\'')];
        }

        $response = [];

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                if (!($stringOnly && is_array($val))) {
                    $response[$key] = $val;
                }
            }
        } else {
            $response[] = $value;
        }

        return $response;
    }

    /**
     * Get values of the provided path.
     *
     * @param string $langPath The path to the desired value
     * @return mixed Values
     */
    private function getValue(string $langPath): mixed {
        $keys = explode('.', $langPath);

        $value = LANG;

        foreach ($keys as $key)
            $value = $value[$key] ?? null;

        return $value;
    }

    /**
     * Return an invalid tag string
     *
     * @param string $content
     * @return string
     */
    private function invalidTag(string $content): string {
        return '{{' . $content . '}}';
    }
}