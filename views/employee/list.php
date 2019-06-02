<?php

use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Працівники - Список';

$this->registerJs( '
$(\'body\').on(\'click\',\'a.del-employee\',function(e){
    e.preventDefault();

    var warning_text = "Ви впевнені, що хочете видалити данного працівника?";

    var conf = confirm( warning_text );
    if(conf) {
        var id = $(this).attr(\'href\');
        $.ajax({
            url: "' . Url::toRoute(["employee/delete"], true) . '",
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
                            <a href="<?=Url::toRoute('employee/add')?>" class="btn btn-primary dim" type="button"><i class="fa fa-plus"></i> Додати працівника</a>
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
                                'full_name:text:ПІБ',
                                'phone:text:Телефон',
                                'email:text:Email',
                                [
                                    'label'  => 'Дії',
                                    'format' => 'raw',
                                    'value'  => function ( $searchModel) {
                                        $buttons = '';

                                        $buttons .= '<div class="btn-group">' . Html::a( '<i class="fa fa-pencil" aria-hidden="true"></i>',
                                                Url::toRoute( [ "employee/edit", 'id' => $searchModel->employee_id ] ),
                                                [ 'class' => 'btn btn-primary btn-edit-employee' ] );
                                        $buttons .= Html::a( '<i class="fa fa-trash" aria-hidden="true"></i>',
                                                Url::to( $searchModel->employee_id ),
                                                [ 'class' => 'btn btn-danger del-employee'] ) . '</div>';

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
