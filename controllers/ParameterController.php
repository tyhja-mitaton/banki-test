<?php

namespace app\controllers;

use app\models\Parameter;
use app\models\ParameterSearch;
use Yii;
use yii\web\NotFoundHttpException;

class ParameterController extends \yii\web\Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ParameterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Parameter();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    public function actionFileDelete($id, $attribute)
    {
        $model = $this->findModel($id);
        $model->deleteImage($attribute);
        return $this->redirect(['update', 'id' => $model->id]);
    }

    protected function findModel($id)
    {
        if (($model = Parameter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}