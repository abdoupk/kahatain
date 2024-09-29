create table event_occurrences
(
    "id"         uuid primary key,
    "start_date" timestamp(0) without time zone not null,
    "end_date"   timestamp(0) without time zone not null,
    "lesson_id"  uuid                           not null references lessons (id) on delete cascade,
    "event_id"   uuid                           not null references events (id) on delete cascade,
    "tenant_id"  uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null,
    "deleted_at" timestamp(0) without time zone null
)
