CREATE TABLE USERS (
	id int unsigned auto_increment primary key,
	username varchar(50) not null,
	password_hash varchar(255) not null,
	created datetime,
	modified datetime
);

CREATE TABLE MESSAGES (
	id bigint unsigned auto_increment primary key,
	message text not null,
	user_id int unsigned,
	created datetime,
	modified datetime,

	index user_id
);