<?php

namespace app\models;

use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $title
 * @property int $type
 * @property string $icon_path
 * @property string $icon_original_name
 * @property string $icon_gray_path
 * @property string $icon_gray_original_name
 */
class Parameter extends \yii\db\ActiveRecord
{
    const UPLOAD_PATH = 'uploads/';
    const TYPE1 = 1;
    const TYPE2 = 2;
    /**
     * @var UploadedFile
     */
    public $imageFile;
    /**
     * @var UploadedFile
     */
    public $imageFileGray;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%parameter}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['type'], 'integer'],
            [['title', 'icon_path', 'icon_original_name', 'icon_gray_path', 'icon_gray_original_name'], 'string'],
            [['imageFile', 'imageFileGray'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'type',
            'icons' => function() {
                return $this->getIcons();
            }
        ];
    }

    public function beforeSave($insert)
    {
        if(!$insert) {
            $this->uploadIcon();
            $this->uploadIcon(true);
            static $filePath;
            if (array_key_exists('icon_path', $this->dirtyAttributes) && isset($this->oldAttributes['icon_path'])) {
                $filePath = $this->oldAttributes['icon_path'];
            } elseif (array_key_exists('icon_gray_path', $this->dirtyAttributes) && isset($this->oldAttributes['icon_gray_path'])) {
                $filePath = $this->oldAttributes['icon_gray_path'];
            }
            if ($filePath && file_exists(\Yii::$app->basePath . '/web/' . $filePath)) {
                unlink(\Yii::$app->basePath . '/web/' . $filePath);
            }
        }
        return parent::beforeSave($insert);
    }

    public function deleteImage($attribute)
    {
        if($this->hasAttribute($attribute)) {
            $this->{$attribute} = null;
            $this->save(false, ["$attribute"]);
        }
    }

    public function getIcons()
    {
        return [
            'basic' => [
                'original_name' => $this->icon_original_name,
                'path' => Url::to('/'.$this->icon_path, true)
            ],
            'gray' => [
                'original_name' => $this->icon_gray_original_name,
                'path' => Url::to('/'.$this->icon_gray_path, true)
            ],
        ];
    }

    private function uploadIcon($isGray =  false) {
        $uploadIcon = UploadedFile::getInstance($this, $isGray ? 'imageFileGray' : 'imageFile');
        if(!empty($uploadIcon)){
            $upload = new File(self::UPLOAD_PATH, $this->id, $isGray);
            $image = $upload->uploadImage($uploadIcon);
            if($isGray){
                $this->icon_gray_path = $image->path;
                $this->icon_gray_original_name = $image->original_name;
            } else {
                $this->icon_path = $image->path;
                $this->icon_original_name = $image->original_name;
            }
        }
    }

}