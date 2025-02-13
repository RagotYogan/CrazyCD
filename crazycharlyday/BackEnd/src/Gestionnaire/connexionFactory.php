<?php

namespace src\Db;

class connexionFactory {
    private static $config;

    public static function setConfig($file) {
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection() {
        $dsn = 'mysql:host=' . self::$config['host'] . ';dbname=' . self::$config['dbname'] . ';charset=' . self::$config['charset'];
        $username = self::$config['username'];
        $password = self::$config['password'];

        try {
            $pdo = new \PDO($dsn, $username, $password);
            // print("La base de données est connectée.<br>");
            return $pdo;
        } catch (\PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
}

\src\Db\connexionFactory::setConfig('db.config.ini');

$db = \src\Db\connexionFactory::makeConnection();
