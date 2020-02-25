<?php


namespace app\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model

{
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'required'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];

    }
    public function uploadImage(UploadedFile $file, $currentImage)
    {
        $this->imageFile = $file;

        if($this->validate())
        {
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage(); //bool
        }
    }
    public function deleteCurrentImage($currentImage)
    {
        if(is_file($this->getFolder() . $currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }
    public function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    public function generateFileName($file)
    {
        return (strtolower(md5(uniqid($file->baseName))) . '.' . $file->extension);
    }

    public function saveImage()
    {
        $filename = $this->generateFileName($this->imageFile);

        $this->imageFile->saveAs($this->getFolder() . $filename);
        return $filename;

    }
}