<?php
/* @var $quiz \app\modules\quiz\models\Quiz */
/* @var $employee \app\models\Employee */
?>

<pre>
    <?php print_r([
        'name' => $employee->full_name,
        'email' => $employee->email
    ]) ?>
    <?php print_r([
        'name' => $quiz->name,
        'description' => $quiz->description
    ]) ?>
</pre>
