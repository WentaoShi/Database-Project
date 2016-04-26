-- DROP FUNCTION FetchFeedsDiary4Me(character varying);
create or replace function FetchFeedsDiary4Me (me varchar(20))
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
) as df_fof_diary
order by diary_time DESC;

end;
$$ language plpgsql;


-- DROP FUNCTION FetchFeedsMedia4Me(character varying);
create or replace function FetchFeedsMedia4Me (me varchar(20))
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
) as df_fof_media
order by media_time DESC;

end;
$$ language plpgsql;

-- Note: this is dirty way to concanate two tables
create or replace function FetchFeeds4Me (me varchar(20))
  returns table(id varchar, username varchar, title varchar, post_time timestamp with time zone) as $$
begin
  return query
  select F.did as feedid, F.username, F.title, F.diary_time as post_time
  from
  (select * from FetchFeedsDiary4Me(me)
  union
  select * from FetchFeedsMedia4Me(me)
  ) as F
  order by post_time DESC;
end;
$$ language plpgsql;

select * from FetchFeeds4Me('aa');
