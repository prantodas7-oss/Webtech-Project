<?php
class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            self::$conn = new mysqli('localhost', 'root', '', 'pharmacy_db');
            if (self::$conn->connect_error) {
                die('Database connection failed: ' . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
