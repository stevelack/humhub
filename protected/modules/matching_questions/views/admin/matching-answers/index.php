<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\Breadcrumbs;

$this->title = Yii::t('MatchingQuestionsModule.base', 'Matching Answers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('MatchingQuestionsModule.base', 'Matching Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('MatchingQuestionsModule.base', 'Matching Question').' '.$matching_question->id_code;
$this->params['breadcrumbs'][] = $this->title;

echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?php echo Yii::t('MatchingQuestionsModule.base', 'Matching Answers'); ?></h3>
    </div>
    <div class="panel-body">

        <?php echo Html::a(Yii::t('MatchingQuestionsModule.base', 'Create new Matching Answer'), ['create-matching-answers', 'id' => $matching_question->id], array('class' => 'btn btn-success')); ?>
        
        <br><br>
        
        <?php if (count($matching_answers) != 0): ?>
        
            <table class="table">
                <tr>
                    <th><?php echo Yii::t('MatchingQuestionsModule.base', 'ID Code'); ?></th>
                    <th class="col-md-5"><?php echo Yii::t('MatchingQuestionsModule.base', 'Description'); ?></th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($matching_answers as $matching_question): ?>
                    <tr>
                        <td><?php //echo $matching_question->id_code; ?></td>
                        <td><?php echo $matching_question->description; ?></td>
                        <td>
                            <?php echo Html::a(
                                Yii::t('MatchingQuestionsModule.base', 'View translations'),
                                ['index-matching-answer-translations', 'id' => $matching_question->id], array('class' => 'btn btn-warning btn-sm')); ?>
                            &nbsp;&nbsp;
                            <?php echo Html::a(
                                Yii::t('MatchingQuestionsModule.base', 'Update'),
                                ['update-matching-answers', 'id' => $matching_question->id], array('class' => 'btn btn-primary btn-sm')); ?>
                            &nbsp;&nbsp;
                            <?php echo Html::a(
                                Yii::t('MatchingQuestionsModule.base', 'Delete'),
                                ['delete-matching-answers', 'id' => $matching_question->id], array(
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                                )); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else: ?>

            <p><?php echo Yii::t('MatchingQuestionsModule.base', 'No missions created yet!'); ?></p>


        <?php endif; ?>

    </div>
</div>
