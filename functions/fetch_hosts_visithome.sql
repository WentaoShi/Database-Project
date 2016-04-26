--DROP FUNCTION FetchHostsFeedsDiary4Me(character varying);
create or replace function FetchHostsFeedsDiary4Me (me varchar(20), host varchar(20))
  returns table (did varchar, username varchar, title varchar, diary_time timestamp with time zone) as $$
begin
  return query
select distinct *
from
(
  select df_diary.did, df_diary.username, diary.title, diary.diary_time 
  from diary natural join
    (select * from post_d
    where post_d.username in (select * from FetchFriendNameList(me))
    ) as df_diary
  where visib in ('all', 'f')
  union
  select fof_diary.did, fof_diary.username, diary.title, diary.diary_time
  from diary natural join
    (select * from post_d
    where post_d.username in (select * from FetchFofNameList(me))
    ) as fof_diary
  where visib in ('all', 'fof')
) as df_fof_diary where df_fof_diary.username = host 
order by diary_time DESC;

end;
$$ language plpgsql;


--DROP FUNCTION FetchHostsFeedsDiary4Me(character varying);
create or replace function FetchHostsFeedsMedia4Me (me varchar(20), host varchar(20))
  returns table (mid varchar, username varchar, title varchar, media_time timestamp with time zone) as $$
begin
  return query
select distinct *
from
(
  select media.mid, df_media.username, media.title, media.media_time 
  from media natural join
    (select * from post_m
    where post_m.username in (select * from FetchFriendNameList(me))
    ) as df_media
  where visib in ('all', 'f')
  union
  select media.mid, fof_media.username, media.title, media.media_time
  from media natural join
    (select * from post_m
    where post_m.username in (select * from FetchFofNameList(me))
    ) as fof_media
  where visib in ('all', 'fof')
) as df_fof_media where df_fof_media.username = host 
order by media_time DESC;

end;
$$ language plpgsql;