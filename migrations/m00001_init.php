<?php

class m00001_init
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE blog (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                blogPost VARCHAR(700) NOT NULL,
                added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                added_by INT NOT NULL,
                edited TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                edited_by INT NOT NULL
            )  ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE blog;";
        $db->pdo->exec($SQL);
    }
}
