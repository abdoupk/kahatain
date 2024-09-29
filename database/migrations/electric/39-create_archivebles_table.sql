create table "archiveables"
(
    "archive_id"       uuid not null,
    "archiveable_id"   uuid not null,
    "archiveable_type" text not null,
    "tenant_id"        uuid not null references "tenants" ("id") on delete cascade
);
