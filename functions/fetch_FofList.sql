-- Dependencies: FetchFriendNameList

create or replace function FetchFofNameList (me varchar(20))
	returns table (friend_of_friend varchar) as $$
begin
	return query
	select DISTINCT * from
	(
	select username as fof from friend
	where username2 in (select * from FetchFriendNameList(me)) and username != me
	union
	select username2 as fof from friend
	where username in (select * from FetchFriendNameList(me)) and username2 != me
	) as tmp;
end;
$$ language plpgsql;

-- select * from FetchFofNameList('aa');
