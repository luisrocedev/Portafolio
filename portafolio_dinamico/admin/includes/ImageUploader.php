<?php

/**
 * Utilidad para subida de imágenes
 * Soporta: JPG, PNG, GIF (incluyendo animados), WEBP
 */

class ImageUploader
{
    private $upload_dir = '../uploads/projects/';
    private $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $max_size = 10485760; // 10MB para GIFs animados

    public function __construct()
    {
        // Crear directorio si no existe
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }

    /**
     * Subir imagen
     * @param array $file Array de $_FILES
     * @return array ['success' => bool, 'message' => string, 'filename' => string]
     */
    public function upload($file)
    {
        // Validar que se subió un archivo
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return [
                'success' => false,
                'message' => 'No se seleccionó ningún archivo'
            ];
        }

        // Validar errores de subida
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $this->getUploadError($file['error'])
            ];
        }

        // Validar tipo de archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $this->allowed_types)) {
            return [
                'success' => false,
                'message' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF y WEBP'
            ];
        }

        // Validar tamaño
        if ($file['size'] > $this->max_size) {
            return [
                'success' => false,
                'message' => 'El archivo es demasiado grande (máx 10MB)'
            ];
        }

        // Generar nombre único
        $extension = $this->getExtension($mime_type);
        $filename = $this->generateUniqueFilename($extension);
        $filepath = $this->upload_dir . $filename;

        // Mover archivo
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Optimizar imagen (excepto GIF animado)
            if ($mime_type !== 'image/gif') {
                $this->optimizeImage($filepath, $mime_type);
            }

            return [
                'success' => true,
                'message' => 'Imagen subida exitosamente',
                'filename' => $filename,
                'url' => 'uploads/projects/' . $filename
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al guardar el archivo'
            ];
        }
    }

    /**
     * Eliminar imagen
     */
    public function delete($filename)
    {
        $filepath = $this->upload_dir . $filename;
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        return false;
    }

    /**
     * Obtener extensión según MIME type
     */
    private function getExtension($mime_type)
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp'
        ];
        return $extensions[$mime_type] ?? 'jpg';
    }

    /**
     * Generar nombre único
     */
    private function generateUniqueFilename($extension)
    {
        return 'project_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    }

    /**
     * Optimizar imagen (reducir tamaño sin perder calidad)
     */
    private function optimizeImage($filepath, $mime_type)
    {
        $max_width = 1200;
        $quality = 85;

        switch ($mime_type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filepath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filepath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filepath);
                break;
            default:
                return;
        }

        if (!$image) return;

        $width = imagesx($image);
        $height = imagesy($image);

        // Redimensionar si es muy grande
        if ($width > $max_width) {
            $new_width = $max_width;
            $new_height = intval($height * ($max_width / $width));

            $new_image = imagecreatetruecolor($new_width, $new_height);

            // Preservar transparencia en PNG
            if ($mime_type === 'image/png') {
                imagealphablending($new_image, false);
                imagesavealpha($new_image, true);
            }

            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            // Guardar
            switch ($mime_type) {
                case 'image/jpeg':
                    imagejpeg($new_image, $filepath, $quality);
                    break;
                case 'image/png':
                    imagepng($new_image, $filepath, 8);
                    break;
                case 'image/webp':
                    imagewebp($new_image, $filepath, $quality);
                    break;
            }

            imagedestroy($new_image);
        }

        imagedestroy($image);
    }

    /**
     * Obtener mensaje de error de subida
     */
    private function getUploadError($error_code)
    {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido',
            UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo del formulario',
            UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente',
            UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
            UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida'
        ];
        return $errors[$error_code] ?? 'Error desconocido';
    }
}
