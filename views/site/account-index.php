<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $account \app\models\Account */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'User list';

?>
<div class="site-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]); ?>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($account, 'login') ?>

    <?= $form->field($account, 'apiKey') ?>

    <?= $form->field($account, 'secretKey') ?>

    <?= Html::submitButton('Add user', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
