<?php

use app\db\Migration;

/**
 * Class m181024_102018_create_table_employee
 */
class m181024_102018_create_table_employee extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%employee}}', [
            'employee_id'                     => $this->primaryKey(),
            'department_id'                   => $this->integer(),
            'full_name'                       => $this->string(),
            'phone'                           => $this->string(),
            'email'                           => $this->string(),
            'gender'                          => $this->smallInteger(),
            'birth_date'                      => $this->string(),
            'residence'                       => $this->string(),
            'position_id'                     => $this->integer(),
            'work_experience'                 => $this->string(),
            'additional_info'                 => $this->text(),
            'first_medical_examination_date'  => $this->string(),
            'last_medical_examination_date'   => $this->string(),
            'weight'                          => $this->integer(4),
            'height'                          => $this->integer(4),
            'arterial_pressure'               => $this->string(50),
            'medical_conclusion'              => $this->text()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-employee-department_id',
            'employee',
            'department_id',
            'department',
            'department_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-employee-position_id',
            'employee',
            'position_id',
            'position',
            'position_id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%employee}}' );
    }
}
