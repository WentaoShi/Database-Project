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
	uid		varchar(20) primary key not null,
	username	varchar(20) not null,
	pwd		varchar(20) not null,  -- needs to be hashed 
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
	des_text	varchar(1000),
	media_time	timestamp with time zone not null,
	visib		varchar(20),
	check (visib in ('f', 'fof', 'all'))
	);

create table if not exists friend (
	uid		varchar(20) not null, -- sender's uid when sending the request
	uid2		varchar(20) not null, -- receiver's uid
	status		varchar(10) not null,
	res_time	timestamp with time zone not null, 
-- timestamp when the response has been made
	primary key (uid, uid2, status),
	check (status in ('pending', 'accepted', 'declined'))
	);

alter table friend add constraint friend_request_FK foreign key (uid) references users (uid);
alter table friend add constraint friend_request_FK2 foreign key (uid2) references users (uid);



create table if not exists greeting (
	uid		varchar(20) not null, -- sender's uid when sending the greeting
	uid2		varchar(20) not null, -- receiver's uid
	gre_time	timestamp with time zone not null,
	gre_text	varchar(1000),
	primary key (uid, uid2, gre_time)
	);

alter table greeting add constraint friend_gre_FK foreign key (uid) references users (uid);
alter table greeting add constraint friend_gre_FK2 foreign key (uid2) references users (uid);

create table if not exists comment (
	cid 		varchar(20),
	content	varchar(200) not null,
	com_time	timestamp with time zone not null,
	primary key (cid)
	);

create table if not exists post_d (
	uid 		varchar(20) not null,
	did		varchar(200) not null,
	primary key (uid, did),
	foreign key (uid) references users (uid) on delete cascade,
	foreign key (did) references diary (did) on delete cascade
	);


create table if not exists post_p (
	uid 		varchar(20) not null,
	pid		varchar(200) not null,
	primary key (uid, pid),
	foreign key (uid) references users (uid) on delete cascade,
	foreign key (pid) references profile (pid) on delete cascade
	);

create table if not exists send (
	uid 		varchar(20) not null,
	cid		varchar(200) not null,
	primary key (uid, cid),
	foreign key (uid) references users (uid) on delete cascade,
	foreign key (cid) references comment (cid) on delete cascade
	);

create table if not exists post_m (
	uid 		varchar(20) not null,
	mid		varchar(200) not null,
	primary key (uid, mid),
	foreign key (uid) references users (uid) on delete cascade,
	foreign key (mid) references media (mid) on delete cascade
	);

create table if not exists has (
	did 		varchar(20) not null,
	mid		varchar(200) not null,
	primary key (did, mid),
	foreign key (did) references diary (did) on delete cascade,
	foreign key (mid) references media (mid) on delete cascade
	);
