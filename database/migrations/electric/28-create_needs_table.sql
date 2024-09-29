create table "needs"
(
    "id"            uuid                           not null,
    "demand"        text                           not null,
    "subject"       text                           not null,
    "status"        text                           not null,
    "needable_type" text                           not null,
    "needable_id"   uuid                           not null,
    "tenant_id"     uuid                           not null references tenants (id) on delete cascade,
    "note"          text                           null,
    "deleted_at"    timestamp(0) without time zone null,
    "created_at"    timestamp(0) without time zone null,
    "updated_at"    timestamp(0) without time zone null,
    "created_by"    uuid                           null references "users" ("id") on delete set null,
    "deleted_by"    uuid                           null references "users" ("id") on delete set null
);

create index "needs_needable_type_needable_id_index" on "needs" ("needable_type", "needable_id");

alter table "needs"
    add primary key ("id");
