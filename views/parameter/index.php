<?php

/** @var yii\web\View $this */
/* @var $searchModel \app\models\ParameterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parameters';
?>
<div class="site-index">
    <div class="body-content">
        <div class="page-header mb-3">
            <h1 class="page-title"><span class="subpage-title"><?= $this->title ?></h1>
            <div class="ml-auto">
                <div class="input-group">
                    <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-info btn-icon mr-2" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
                <span>
                    <i class="fe fe-plus"></i> Create
                </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                            'id',
                        'title',
                        'type',
                        ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
