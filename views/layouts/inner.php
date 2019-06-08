<?php

/**
 * @var $this            \yii\web\View
 * @var $content         string
 * @var $item            array
 * @var $pageEditor      string
 * @var $avatar          string
 */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\InnerAsset;
use app\models\Pages;
use app\widgets\PidDetected;
use yii\helpers\Url;
use app\models\User;

InnerAsset::register( $this );
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/favicon.ico']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode( $this->title ) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <?php
            $class_organization = in_array($this->context->route, ['employee/list', 'department/list', 'profession/list', 'position/list' ]) ? 'active' : '';
            $class_other        = in_array($this->context->route, ['factor/list', 'doctor/list', 'analysis/list', 'periodicity/list']) ? 'active' : '';
            $class_report       = in_array($this->context->route, ['report/employee', 'report/list']) ? 'active' : '';
            echo Nav::widget( [
                'encodeLabels' => false,
                'items'        => [
                    '<li class="nav-header">
                        <div class="dropdown profile-element text-center"> 
                             <img alt="image" class="img-circle" src="' . Url::to( '@web/images/nuft-logo.png' ) . '">
                             <span class="block m-t-xs">
                                <strong>Система контролю медогляду НУХТ</strong>
                             </span>
                        </div>
                        <div class="logo-element">NM</div>
                    </li>',
                    '<li class="' . $class_organization . '">
                        <a>
                            <i class="fa fa-sitemap"></i>
                            <span class="nav-label">Організація</span> 
                            <span class="caret"></span>
                        </a>' .
                    Nav::widget( [
                        'items'   => [
                            [ 'label' => 'Працівники', 'url' => [ "employee/list" ] ],
                            [ 'label' => 'Структурні підрозділи', 'url' => [ "department/list" ] ],
                            [ 'label' => 'Загальні професії', 'url' =>  [ "profession/list" ] ],
                            [ 'label' => 'Посади підрозділів', 'url' =>  [ "position/list" ] ],
                        ],
                        'options' => [ 'class' => 'nav nav-second-level collapse' ],
                    ] )
                    . '</li>',
                    '<li class="' . $class_other . '">
                        <a>
                            <i class="fa fa-tags"></i>
                            <span class="nav-label">Додаткові дані</span> 
                            <span class="caret"></span>
                        </a>' .
                    Nav::widget( [
                        'items'   => [
                            [ 'label' => 'Шкідливі фактори', 'url' => [ "factor/list" ] ],
                            [ 'label' => 'Лікарі', 'url' => [ "doctor/list" ] ],
                            [ 'label' => 'Аналізи', 'url' => [ "analysis/list" ] ],
                            [ 'label' => 'Періодичність', 'url' => [ "periodicity/list" ] ],
                        ],
                        'options' => [ 'class' => 'nav nav-second-level collapse' ],
                    ] )
                    . '</li>',
                    '<li class="' . $class_report . '">
                        <a>
                            <i class="fa fa-file-text-o"></i>
                            <span class="nav-label">Звіти</span> 
                            <span class="caret"></span>
                        </a>' .
                    Nav::widget( [
                        'items'   => [
                            [ 'label' => 'Працівники', 'url' => [ "report/employee" ] ],
                            [ 'label' => 'Списки', 'url' => [ "report/list" ] ],
                        ],
                        'options' => [ 'class' => 'nav nav-second-level collapse' ],
                    ] )
                    . '</li>',
                ],

                'options' => [ 'class' => 'nav', 'id' => 'side-menu' ],
            ] );
            ?>

        </div>
    </nav>


    <div id="page-wrapper" class="gray-bg dashbard-1 clearfix">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header col-xs-6">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right text-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                            <strong class="font-bold"><?= Yii::$app->user->identity->email ; ?></strong>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a class="btn btn-link" href="<?= Url::to(['/setting']); ?>"><i class="fa fa-cog" aria-hidden="true"></i> Налаштування</a>
                            </li>
                            <li>
                                <?= Html::beginForm( [ '/logout' ], 'post' )
                                . Html::submitButton( '<i class="fa fa-sign-out"></i> Вихід',
                                    [ 'class' => 'btn btn-link logout' ] ) . Html::endForm() ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
