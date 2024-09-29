create table "notifications"
(
    "id"              uuid                           not null,
    "type"            text                           not null,
    "notifiable_type" text                           not null,
    "notifiable_id"   uuid                           not null,
    "data"            text                           not null,
    "read_at"         timestamp(0) without time zone null,
    "created_at"      timestamp(0) without time zone null,
    "updated_at"      timestamp(0) without time zone null
);

create index "notifications_notifiable_type_notifiable_id_index" on "notifications" ("notifiable_type", "notifiable_id");
alter table "notifications"
    add primary key ("id")
