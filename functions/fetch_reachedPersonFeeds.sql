select * from
diary natural join
	(select * from post_d
	where username in (select * from FetchReachedPersonNames('dd'))
	) as reached_diary;