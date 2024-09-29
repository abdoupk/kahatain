create table if not exists "jobs"
(
    "id"           bigserial not null primary key,
    "queue"        text      not null,
    "payload"      text      not null,
    "attempts"     smallint  not null,
    "reserved_at"  integer   null,
    "available_at" integer   not null,
    "created_at"   integer   not null
);

create index "jobs_queue_index" on "jobs" ("queue");

create table if not exists "job_batches"
(
    "id"             text    not null primary key,
    "name"           text    not null,
    "total_jobs"     integer not null,
    "pending_jobs"   integer not null,
    "failed_jobs"    integer not null,
    "failed_job_ids" text    not null,
    "options"        text    null,
    "cancelled_at"   integer null,
    "created_at"     integer not null,
    "finished_at"    integer null
);

create table if not exists "failed_jobs"
(
    "id"         bigserial                      not null primary key,
    "uuid"       text                           not null,
    "connection" text                           not null,
    "queue"      text                           not null,
    "payload"    text                           not null,
    "exception"  text                           not null,
    -- TODO: check how to handle default
    -- "failed_at" timestamp(0) without time zone not null default CURRENT_TIMESTAMP,
    "failed_at"  timestamp(0) without time zone not null
);

-- TODO: check how to fix
-- alter table
--     "failed_jobs"
-- add
--     constraint "failed_jobs_uuid_unique" unique ("uuid");
