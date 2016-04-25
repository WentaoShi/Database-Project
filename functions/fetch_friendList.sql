select username2 as xfriend from friend where username='a1234' and status = 'accepted'
union
select username as xfriend from friend where username2='a1234' and status = 'accepted'