<?php

namespace app\models;

use yii\helpers\FileHelper;
use Yii;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

class File
{
    private $filepath;
    private $relativeFilePath;
    private $modelId;
    private $isGray;

    public $allowedTypeImages = ['jpg', 'jpeg', 'png'];

    public function __construct($filepath, $modelId, $isGray)
    {
        if (strpos($filepath, Yii::getAlias('@app')) === false) {
            $this->relativeFilePath = $filepath;
            $filepath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . ltrim($filepath, DIRECTORY_SEPARATOR);
        }
        if (!file_exists($filepath)) {
            FileHelper::createDirectory($filepath, $mode = 0755, $recursive = true);
        }

        $this->filepath = $filepath;
        $this->modelId = $modelId;
        $this->isGray = $isGray;
    }

    /**
     * @param UploadedFile $image
     * @return object|boolean
     */
    public function uploadImage(UploadedFile $image)
    {
        return $this->uploadFile($image, $this->allowedTypeImages);
    }

    public function uploadFile(UploadedFile $file, $allowedExtensions = [])
    {
        if ($file !== null && (empty($allowedExtensions) || in_array($file->extension, $allowedExtensions))) {
            $uniqueFileName = $this->generateUniqueName($file);
            $path = str_replace('{file}', $uniqueFileName, $this->filepath);
            if (strpos($path, $uniqueFileName) === false) {
                $path = $this->filepath . $uniqueFileName;
            }
            $relativePath = $this->relativeFilePath . $uniqueFileName;
            $file->saveAs($path);
            return (object)[
                'path' => $relativePath,
                'original_name' => $file->name
            ];
        }
        return false;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function getFileSize($path)
    {
        try {
            return filesize(Yii::getAlias('@app/web') . $path);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function generateUniqueName(UploadedFile $file)
    {
        return "{$this->modelId}_".preg_replace("/\s/", '_',strtolower(Inflector::transliterate($file->baseName))) .($this->isGray ? '_gray' : ''). '.' . $file->extension;
    }
}