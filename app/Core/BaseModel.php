<?php

class BaseModel {
    protected static $db;

    // Set the shared database instance
    public static function setDatabase($database) {
        self::$db = $database;
    }
}