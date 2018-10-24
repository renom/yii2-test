<?php

use yii\db\Migration;

/**
 * Class m181024_130652_test3
 */
class m181024_130652_test3 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('medicine', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'expired_at' => $this->date()->notNull(),
        ]);

        $this->createTable('disease', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);

        $this->createTable('medicine_disease', [
            'medicine_id' => $this->integer()->notNull(),
            'disease_id' => $this->integer()->notNull(),
            'PRIMARY KEY(medicine_id, disease_id)',
        ]);

        // creates index for column `medicine_id`
        $this->createIndex(
            'idx-medicine_disease-medicine_id',
            'medicine_disease',
            'medicine_id'
        );

        // add foreign key for table `medicine`
        $this->addForeignKey(
            'fk-medicine_disease-medicine_id',
            'medicine_disease',
            'medicine_id',
            'medicine',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `disease_id`
        $this->createIndex(
            'idx-medicine_disease-disease_id',
            'medicine_disease',
            'disease_id'
        );

        // add foreign key for table `disease`
        $this->addForeignKey(
            'fk-medicine_disease-disease_id',
            'medicine_disease',
            'disease_id',
            'disease',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `medicine`
        $this->dropForeignKey(
            'fk-medicine_disease-medicine_id',
            'medicine_disease'
        );

        // drops index for column `medicine_id`
        $this->dropIndex(
            'idx-medicine_disease-medicine_id',
            'medicine_disease'
        );

        // drops foreign key for table `disease`
        $this->dropForeignKey(
            'fk-medicine_disease-disease_id',
            'medicine_disease'
        );

        // drops index for column `disease_id`
        $this->dropIndex(
            'idx-medicine_disease-disease_id',
            'medicine_disease'
        );

        $this->dropTable('medicine_disease');
        $this->dropTable('disease');
        $this->dropTable('medicine');
    }
}
