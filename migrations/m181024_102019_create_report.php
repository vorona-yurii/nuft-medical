<?php

use app\db\Migration;

/**
 * Class m181024_102019_create_report
 */
class m181024_102019_create_report extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%report}}', [
            'report_id'  => $this->primaryKey(),
            'name'       => $this->string(),
            'created_at' => $this->string(),
            'updated_at' => $this->string()
        ], $this->tableOptions );

        $this->createTable( '{{%report_group}}', [
            'report_group_id'    => $this->primaryKey(),
            'report_id'          => $this->integer(),
            'report_position'    => $this->string(),
            'date_medical_check' => $this->string()
        ], $this->tableOptions );

        $this->createTable( '{{%report_group_employee}}', [
            'report_groups_employee_id' => $this->primaryKey(),
            'report_id'                 => $this->integer(),
            'report_group_id'           => $this->integer(),
            'employee_id'               => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-report_groups-report_id',
            'report_group',
            'report_id',
            'report',
            'report_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report_group_employee-report_id',
            'report_group_employee',
            'report_id',
            'report',
            'report_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report_group_employee-report_group_id',
            'report_group_employee',
            'report_group_id',
            'report_group',
            'report_group_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report_group_employee-employee_id',
            'report_group_employee',
            'employee_id',
            'employee',
            'employee_id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%report_group_employee}}' );
        $this->dropTable( '{{%report_group}}' );
        $this->dropTable( '{{%report}}' );
    }
}
