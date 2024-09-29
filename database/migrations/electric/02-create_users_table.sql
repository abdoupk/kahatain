CREATE TYPE gender AS ENUM ('male', 'female');

create table if not exists "users"
(
    "id"                uuid                           not null primary key,
    "first_name"        text                           not null,
    "last_name"         text                           not null,
    "phone"             text                           null,
    "email"             text                           not null,
    "address"           text                           null,
    "gender"            gender                         null,
    "qualification"     text                           null,
    "zone_id"           uuid                           null,
    "branch_id"         uuid                           null,
    "email_verified_at" timestamp(0) without time zone null,
    "password"          text                           not null,
    "remember_token"    text                           null,
    "tenant_id"         uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at"        timestamp(0) without time zone null,
    "created_by"        uuid                           null references "users" ("id") on delete set null,
    "deleted_by"        uuid                           null references "users" ("id") on delete set null,
    "updated_at"        timestamp(0) without time zone null,
    "deleted_at"        timestamp(0) without time zone null
);
-- TODO: check how to fix
-- alter table "users"
-- add
-- constraint "users_email_unique" unique ("email");
create table if not exists "password_reset_tokens"
(
    "email"      text                           not null primary key,
    "token"      text                           not null,
    "created_at" timestamp(0) without time zone null
);
create table if not exists "sessions"
(
    "id"            text    not null primary key,
    "user_id"       uuid    null references "users" ("id") on delete cascade,
    "ip_address"    text    null,
    "user_agent"    text    null,
    "payload"       text    not null,
    "last_activity" integer not null
);

create index "sessions_user_id_index" on "sessions" ("user_id");

create index "sessions_last_activity_index" on "sessions" ("last_activity");


create index idx_users_id on users (id);

create index idx_user_zone_id on users (zone_id);

create index idx_user_branch_id on users (branch_id);
