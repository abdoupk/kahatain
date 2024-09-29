create table if not exists "cache"
(
    "key"        text    not null primary key,
    "value"      text    not null,
    "expiration" integer not null
);

create table if not exists "cache_locks"
(
    "key"        text    not null primary key,
    "owner"      text    not null,
    "expiration" integer not null
);
