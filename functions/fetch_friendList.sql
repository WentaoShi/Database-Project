-- clear existed function
-- DROP FUNCTION FetchFriendNameList(character varying);
-- ref: http://stackoverflow.com/questions/11479577/postgresql-stored-procedure-with-returns-tableid-integer-returning-all-nulls

create or replace function FetchFriendNameList (me varchar(20))
	returns table (direct_friend varchar) as $$
begin
	return query
	select DISTINCT * from
	(
	select DISTINCT username2 as direct_friend from friend where username=me and status = 'accepted'
	union
	select DISTINCT username as direct_friend from friend where username2=me and status = 'accepted'
	) as tmp;
end;
$$ language plpgsql;

-- demo
-- select * from FetchFriendNameList('aa');

create or replace function FetchFriendTable (me varchar(20))
	returns table (direct_friend varchar, status varchar, res_time timestamp with time zone)as $$
begin
	return query
	select username2 as direct_friend, friend.status, friend.res_time from friend where friend.username=me and friend.status = 'accepted'
	union
	select username as direct_friend, friend.status, friend.res_time from friend where friend.username2=me and friend.status = 'accepted';
end;
$$ language plpgsql;

-- select * from FetchFriendTable('aa');