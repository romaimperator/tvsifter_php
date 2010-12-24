USE tvsifter;

INSERT INTO groups (name, created, modified) VALUES ('admin', now(), now());
INSERT INTO groups (name, created, modified) VALUES ('manager', now(), now());
INSERT INTO groups (name, created, modified) VALUES ('user', now(), now());

INSERT INTO aros (model, foreign_key, alias, lft, rght) VALUES ('Group', 1, 'admin', 1, 4);
INSERT INTO aros (model, foreign_key, alias, lft, rght) VALUES ('Group', 2, 'manager', 5, 6);
INSERT INTO aros (model, foreign_key, alias, lft, rght) VALUES ('Group', 3, 'user', 7, 8);
INSERT INTO aros (model, foreign_key, alias, lft, rght) VALUES ('User', 1, NULL, 2, 3);

INSERT INTO aros_acos (aro_id, aco_id, _create, _read, _update, _delete) VALUES (1, 1, 1, 1, 1, 1);

INSERT INTO users (username, password, email, group_id, created, modified) VALUES ('admin', '1971b78e75ba6d94aaef66ce66aa87336ee760b9', 'admin@gmail.com', 1, now(), now());
INSERT INTO users (username, password, email, group_id, created, modified) VALUES ('broseph', 'passwordhashthatihaventimplementedyet', 'broseph@gmail.com', 3, now(), now());

INSERT INTO friends (user_id, friend_id, created, modified) VALUES (1, 2, now(), now());

INSERT INTO activities (`update`, user_id, created, modified) VALUES ('Broseph has just watched 2 episodes of House', 2, now(), now());
INSERT INTO activities (`update`, user_id, created, modified) VALUES ('Broseph has liked the show 24', 2, now(), now());
