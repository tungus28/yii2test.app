<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FooForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public $filename;

    public $path;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv, txt'],
        ];
    }
}
