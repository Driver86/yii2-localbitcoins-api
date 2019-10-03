<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Balance list';

?>
<div class="site-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]); ?>

</div>
