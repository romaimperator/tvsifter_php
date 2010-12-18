USE tv_show_scraper;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS episodes;
DROP TABLE IF EXISTS shows;
DROP TABLE IF EXISTS episode_users;
DROP TABLE IF EXISTS show_users;
DROP TABLE IF EXISTS groups;

CREATE TABLE shows_users (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    show_id integer NOT NULL,
    user_id integer NOT NULL
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE users (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(64) NOT NULL,
    password varchar(40) NOT NULL,
    email varchar(64) NOT NULL,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE episodes (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(64) NOT NULL,
    season integer,
    episode integer,
    overall_episode integer,
    description text,
    air_date date,
    show_id integer,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE shows (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(32) NOT NULL,
    display_name varchar(32) NOT NULL,
    episode_list_html mediumtext,
    season_count integer,
    episode_count integer,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE episode_users (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id integer,
    episode_id integer,
    watched boolean,
    downloaded boolean,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE groups (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(32) NOT NULL,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

ALTER TABLE users ADD `group_id` integer NOT NULL AFTER `email`;
