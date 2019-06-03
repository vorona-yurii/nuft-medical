<?php

return [
    'login'                   => 'user/login',
    'logout'                  => 'user/logout',

    /***************** employee ******************/
    'employee'                => 'employee/list',
    'employee/list'           => 'employee/list',
    'employee/delete'         => 'employee/delete',
    'employee/<action>/<id>'  => 'employee/change',
    'employee/<action>'       => 'employee/change',

    /***************** department ******************/
    'department'                => 'department/list',
    'department/list'           => 'department/list',
    'department/delete'         => 'department/delete',
    'department/<action>/<id>'  => 'department/change',
    'department/<action>'       => 'department/change',

    /***************** profession ******************/
    'profession'                => 'profession/list',
    'profession/list'           => 'profession/list',
    'profession/delete'         => 'profession/delete',
    'profession/<action>/<id>'  => 'profession/change',
    'profession/<action>'       => 'profession/change',

    /***************** position ******************/
    'position'                => 'position/list',
    'position/list'           => 'position/list',
    'position/delete'         => 'position/delete',
    'position/<action>/<id>'  => 'position/change',
    'position/<action>'       => 'position/change',

    /*************** factor *****************/
    'factor'                => 'factor/list',
    'factor/list'           => 'factor/list',
    'factor/delete'         => 'factor/delete',
    'factor/<action>/<id>'  => 'factor/change',
    'factor/<action>'       => 'factor/change',

    /*************** doctor *****************/
    'doctor'                => 'doctor/list',
    'doctor/list'           => 'doctor/list',
    'doctor/delete'         => 'doctor/delete',
    'doctor/<action>/<id>'  => 'doctor/change',
    'doctor/<action>'       => 'doctor/change',

    /***************** analysis ******************/
    'analysis'                => 'analysis/list',
    'analysis/list'           => 'analysis/list',
    'analysis/delete'         => 'analysis/delete',
    'analysis/<action>/<id>'  => 'analysis/change',
    'analysis/<action>'       => 'analysis/change',

    /*************** periodicity *****************/
    'periodicity'                => 'periodicity/list',
    'periodicity/list'           => 'periodicity/list',
    'periodicity/delete'         => 'periodicity/delete',
    'periodicity/<action>/<id>'  => 'periodicity/change',
    'periodicity/<action>'       => 'periodicity/change',

    /***************** report ******************/
    'report/employee'       => 'report/employee',
    'report/list'           => 'report/list',
    'report/delete'         => 'report/list-delete',
    'report/employee-medical-card/download'            => 'report/employee-medical-card-download',
    'report/employee-medical-referral/download'        => 'report/employee-medical-referral-download',
    'report/medical-examination-schedule/download'     => 'report/medical-examination-schedule-download',
    'report/medical-examination-workers-list/download' => 'report/medical-examination-workers-list-download',
    'report/workers-categories-act/download'           => 'report/workers-categories-act-download',
    'report/<action>'       => 'report/list-change',
    'report/<action>/<id>'  => 'report/list-change',

    '<controller>/<action>'   => '<controller>/<action>',
];