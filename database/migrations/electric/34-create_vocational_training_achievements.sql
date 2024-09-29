create table if not exists "vocational_training_achievements"
(
    "id"                     uuid                           not null primary key,
    "tenant_id"              uuid                           not null references "tenants" ("id") on delete cascade,
    "orphan_id"              uuid                           not null references "orphans" ("id") on delete cascade,
    "note"                   text                           null,
    "year"                   integer                        not null,
    "vocational_training_id" integer                        not null,
    "institute"              text                           null,
    "deleted_at"             timestamp(0) without time zone null,
    "created_at"             timestamp(0) without time zone null,
    "updated_at"             timestamp(0) without time zone null
)
