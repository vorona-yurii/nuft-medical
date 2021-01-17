<?php

$this->title = $error;

$this->registerCssFile('/css/quiz.css');

?>

<div class="container quiz-container">
    <div class="col-md-10 col-md-offset-1 panel panel-primary">
        <div class="quiz-heading row panel-heading">
            <div class="col-md-12 text-center">
                <h2><?= $this->title ?></h2>
            </div>
        </div>
    </div>
</div>
