create table "events"
(
    "id"         uuid                           not null,
    "title"      text                           not null,
    "lesson_id"  uuid                           not null references lessons (id) on delete cascade,
    "start_date" timestamp(0) without time zone not null,
    "end_date"   timestamp(0) without time zone not null,
    frequency    text                           null,
    interval     integer                        null,
    until        date                           null,
    "color"      text                           null,
    "tenant_id"  uuid                           not null references "tenants" ("id") on delete cascade,
    "deleted_at" timestamp(0) without time zone null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null,
    "created_by" uuid                           not null references users (id) on delete set null,
    "deleted_by" uuid                           null references users (id) on delete set null
);

alter table "events"
    add primary key ("id")
