#Skript für DB-Erstellung
#Version 3.0

#DB anlegen
create database baq;

#alle Datenbanken anzeigen:
#show databases;

#User 'baq' anlegen mit PW 'baq123'
create user 'baq'@'localhost' identified by 'baq123';

#alle User anzeigen:
#select User from mysql.user;

#User 'baq' der DB zuweisen und alle Rechte geben:
grant all on baq.* to baq@localhost identified by 'baq123';

#Berechtigung anzeigen:
#show grants for 'baq'@'localhost';

#Tabelle users anlegen:
create table users ( user_id int NOT NULL primary key AUTO_INCREMENT,
                     username varchar(50) NOT NULL UNIQUE,
                     password varchar(255) NOT NULL,
                     mail varchar(100));

#Tabelle quiz anlegen:
create table quiz ( quiz_id int primary key AUTO_INCREMENT,
                     quiz_name varchar(20),
                     creator integer not null REFERENCES users(user_id),
                     quiz_json varchar(5000),
                     total_points integer);

#Tabelle score anlegen:
create table score( user_id int not null REFERENCES users(user_id),
                   	quiz_id int not null REFERENCES quiz (quiz_id),
                    points int not null,
                    counter int);

#User ueber sign up registrieren!! -> wegen password-hashing
#Testuser anlegen:
#Passwort Luke: luke234
#Passwort Lea: lea234
#insert into users (username, password, mail) values ('luke', '$2y$10$4k/yCRwCFgiWWfvJz0l13uIcSmyQXq4GuLPzkItEWGPFLJYI5Hfum', 'luke@baq.de');
#insert into users (username, password, mail) values ('lea', '$2y$10$aDCbqVAh1fQ2QWUXFwarL.TLSRKIVdzkhHbH8qDgiqQUlj3/vP3ju', 'lea@baq.de');

#DB löschen:
#drop database 'baq';

#User löschen:
# DROP USER 'baq'@'localhost';

#nur Berechtigungen löschen:
# REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'baq'@'localhost';