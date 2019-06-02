<?php

use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Посади - Список';

$this->registerJs( '
$(\'body\').on(\'click\',\'a.del-position\',function(e){
    e.preventDefault();

    var warning_text = "Ви впевнені, що хочете видалити дану посаду?";

    var conf = confirm( warning_text );
    if(conf) {
        var id = $(this).attr(\'href\');
        $.ajax({
            url: "' . Url::toRoute(["position/delete"], true) . '",
            type: \'post\',
            data: {
                \'id\': id,
            },
            success: function (result) {
                if (result) {
                    $(\'tr[data-key = \' + id + \']\').detach();
                } else {
                    alert(\'error change status\');
                }
            }
        });
    }

});
');

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?= $this->title ?></h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <div class="btn-group pull-right">
                            <a href="<?= Url::toRoute('position/add')?>" class="btn btn-primary dim" type="button"><i class="fa fa-plus"></i> Додати посаду</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="ibox-content">
                    <?php Pjax::begin(); ?>

                    <?= GridView::widget( [
                        'filterModel'  => $searchModel,
                        'dataProvider' => $dataProvider,
                        'layout'       => '{items}',
                        'columns'      =>
                            [
                                'position_id:integer:ID',
                                'name:text:Назва',
                                [
                                    'label'     => 'Підрозділ',
                                    'attribute' => 'phone',
                                    'format'    => 'raw',
                                    'headerOptions' => [ 'data-hide' => "phone,sm" ],
                                    'value'     => function ( $searchModel ) {
                                        return \app\models\Department::findOne($searchModel->department_id)->name;
                                    },

                                ],
                                [
                                    'label'     => 'Професія',
                                    'attribute' => 'phone',
                                    'format'    => 'raw',
                                    'headerOptions' => [ 'data-hide' => "phone,sm" ],
                                    'value'     => function ( $searchModel ) {
                                        return \app\models\Profession::findOne($searchModel->profession_id)->name;
                                    },

                                ],
                                [
                                    'label'  => 'Дії',
                                    'format' => 'raw',
                                    'value'  => function ( $searchModel) {
                                        $buttons = '';

                                        $buttons .= '<div class="btn-group">' . Html::a( '<i class="fa fa-pencil" aria-hidden="true"></i>',
                                                Url::toRoute( [ "position/edit", 'id' => $searchModel->position_id ] ),
                                                [ 'class' => 'btn btn-primary btn-edit-position' ] );
                                        $buttons .= Html::a( '<i class="fa fa-trash" aria-hidden="true"></i>',
                                                Url::to( $searchModel->position_id ),
                                                [ 'class' => 'btn btn-danger del-position'] ) . '</div>';

                                        return $buttons;
                                    },
                                    'contentOptions' => function () {
                                        return ['style' => 'text-align: center;'];
                                    },
                                ],
                            ],

                    ] ) ?>
                    <?= LinkPager::widget( [ 'pagination' => $dataProvider->pagination ] ); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
