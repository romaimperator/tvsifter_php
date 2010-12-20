CREATE DATABASE IF NOT EXISTS tvsifter;
USE tvsifter;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS episodes;
DROP TABLE IF EXISTS shows;
DROP TABLE IF EXISTS episode_users;
DROP TABLE IF EXISTS shows_users;
DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS aros;
DROP TABLE IF EXISTS acos;
DROP TABLE IF EXISTS aros_acos;
DROP TABLE IF EXISTS friends;
DROP TABLE IF EXISTS activity;

CREATE TABLE activity (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `update` text,
    user_id integer,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE INDEX activity_user_id ON activity (user_id);

CREATE TABLE friends (
    user_id integer NOT NULL,
    friend_id integer NOT NULL,
    created datetime,
    modified datetime
) ENGINE = MyISAM;

CREATE UNIQUE INDEX USER_FRIEND_KEY ON friends (user_id, friend_id);

CREATE TABLE shows_users (
    show_id integer NOT NULL,
    user_id integer NOT NULL,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE UNIQUE INDEX SHOW_USER_KEY ON shows_users (show_id, user_id);

CREATE TABLE users (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(64) NOT NULL,
    password varchar(40) NOT NULL,
    email varchar(64) NOT NULL,
    group_id integer NOT NULL,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE INDEX user_group_id ON users (group_id);

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

CREATE INDEX episode_show_id ON episodes (show_id);

CREATE TABLE shows (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(32) NOT NULL,
    display_name varchar(32) NOT NULL,
    season_count integer,
    episode_count integer,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE FULLTEXT INDEX show_name ON shows (name);

CREATE TABLE episode_users (
    user_id integer,
    episode_id integer,
    watched boolean,
    downloaded boolean,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE UNIQUE INDEX EPISODE_USER_KEY ON episode_users (user_id, episode_id);

CREATE TABLE groups (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(32) NOT NULL,
    created datetime,
    modified datetime
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE aros (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    parent_id integer,
    model varchar(255),
    foreign_key integer,
    alias varchar(255),
    lft integer,
    rght integer
) ENGINE = MyISAM;

CREATE TABLE acos (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    parent_id integer,
    model varchar(255),
    foreign_key integer,
    alias varchar(255),
    lft integer,
    rght integer
) ENGINE = MyISAM;

CREATE TABLE aros_acos (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    aro_id integer NOT NULL,
    aco_id integer NOT NULL,
    _create varchar(2) NOT NULL,
    _read varchar(2) NOT NULL,
    _update varchar(2) NOT NULL,
    _delete varchar(2) NOT NULL
) ENGINE = MyISAM;

CREATE UNIQUE INDEX ARO_ACO_KEY ON aros_acos (aro_id, aco_id);


-- Add the initial data
source ../initial_data.sql
