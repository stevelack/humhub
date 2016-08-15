<?php

use yii\helpers\Html;

$this->pageTitle = Yii::t('UserModule.views_auth_createAccount', 'Create Account');
?>

<div class="container" style="text-align: center;">
    <h1 id="app-title" class="animated fadeIn"><?php echo Html::encode(Yii::$app->name); ?></h1>
    <br/>
    
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Nzueroug_90?rel=0" frameborder="0" allowfullscreen></iframe>
    
    <br/>
    <br/>
    
    <div class="row">
        <div id="create-account-form" class="panel panel-default animated bounceIn" style="max-width: 500px; margin: 0 auto 20px; text-align: left;">
            <div class="panel-heading"><?php echo Yii::t('UserModule.views_auth_createAccount', '<strong>Agent</strong> registration'); ?></div>
            <div class="panel-body">
                <p style = "font-style:italic">&ldquo;<?php echo Yii::t('UserModule.views_auth_createAccount', "This is Alchemy, and this is an Urgent Evoke. Wherever you are, whoever you are, if you found this message, it's your destiny to join us."); ?>&rdquo;</p>
                <p><?php echo Yii::t('UserModule.views_auth_createAccount', "You have demonstrated your courage, and your commitment is unquestionable. The first thing we need is to update the Evoke database Evoke with the following fields:"); ?></p><br>
            
                <?php $form = \yii\widgets\ActiveForm::begin(['enableClientValidation' => false]); ?>
                <?php echo $hForm->render($form); ?>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // set cursor to login field
        $('#User_username').focus();
    })

    // Shake panel after wrong validation
<?php foreach ($hForm->models as $model) : ?>
    <?php if ($model->hasErrors()) : ?>
            $('#create-account-form').removeClass('bounceIn');
            $('#create-account-form').addClass('shake');
            $('#app-title').removeClass('fadeIn');
    <?php endif; ?>
<?php endforeach; ?>

</script>