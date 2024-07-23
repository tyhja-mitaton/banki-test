<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Parameter;

/* @var $this yii\web\View */
/* @var $model \app\models\Parameter */
/* @var $form yii\widgets\ActiveForm */
$types = [Parameter::TYPE1 => 'Type 1', Parameter::TYPE2 => 'Type 2'];
?>

<div class="domain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList($types)?>
    <?php if($model->type == Parameter::TYPE2) { ?>
    <?= $form->field($model, 'imageFile')->widget(\kartik\file\FileInput::class, [
            'pluginOptions' => [
                'initialPreview' => [
                    $model->icon_path ? Html::img('/'.$model->icon_path, ['height' => 140]) : null,
                ],
                'initialPreviewConfig' => [
                    ['caption' => $model->icon_original_name,
                        'size' => $model->icon_path ? \app\models\File::getFileSize($model->icon_path) : null,
                    ]
                ],
                'browseClass' => 'btn btn-success',
                'showUpload' => false,
                'showCancel' => false,
                'showRemove' => false,
                'deleteUrl' => \yii\helpers\Url::to(['file-delete', 'id' => $model->id, 'attribute' => 'icon_path'], true),
                'fileActionSettings' => [
                    'showZoom' => false,
                    'showRotate' => false,
                ],
            ],
        ]) ?>
    <?= $form->field($model, 'imageFileGray')->widget(\kartik\file\FileInput::class, [
            'pluginOptions' => [
                'initialPreview' => [
                    $model->icon_gray_path ? Html::img('/'.$model->icon_gray_path, ['height' => 140]) : null,
                ],
                'initialPreviewConfig' => [
                    ['caption' => $model->icon_gray_original_name,
                        'size' => $model->icon_gray_path ? \app\models\File::getFileSize($model->icon_gray_path) : null,
                    ]
                ],
                'browseClass' => 'btn btn-success',
                'showUpload' => false,
                'showCancel' => false,
                'showRemove' => false,
                'deleteUrl' => \yii\helpers\Url::to(['file-delete', 'id' => $model->id, 'attribute' => 'icon_gray_path'], true),
                'fileActionSettings' => [
                    'showZoom' => false,
                    'showRotate' => false,
                ],
            ],
        ]) ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>