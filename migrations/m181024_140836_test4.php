<?php

use yii\db\Migration;

/**
 * Class m181024_140836_test4
 */
class m181024_140836_test4 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('config', [
            'name' => 'VARCHAR(45) PRIMARY KEY',
            'value' => $this->string(255)->notNull(),
        ]);

        $this->insert('config', ['name' => 'is_online', 'value' => '1']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('config');
    }
}
