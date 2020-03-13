<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files loaded';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentences-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'value:ntext',
            'result:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
