create table if not exists "permissions"
(
    "uuid"       uuid                           not null primary key,
    "name"       text                           not null,
    "guard_name" text                           not null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null
);


-- TODO: check how to fix
-- alter table
--     "permissions"
-- add
--     constraint "permissions_name_guard_name_unique" unique ("name", "guard_name");

create table if not exists "roles"
(
    "uuid"       uuid                           not null primary key,
    "name"       text                           not null,
    "guard_name" text                           not null,
    "tenant_id"  uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null
);


-- TODO: check how to fix
-- alter table
--     "roles"
-- add
--     constraint "roles_name_guard_name_unique" unique ("name", "guard_name");

create table if not exists "model_has_permissions"
(
    "permission_id" uuid not null references "permissions" ("uuid") on delete cascade,
    "model_type"    text not null,
    "tenant_id"     uuid not null references "tenants" ("id") on delete cascade,
    "model_uuid"    uuid not null
);

create index "model_has_permissions_model_id_model_type_index" on "model_has_permissions" ("model_uuid", "model_type");


alter table
    "model_has_permissions"
    add
        primary key ("permission_id", "model_uuid", "model_type");

create table if not exists "model_has_roles"
(
    "role_id"    uuid not null references "roles" ("uuid") on delete cascade,
    "model_type" text not null,
    "tenant_id"  uuid not null references "tenants" ("id") on delete cascade,
    "model_uuid" uuid not null
);

create index "model_has_roles_model_id_model_type_index" on "model_has_roles" ("model_uuid", "model_type");

alter table
    "model_has_roles"
    add
        primary key ("role_id", "model_uuid", "model_type");

create table if not exists "role_has_permissions"
(
    "permission_id" uuid not null references "permissions" ("uuid") on delete cascade,
    "role_id"       uuid not null references "roles" ("uuid") on delete cascade
);

alter table
    "role_has_permissions"
    add
        primary key ("permission_id", "role_id");

delete
from "cache"
where "key" = 'spatie.permission.cache';
