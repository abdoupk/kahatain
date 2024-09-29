create type item_unit as enum ( 'kg', 'liter', 'piece' );
create table if not exists "inventories"
(
    "id"             uuid                           not null primary key,
    "name"           text                           not null,
    "qty"            integer                        not null,
    "unit"           item_unit                      not null,
    "type"           text                           null,
    "note"           text                           null,
    "qty_for_family" integer                        null,
    "tenant_id"      uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at"     timestamp(0) without time zone null,
    "created_by"     uuid                           not null references "users" ("id") on delete set null,
    "deleted_by"     uuid                           not null references "users" ("id") on delete set null,
    "updated_at"     timestamp(0) without time zone null,
    "deleted_at"     timestamp(0) without time zone null
)
