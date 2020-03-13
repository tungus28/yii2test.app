<?php

use yii\widgets\ActiveForm;

?>

<?php
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
$form->action = Yii::$app->urlManager->createUrl('/sentences/counfromfile');
?>

<?= $form->field($model, 'file')->fileInput() ?>

<button>Отправить</button>

<?php ActiveForm::end() ?>

