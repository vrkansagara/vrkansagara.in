-- we don't know how to generate root <with-no-name> (class Root) :(

create table search
(
	id integer
		constraint search_pk
			primary key autoincrement,
	name TEXT not null,
	content TEXT not null,
	url TEXT not null,
	tags TEXT not null,
	type TEXT
);

