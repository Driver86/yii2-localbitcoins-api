<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $account \app\models\Account */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Course list';

?>
<div class="site-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]); ?>

</div>
