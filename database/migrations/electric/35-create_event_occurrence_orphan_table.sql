create table "event_occurrence_orphan"
(
    "id"                  uuid                           not null,
    "event_occurrence_id" uuid                           not null references event_occurrences (id) on delete cascade,
    "lesson_id"           uuid                           not null references lessons (id) on delete cascade,
    "orphan_id"           uuid                           not null references orphans (id) on delete cascade,
    "tenant_id"           uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at"          timestamp(0) without time zone null,
    "updated_at"          timestamp(0) without time zone null,
    "deleted_at"          timestamp(0) without time zone null
);

alter table "event_occurrence_orphan"
    add primary key ("id")
