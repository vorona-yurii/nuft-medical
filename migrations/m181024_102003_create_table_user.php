<?php

use app\db\Migration;

/**
 * Class m181024_102003_create_table_user
 */
class m181024_102003_create_table_user extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function up()
    {
        $this->createTable( '{{%user}}', [
            'id'                   => $this->primaryKey()->comment('ID пользователя'),
            'name'                 => $this->string()->comment('Имя пользователя'),
            'email'                => $this->string()->unique()->comment('Email пользователя'),
            'auth_key'             => $this->string( 32 )->comment('Ключ авторизации'),
            'password_hash'        => $this->string()->notNull()->comment('Пароль'),
            'password_reset_token' => $this->string()->unique()->comment('Токен пароля(системный)'),
            'created_at'           => $this->integer()->comment('Дата создания')
        ], $this->tableOptions );

        Yii::$app->db
            ->createCommand()
            ->batchInsert( '{{%user}}',
                [
                    'name',
                    'email',
                    'password_hash',
                    'created_at'
                ],
                [
                    [
                        'Main Admin',
                        'admin@nuft.net',
                        '$2y$10$vqTOfj8bsUGp3UKbhcl68uTsFTPP2vud39s8FjyrYh/b4cSbT2bpS', // %9Fg2U(!
                        time()
                    ],
                ]
            )
            ->execute();
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%user}}' );
    }
}
