<?php

use yii\db\Migration;
use app\models\SignupForm;

/**
 * Class m181024_112929_test2
 */
class m181024_112929_test2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('some_data_model', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->tinyInteger(1)->notNull(),
            'date' => $this->date()->notNull(),
            'a' => $this->integer()->notNull(),
            'b' => $this->string(45)->notNull(),
        ]);
        
        // creates index for column `user_id`
        $this->createIndex(
            'idx-some_data_model-user_id',
            'some_data_model',
            'user_id'
        );
        
        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-some_data_model-user_id',
            'some_data_model',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        // insert test data
        $model = new SignupForm([
            'username' => 'test_user',
            'email' => 'test@test.ru',
            'password' => 'test_pass',
            'type' => 1,
            'is_entrepreneur' => false,
            'fullname' => 'Test',
        ]);
        $user = $model->signup();
        $this->insert('some_data_model', ['user_id' => $user->id, 'type' => 1, 'date' => '2018-10-18', 'a' => 1, 'b' => 'test_data_1']);
        $this->insert('some_data_model', ['user_id' => $user->id, 'type' => 2, 'date' => '2018-10-18', 'a' => 2, 'b' => 'test_data_2']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-some_data_model-user_id',
            'some_data_model'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-some_data_model-user_id',
            'some_data_model'
        );

        $this->dropTable('some_data_model');

        // delete the test user
        $this->delete('user', ['username' => 'test_user']);
    }
}
