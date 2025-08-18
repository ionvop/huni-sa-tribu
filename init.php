<?php

if (php_sapi_name() != 'cli') {
    echo "This script can only be run from the command line.";
    exit;
}

$db = new SQLite3("database.db");

$query = <<<SQL
    CREATE TABLE "users" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `fullname` TEXT, `email` TEXT UNIQUE, `username` TEXT UNIQUE, `hash` TEXT, `session` TEXT, `time` INTEGER DEFAULT (unixepoch()));
    CREATE TABLE "email_verifications" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `email` TEXT, `code` TEXT, `is_verified` TEXT DEFAULT 'no', `time` INTEGER DEFAULT (unixepoch()));
SQL;

$db->exec($query);
echo "Database initialized.\n";