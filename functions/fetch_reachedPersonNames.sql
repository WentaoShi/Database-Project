-- Used when searching
-- reached person = f + fof + myself
create or replace function FetchReachedPersonNames (me varchar(20))
	returns table (reachedPersonNames varchar) as $$
begin
	return query
	select DISTINCT * from
	(
	select *  from FetchFriendNameList(me)
	union
	select *  from FetchFofNameList(me)
	union
	select username from users where username=me
	) as tmp;
end;
$$ language plpgsql;

-- select * from FetchReachedPersonNames('aa');
