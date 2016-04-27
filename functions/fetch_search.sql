-- DROP FUNCTION FetchSearchDiary4Me(character varying);
create or replace function FetchSearchDiary4Me (me varchar(20))
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
  union
  select my_diary.did, my_diary.username, diary.title, diary.diary_time
  from diary natural join
    (select * from post_d
      where post_d.username = me
    ) as my_diary
) as df_fof_diary
order by diary_time DESC;

end;
$$ language plpgsql;


-- DROP FUNCTION FetchSearchMedia4Me(character varying);
create or replace function FetchSearchMedia4Me (me varchar(20))
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
  union
  select media.mid, my_media.username, media.title, media.media_time
  from media natural join
    (select * from post_m
      where post_m.username = me
    ) as my_media
) as df_fof_media
order by media_time DESC;

end;
$$ language plpgsql;

-- -- Note: this is dirty way to concanate two tables
-- create or replace function FetchSearch4Me (me varchar(20))
--   returns table(id varchar, username varchar, title varchar, post_time timestamp with time zone) as $$
-- begin
--   return query
--   select F.did as feedid, F.username, F.title, F.diary_time as post_time
--   from
--   (select * from FetchSearchDiary4Me(me)
--   union
--   select * from FetchSearchMedia4Me(me)
--   ) as F
--   order by post_time DESC;
-- end;
-- $$ language plpgsql;

-- select * from FetchSearch4Me('aa');
