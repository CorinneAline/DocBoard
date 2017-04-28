drop table if exists book;
drop table if exists author;
drop table if exists t_comment;
drop table if exists t_link;
drop table if exists t_user;
drop table if exists t_article;

create table author (
    auth_id integer not null primary key auto_increment,
    auth_first_name varchar(100) not null,
    auth_last_name varchar(100) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table book (
    book_id integer not null primary key auto_increment,
    book_title varchar(100) not null,
    book_isbn varchar(13) not null,
    book_summary varchar(2000) not null,
    auth_id integer not null,
    constraint fk_book_auth foreign key(auth_id) references author(auth_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_article (
    art_id integer not null primary key auto_increment,
    art_title varchar(100) not null,
    art_content varchar(2000) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_user (
    usr_id integer not null primary key auto_increment,
    usr_name varchar(50) not null,
    usr_password varchar(88) not null,
    usr_salt varchar(23) not null,
    usr_role varchar(50) not null 
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_comment (
    com_id integer not null primary key auto_increment,
    com_content varchar(500) not null,
    art_id integer not null,
    usr_id integer not null,
    constraint fk_com_art foreign key(art_id) references t_article(art_id),
    constraint fk_com_usr foreign key(usr_id) references t_user(usr_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_link (
    link_id integer not null primary key auto_increment,
    link_title varchar(500) not null,
    link_url varchar(200) not null,
    usr_id integer not null,
    constraint fk_link_usr foreign key(usr_id) references t_user(usr_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;