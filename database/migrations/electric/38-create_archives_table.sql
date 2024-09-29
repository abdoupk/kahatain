create table "archives"
(
    "id"         uuid                           not null,
    "tenant_id"  uuid                           not null references "tenants" ("id") on delete cascade,
    "saved_by"   uuid                           not null,
    "occasion"   text                           not null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null
);

-- alter table "archives"
--     add constraint "archives_tenant_id_foreign" foreign key ("tenant_id") references "tenants" ("id");


alter table "archives"
    add constraint "archives_saved_by_foreign" foreign key ("saved_by") references "users" ("id");

alter table "archives"
    add primary key ("id");
