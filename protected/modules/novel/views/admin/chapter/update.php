<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\novel\models\NovelPage */

$this->title = Yii::t('NovelModule.base', 'Edit ', [
    'modelClass' => 'Chapter',
]) . $model->number;
$this->params['breadcrumbs'][] = ['label' => Yii::t('NovelModule.base', 'Chapters'), 'url' => ['admin/chapter']];
$this->params['breadcrumbs'][] = Yii::t('NovelModule.base', 'Chapter #{number}', array('number' => $model->number));
$this->params['breadcrumbs'][] = Yii::t('NovelModule.base', 'Edit');

echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);

?>

<div class="panel panel-default">
    <div class="panel-heading"><strong><?php echo $this->title; ?></strong></div>
    <div class="panel-body">

        <div class="matching-questions-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div>
</div>
