drop table if exists users cascade;
drop table if exists profile cascade;
drop table if exists diary cascade;
drop table if exists media cascade;
drop table if exists friend cascade;
drop table if exists greeting cascade;
drop table if exists comment cascade;
drop table if exists post_d cascade;
drop table if exists post_p cascade;
drop table if exists send cascade;
drop table if exists post_m cascade;
drop table if exists has cascade;

create table if not exists users (
	username		varchar(20) primary key not null,
	pwd		varchar(100) not null,  -- needs to be hashed 
	name		varchar(20),
	gender		char(1), -- 'm' for male, 'f' for female.
	birthday	date,
	state		varchar(50), 
	city		varchar(50) not null,
	street		varchar(50),	
	email		varchar(50) not null,
	user_photo	bytea,
	check (gender in ('m', 'f'))
	);


create table if not exists profile (
	pid		varchar(20) primary key not null,
	content	varchar(500),
	time_stamp	timestamp with time zone not null,
	visible_group	varchar(20),
	check (visible_group in ('everyone', 'friend', 'fof'))
	);


create table if not exists diary (
	did		varchar(20) primary key not null,
	title		varchar(100),
	body		varchar(10000),
	diary_time	timestamp with time zone not null,
	visib		varchar(20),
	check (visib in ('f', 'fof', 'all'))
	);


create table if not exists media (
	mid 		varchar(20) primary key not null,
	photo		bytea,
	video		bytea,
	audio		bytea,
	title		varchar(100),
	des_text	varchar(1000),
	media_time	timestamp with time zone not null,
	visib		varchar(20),
	check (visib in ('f', 'fof', 'all'))
	);

create table if not exists friend (
	username		varchar(20) not null, -- sender's username when sending the request
	username2		varchar(20) not null, -- receiver's username
	status		varchar(10) not null,
	res_time	timestamp with time zone not null, 
-- timestamp when the response has been made
	primary key (username, username2, status),
	check (status in ('pending', 'accepted', 'declined'))
	);

alter table friend add constraint friend_request_FK foreign key (username) references users (username);
alter table friend add constraint friend_request_FK2 foreign key (username2) references users (username);



create table if not exists greeting (
	username		varchar(20) not null, -- sender's username when sending the greeting
	username2		varchar(20) not null, -- receiver's username
	gre_time	timestamp with time zone not null,
	gre_text	varchar(1000),
	status		varchar(10) not null,
	primary key (username, username2, gre_time),
	check (status in ('unread', 'read'))
	);

alter table greeting add constraint friend_gre_FK foreign key (username) references users (username);
alter table greeting add constraint friend_gre_FK2 foreign key (username2) references users (username);

create table if not exists comment (
	cid 		varchar(20),
	did 		varchar(20),
	mid 		varchar(20),
	content	varchar(1000) not null,
	com_time	timestamp with time zone not null,
	primary key (cid)
	);

alter table comment add constraint comment_did_FK foreign key (did) references diary (did);
alter table comment add constraint comment_mid_FK foreign key (mid) references media (mid);


create table if not exists post_d (
	username 		varchar(20) not null,
	did		varchar(200) not null,
	primary key (username, did),
	foreign key (username) references users (username) on delete cascade,
	foreign key (did) references diary (did) on delete cascade
	);


create table if not exists post_p (
	username 		varchar(20) not null,
	pid		varchar(200) not null,
	primary key (username, pid),
	foreign key (username) references users (username) on delete cascade,
	foreign key (pid) references profile (pid) on delete cascade
	);

create table if not exists send (
	username 		varchar(20) not null,
	cid		varchar(200) not null,
	primary key (username, cid),
	foreign key (username) references users (username) on delete cascade,
	foreign key (cid) references comment (cid) on delete cascade
	);

create table if not exists post_m (
	username 		varchar(20) not null,
	mid		varchar(200) not null,
	primary key (username, mid),
	foreign key (username) references users (username) on delete cascade,
	foreign key (mid) references media (mid) on delete cascade
	);

create table if not exists has (
	did 		varchar(20) not null,
	mid		varchar(200) not null,
	primary key (did, mid),
	foreign key (did) references diary (did) on delete cascade,
	foreign key (mid) references media (mid) on delete cascade
	);
