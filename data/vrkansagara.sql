-- we don't know how to generate root <with-no-name> (class Root) :(

create table search
(
	id integer
		constraint search_pk
			primary key autoincrement,
	content TEXT not null,
	tags TEXT not null,
	url TEXT,
	type TEXT
);

