create table if not exists "branches"
(
    "id"           uuid                           not null primary key,
    "name"         text                           not null,
    "tenant_id"    uuid                           not null references "tenants" ("id") on delete cascade,
    "city_id"      integer                        not null references "cities" ("id"),
    "president_id" uuid                           not null references "users" ("id") on delete NO ACTION,
    "created_at"   timestamp(0) without time zone null,
    "updated_at"   timestamp(0) without time zone null,
    "deleted_at"   timestamp(0) without time zone null,
    "created_by"   uuid                           not null references users (id) on delete set null,
    "deleted_by"   uuid                           null references users (id) on delete set null
)
