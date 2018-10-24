<?php

use yii\db\Migration;

/**
 * Class m181024_065649_test1
 */
class m181024_065649_test1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add extra columns to the user table
        $this->addColumn('user', 'is_entrepreneur', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('user', 'has_organization', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('user', 'fullname', $this->string(255)->notNull());
        $this->addColumn('user', 'inn', $this->decimal(12));
        $this->addColumn('user', 'org_name', $this->string(255));
        $this->addColumn('user', 'org_inn', $this->decimal(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drop the columns
        $this->dropColumn('user', 'is_entrepreneur');
        $this->dropColumn('user', 'has_organization');
        $this->dropColumn('user', 'fullname');
        $this->dropColumn('user', 'inn');
        $this->dropColumn('user', 'org_name');
        $this->dropColumn('user', 'org_inn');
    }
}
