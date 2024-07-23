<?php

namespace app\controllers;

use app\models\Parameter;
use yii\data\ActiveDataProvider;

class ParamController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Parameter';

    public function actionGraphic()
    {
        return new ActiveDataProvider([
            'query' => Parameter::find()->where(['type' => Parameter::TYPE2])
        ]);
    }
}
