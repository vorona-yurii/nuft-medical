<?php

/* @var $quiz \app\modules\quiz\models\Quiz */
/* @var $data array */

use yii\helpers\Url;

$this->title = 'Аналітика по відділам';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title ?></h2>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <a href="<?= Url::to(['/quiz/quiz']) ?>">Перейти до списку опитувань</a>
                    <?php if (empty($data)) { ?>
                        <div class="container">
                            <br>
                            <h2 class="text-center">Неможливо побудувати графік проходження опитування №<?= $quiz->quiz_id ?>, так як
                                відсутні дані від працівників</h2>
                        </div>
                    <?php } else { ?>
                        <?= $this->render('_analytics_department_chart', [
                            'quiz' => $quiz,
                            'data' => $data
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>