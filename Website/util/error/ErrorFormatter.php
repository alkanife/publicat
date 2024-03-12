<?php

namespace Publicat\Util\Error;

use Throwable;

/**
 * Format errors
 */
class ErrorFormatter {

    /**
     * Convert a throwable into an array of HTML errors
     *
     * @param Throwable|null $throwable
     * @return array
     */
    public function traceToHTML(Throwable|null $throwable): array {
        if ($throwable == null) {
            return [
                'message' => null,
                'source' => null,
                'trace' => []
            ];
        }

        $htmlMessage = null;
        $htmlSource = null;
        $htmlTraces = [];

        if ($throwable->getMessage() != null)
            $htmlMessage = '<span class="red"><b>' . $throwable->getMessage() . '</b></span>';

        if ($throwable->getFile() != null) {
            $sourceFile = $this->formatFilePath($throwable->getFile(), 'red');
            $sourceLine = $this->formatLine($throwable->getLine(), 'red');
            $htmlSource = $sourceFile . ' ' . $sourceLine;
        }

        foreach ($throwable->getTrace() as $traceKey => $trace) {
            $htmlTrace = [];

            $htmlTrace['index'] = $traceKey + 1;

            if (array_key_exists('file', $trace)) {
                $htmlTrace['file'] = $this->formatFilePath($trace['file'], 'red');
            } else {
                $htmlTrace['file'] = $this->getUnknown();
            }

            if (array_key_exists('class', $trace)) {
                $htmlTrace['class'] = '<span class="red">' . $trace['class'] . '</span>';
            } else {
                $htmlTrace['class'] = $this->getUnknown();
            }

            $functionAndLine = $this->getUnknown();

            if (array_key_exists('function', $trace)) {
                $functionAndLine = '<span class="red">' . $trace['function'] . '</span>';
            }

            if (array_key_exists('line', $trace)) {
                $functionAndLine .= ' ' . $this->formatLine($trace['line']);
            }

            $htmlTrace['functionAndLine'] = $functionAndLine;

            $htmlTraces[] = $htmlTrace;
        }

        return [
            'message' => $htmlMessage,
            'source' => $htmlSource,
            'trace' => $htmlTraces
        ];
    }

    /**
     * Convert the errors contained in the ErrorHandler into a JSON response
     *
     * @param int $errorCode The response code
     * @param ErrorHandler $errorHandler The ErrorHandler
     * @return array JSON-ready array
     */
    public function createJsonResponse(int $errorCode = 0, ErrorHandler $errorHandler): array {
        $response['error']['code'] = $errorCode;

        if ($errorHandler->getJsonMessage() !== null)
            $response['error']['message'] = $errorHandler->getJsonMessage();

        if ($errorHandler->hasAnyErrors() && PUBLICAT_DEV) {
            $response['error']['debug'] = [
                '_info' => 'You are seeing this message because Publicat is in developer mode.'
            ];

            if ($errorHandler->hasCaughtErrors()) {
                foreach ($errorHandler->getHtmlCaughtErrors() as $error) {
                    $responseTrace = [];

                    if (!empty($error['trace'])) {
                        foreach ($error['trace'] as $trace) {
                            $responseTrace['file'] = strip_tags($trace['file']);
                            $responseTrace['class'] = strip_tags($trace['class']);
                            $responseTrace['functionAndLine'] = strip_tags($trace['functionAndLine']);
                        }
                    }

                    $response['error']['debug']['caught'][] = [
                        'message' => strip_tags($error['message']),
                        'source' => strip_tags($error['source']),
                        'trace' => $responseTrace
                    ];
                }
            }

            if ($errorHandler->hasErrors()) {
                foreach ($errorHandler->getErrors() as $errorKey => $errorMessages) {
                    $messages = [];

                    if (!empty($errorMessages)) {
                        foreach ($errorMessages as $message) {
                            $messages[] = $message;
                        }
                    }

                    $response['error']['debug']['encountered'][] = [
                        'messages' => $messages,
                        'key' => $errorKey
                    ];
                }
            }
        }

        return $response;
    }

    /**
     * Fonction for traceToHTML().
     * Format the given file path
     *
     * @param string $filePath
     * @param ?string $color Color class name
     * @return string HTML span
     */
    private function formatFilePath(string $filePath, ?string $color = ''): string {
        $path = explode(DIRECTORY_SEPARATOR, $filePath);

        $fileName = '<span class="' . $color . '">' . end($path) . '</span>';
        $folder = prev($path);

        return '<span class="gray">..' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . '</span>' . $fileName;
    }

    /**
     * Fonction for traceToHTML().
     * Format the given code line
     *
     * @param int $line
     * @param ?string $color Color class name
     * @return string HTML span
     */
    private function formatLine(int $line, ?string $color = ''): string {
        return '<span class="gray">line</span> <span class="' . $color . '">' .  $line . '</span>';
    }

    /**
     * Fonction for traceToHTML().
     *
     * @return string HTML span
     */
    private function getUnknown(): string {
        return '<span class="gray">-</span>';
    }
}