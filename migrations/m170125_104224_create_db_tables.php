<?php

use yii\db\Migration;

class m170125_104224_create_db_tables extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'user_id' => $this->primaryKey(),
            'user_name' => $this->string()->notNull()->unique(),
            'user_password' => $this->string()->notNull(),
            'user_email' => $this->string()->notNull(),
            'user_role' => $this->integer()->defaultValue(0),
            'user_ban_status' => $this->integer()->defaultValue(0),
            'user_avatar' => $this->string(),
            'reg_time' => $this->timestamp(),
            'user_authkey' => $this->string(32)->notNull(),
            'user_activated' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createTable('{{%saved}}', [
            'track_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'track_value' => $this->string()->notNull(),
            'datetime' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%chat}}', [
            'message_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message_text' => $this->string()->notNull(),
            'pos_rating' => $this->integer(),
            'neg_rating' => $this->integer(),
            'datetime' => $this->timestamp(),
        ], $tableOptions);


    }

    public function down()
    {
        echo "m170125_104224_create_db_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
