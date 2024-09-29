create table "private_schools"
(
    "id"         uuid                           not null,
    "name"       text                           not null,
    "tenant_id"  uuid                           not null references "tenants" ("id") on delete cascade,
    "deleted_at" timestamp(0) without time zone null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null,
    "created_by" uuid                           not null references users (id) on delete set null,
    "deleted_by" uuid                           null references users (id) on delete set null
);

alter table "private_schools"
    add primary key ("id")
