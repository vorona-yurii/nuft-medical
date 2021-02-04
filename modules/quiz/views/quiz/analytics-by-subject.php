<?php

/* @var $department \app\models\Department */
/* @var $data array */

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Department;

if ($department) {
    $this->title = 'Аналітика по темам відділу ' . $department->name;
} else {
    $this->title = 'Аналітика по темам відділів. Виберіть відділ зі списку 👉';
}
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-8">
                    <h2><?= $this->title ?></h2>
                </div>
                <div class="col-sm-4">
                    <div class="title-action">
                        <form method="get">
                            <select class="form-control" name="department_id" onchange="this.form.submit()">
                                <option>Не вибрано</option>
                                <?php foreach (ArrayHelper::map(Department::find()->all(), 'department_id', 'name') as $department_id => $department_name) { ?>
                                    <option <?= Yii::$app->request->get('department_id') == $department_id ? 'selected' : '' ?> value="<?= $department_id ?>"><?= $department_name ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <a href="<?= Url::to(['/quiz/quiz']) ?>">Перейти до списку опитувань</a>
                    <?php if (empty($data) || !$department) { ?>
                        <div class="container">
                            <br>
                            <h2 class="text-center">Неможливо побудувати графік проходження, виберіть відділ зі списку</h2>
                        </div>
                    <?php } else { ?>
                        <?= $this->render('_analytics_subject_chart', [
                            'department' => $department,
                            'data' => $data
                        ]) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>