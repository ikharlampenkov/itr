<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 24.07.12
 * Time: 10:40
 * To change this template use File | Settings | File Templates.
 */

ini_set('display_errors', 1);


function createSequence(PDO $dbPostgres, $schema)
{
    $selectSQL = 'SELECT * FROM information_schema.tables
                  WHERE table_schema=? AND table_type=? AND table_name!=? AND table_name!=?';
    $selectStmt = $dbPostgres->prepare($selectSQL);
    $selectStmt->execute(array($schema, 'BASE TABLE', 'spatial_ref_sys', 'geometry_columns'));
    $result = $selectStmt->fetchAll();

    foreach ($result as $table) {
        try {
            echo $table['table_name'];

            $sql = 'SELECT COUNT(column_name) AS col_count FROM information_schema.columns
                    WHERE table_schema=? AND table_name=? AND column_name=?';
            $statement = $dbPostgres->Prepare($sql);
            $statement->execute(array($schema, $table['table_name'], 'id'));
            $checkResult = $statement->fetch();

            if ($checkResult['col_count'] == 1) {

                $sql = 'CREATE SEQUENCE ' . $schema . '.' . $table['table_name'] . '_id_seq
                    INCREMENT 1
                    MINVALUE 1
                    MAXVALUE 9223372036854775807
                    START 1
                    CACHE 1;';
                $statement = $dbPostgres->Prepare($sql);
                $statement->execute();

                $sql = 'ALTER TABLE ' . $schema . '.' . $table['table_name'] . '_id_seq OWNER TO garage;';
                $statement = $dbPostgres->Prepare($sql);
                $statement->execute();

                $sql = 'ALTER TABLE ' . $schema . '.' . $table['table_name'] . ' ALTER COLUMN id SET DEFAULT nextval(\'' . $schema . '.' . $table['table_name'] . '_id_seq\'::regclass);';
                $statement = $dbPostgres->Prepare($sql);
                $statement->execute();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

function setStartForSequence(PDO $dbPostgres, $schema)
{
    $selectSQL = 'SELECT * FROM information_schema.tables
                      WHERE table_schema=? AND table_type=? AND table_name!=? AND table_name!=?';
    $selectStmt = $dbPostgres->Prepare($selectSQL);
    $selectStmt->execute(array($schema, 'BASE TABLE', 'spatial_ref_sys', 'geometry_columns'));
    $result = $selectStmt->fetchAll();

    foreach ($result as $table) {
        try {
            echo $table['table_name'];

            $sql = 'SELECT COUNT(column_name) AS col_count FROM information_schema.columns
                                WHERE table_schema=? AND table_name=? AND column_name=?';
            $statement = $dbPostgres->Prepare($sql);
            $statement->execute(array($schema, $table['table_name'], 'id'));

            $checkResult = $statement->fetch();
            if ($checkResult['col_count'] == 1) {
                $sql = 'SELECT MAX(id)+1 as max_id FROM ' . $schema . '.' . $table['table_name'];
                $statement = $dbPostgres->Prepare($sql);
                $statement->execute();
                $max = $statement->fetch();

                if (!empty($max['max_id'])) {
                    $sql = 'SELECT setval(\'' . $schema . '.' . $table['table_name'] . '_id_seq\', ' . $max['max_id'] . ', true);';
                    $statement = $dbPostgres->prepare($sql);
                    $statement->execute();
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

function setPrimaryKey(PDO $dbPostgres, $schema)
{
    $selectSQL = 'SELECT * FROM information_schema.tables
                      WHERE table_schema=? AND table_type=? AND table_name!=? AND table_name!=?';
    $selectStmt = $dbPostgres->Prepare($selectSQL);
    $selectStmt->execute(array($schema, 'BASE TABLE', 'spatial_ref_sys', 'geometry_columns'));
    $result = $selectStmt->fetchAll();

    foreach ($result as $table) {
        try {
            echo $table['table_name'] . "\r\n";

            $sql = 'SELECT COUNT(column_name) AS col_count FROM information_schema.columns
                                WHERE table_schema=? AND table_name=? AND column_name=?';
            $statement = $dbPostgres->Prepare($sql);
            $statement->execute(array($schema, $table['table_name'], 'id'));

            $checkResult = $statement->fetch();
            if ($checkResult['col_count'] == 1) {
                $sql = 'ALTER TABLE ' . $schema . '.' . $table['table_name'] . ' ADD PRIMARY KEY(id)';
                $statement = $dbPostgres->Prepare($sql);
                $statement->execute();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}


$pdo = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=garage;user=garage;password=36795cbf4575710441a0aa8f5265f845');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//createSequence($pdo, 'public');
//setStartForSequence($pdo, 'public');
setPrimaryKey($pdo, 'public');
