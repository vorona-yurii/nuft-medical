<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Quiz */

$this->title = 'Update Quiz: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->quiz_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
