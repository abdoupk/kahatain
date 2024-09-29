create table if not exists "academic_achievements"
(
    "id"                uuid                           not null primary key,
    "academic_level_id" integer                        null,
    "academic_year"     integer                        null,
    "first_trimester"   double precision               null,
    "second_trimester"  double precision               null,
    "third_trimester"   double precision               null,
    "average"           double precision               null,
    "note"              text                           null,
    "orphan_id"         uuid                           not null references "orphans" ("id") on delete cascade,
    "tenant_id"         uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at"        timestamp(0) without time zone null,
    "updated_at"        timestamp(0) without time zone null,
    "deleted_at"        timestamp(0) without time zone null
)
