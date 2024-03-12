<?php
namespace Publicat\Util;

use JetBrains\PhpStorm\ExpectedValues;
use Publicat\model\user\Users;
use Throwable;

trait InputValidation {
    use Lang;

    /**
     * Trim and strip tags of user inputs
     *
     * @param mixed $string
     * @return string|null The cleaned string
     */
    public function cleanUserInput(mixed $string) : ?string {
        if (empty($string))
            return null;

        $string = strip_tags($string);
        return trim($string);
    }

    /**
     * A generic function to check on a text input
     *
     * @param mixed $input The value, will return false if it's not a string
     * @param int $minSize Minimum size (-1 to ignore)
     * @param int $maxSize Maximum size (-1 to ignore)
     * @param string|null $regex The required pattern (null to ignore)
     * @return bool
     */
    public function isTextInputValid(mixed $input, int $minSize = -1, int $maxSize = -1, ?string $regex = null): bool {
        if (empty($input)) {
            return false;
        }

        if (!is_string($input)) {
            return false;
        }

        $inputLength = strlen($input);

        if ($minSize != -1) {
            if ($inputLength < $minSize) {
                return false;
            }
        }

        if ($maxSize != -1) {
            if ($inputLength > $maxSize) {
                return false;
            }
        }

        if ($regex != null) {
            if (!preg_match($regex, $input)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the username is valid by checking criteria like size, format, and if it is already in use.
     *
     * @param mixed $username The username
     * @return array Response
     */
    public function isUsernameValid(mixed $username): array {
        if (gettype($username) != 'string') {
            $response = [];
            $response['isValid'] = false;
            return $response;
        }

        $username = $this->cleanUserInput($username);

        $response = [];

        $isValid = $this->isTextInputValid($username, MIN_USERNAME_SIZE, MAX_USERNAME_SIZE, REGEX_USERNAME);
        $response['isValid'] = $isValid;

        if ($isValid) {
            $userModel = new Users();
            $response['isTaken'] = $userModel->isUsernameTaken($username);
        }

        return $response;
    }

    /**
     * Check if the email address is valid by checking criteria like size, format, and if it is already in use.
     *
     * @param mixed $email The email address
     * @return array Response
     */
    public function isEmailValid(mixed $email): array {
        if (gettype($email) != 'string') {
            $response = [];
            $response['isValid'] = false;
            return $response;
        }

        $email = $this->cleanUserInput($email);
        $email = @strtolower($email);

        $response = [];

        $isValid = $this->isTextInputValid($email, MIN_EMAIL_SIZE, MAX_EMAIL_SIZE, REGEX_EMAIL);
        $response['isValid'] = $isValid;

        if ($isValid) {
            $userModel = new Users();
            $response['isTaken'] = $userModel->isEmailTaken($email);
        }

        return $response;
    }

    /**
     * Check if a given string date is valid
     *
     * @param string $date The date in mysql format
     * @return bool
     */
    public function isDateValid(string $date): bool {
        $dateArray = explode('-', $date);
        return checkdate($dateArray[1], $dateArray[2], $dateArray[0]);
    }

    /**
     * A generic function to check a file input
     *
     * @param string $inputName Input name ($_FILES)
     * @param int $maxSize Maximum file size in bytes
     * @param array $validExtensions A list of valid file extensions
     * @return string A string explaining the result
     */
    #[ExpectedValues(['ready', 'empty', 'error_size', 'error_internal', 'error_extension'])]
    public function checkFileInput(string $inputName, int $maxSize = 0, array $validExtensions = []): string {
        try {
            if (empty($_FILES)) {
                return 'empty';
            }

            if (!isset($_FILES[$inputName])) {
                return 'empty';
            }

            $file = $_FILES[$inputName];

            if (empty($file['name'])) {
                return 'empty';
            }

            if ($file['error'] == 4) {
                return 'empty';
            }

            if ($maxSize != 0) {
                if ($file['size'] > $maxSize) {
                    return 'error_size';
                }
            }

            if ($file['error'] == 1 || $file['error'] == 2) {
                return 'error_size';
            } else if ($file['error'] != 0) {
                return 'error_internal';
            }

            if (!empty($validExtensions)) {
                $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if(!array_key_exists($fileExtension, $validExtensions) || mime_content_type($file['tmp_name']) != $validExtensions[$fileExtension]) {
                    return 'error_extension';
                }
            }

            return 'ready';
        } catch (Throwable $t) {
            return 'error_internal';
        }
    }
}