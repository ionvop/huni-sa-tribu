CREATE TABLE "users" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `firstname` TEXT, `lastname` TEXT, `username` TEXT UNIQUE, `email` TEXT UNIQUE, `hash` TEXT, `session` TEXT, `time` INTEGER DEFAULT (unixepoch()));
CREATE TABLE "qr" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `content_id` INTEGER REFERENCES `content`(`id`), `status` TEXT DEFAULT 'active', `code` TEXT UNIQUE, `time` INTEGER DEFAULT (unixepoch()));
CREATE TABLE "visitors" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `name` TEXT, `school` TEXT, time INTEGER DEFAULT (unixepoch()));
CREATE TABLE `scans` (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `visitor_id` INTEGER REFERENCES `visitors`(`id`), `qr_id` INTEGER REFERENCES `qr`(`id`), `time` INTEGER DEFAULT (unixepoch()));
CREATE TABLE `visits` (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `visitor_id` INTEGER REFERENCES `visitors`(`id`), `time` INTEGER DEFAULT (unixepoch()));
CREATE TABLE "content" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `user_id` INTEGER REFERENCES `users`(`id`), `title` TEXT, `category` TEXT, `tribe` TEXT, `description` TEXT, `file` TEXT, "is_archived" INTEGER DEFAULT 0, `time` INTEGER DEFAULT (unixepoch()));
