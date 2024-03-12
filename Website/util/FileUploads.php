<?php
namespace Publicat\Util;

use JetBrains\PhpStorm\ExpectedValues;
use Throwable;

/**
 * Manage file uploads
 */
trait FileUploads {

    /**
     * Upload a file that is in the TMP folder
     *
     * @param string $folder Folder in the /public/ directory
     * @param string $tmpName File tmp name
     * @param string $fileName The name the file will be given
     * @return string Success/Error code
     */
    public function uploadFile(string $folder, string $tmpName, string $fileName): string {
        try {
            if (move_uploaded_file($tmpName, './public/' . $folder . '/' . $fileName)) {
                return 'success';
            } else {
                return 'error_internal';
            }
        } catch (Throwable $t) {
            return 'error_internal';
        }
    }

    /**
     * Upload a file uploaded previously
     *
     * @param string $folder Folder in the /public/ directory
     * @param string|null $fileName File name
     * @return bool True if the file was deleted OR if the fileName given was NULL.
     */
    public function deleteFile(string $folder, ?string $fileName): bool {
        if ($fileName == null)
            return true;

        try {
            return unlink('./public/' . $folder . '/' . $fileName);
        } catch (Throwable $t) {
            return false;
        }
    }

    /**
     * Handle a picture upload
     *
     * @param string $inputName The input of the HTML file input
     * @return string A string representing an error code, OR the name of the uploaded picture if the operation was successful
     */
    #[ExpectedValues(['empty', 'error_size', 'error_internal', 'error_extension'])]
    public function handlePictureUpload(string $inputName): string {
        $fileInputValidation = $this->checkFileInput($inputName, PICTURE_SIZE, PICTURE_EXTENSIONS);

        if ($fileInputValidation != 'ready') {
            return $fileInputValidation;
        }

        $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $pictureName = $this->generateRandomName('user-media', $fileExtension);
        $uploadResult = $this->uploadFile('user-media', $_FILES[$inputName]['tmp_name'], $pictureName);

        if (str_starts_with($uploadResult, 'error')) {
            return $uploadResult;
        }

        return $pictureName;
    }

    /**
     * Generate a random file name
     *
     * @param string $folder The folder (after /public/)
     * @param string $extension (the file extension)
     * @return string Random name
     */
    private function generateRandomName(string $folder, string $extension): string {
        $randomName = uniqid('', true) . '.' . $extension;

        if (file_exists('./public/' . $folder . '/' . $randomName)) {
            return $this->generateRandomName($folder, $extension);
        }

        return $randomName;
    }
}