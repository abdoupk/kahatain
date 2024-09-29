create table "lessons"
(
    "id"                uuid                           not null,
    "subject_id"        integer                        not null,
    "academic_level_id" integer                        not null,
    "private_school_id" uuid                           not null references private_schools (id) on delete cascade,
    "quota"             integer                        not null,
    "tenant_id"         uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at"        timestamp(0) without time zone null,
    "updated_at"        timestamp(0) without time zone null,
    "deleted_at"        timestamp(0) without time zone null
);
alter table "lessons"
    add primary key ("id")
