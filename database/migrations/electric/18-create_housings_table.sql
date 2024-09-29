create table if not exists "housings"
(
    "id"                     uuid                           not null primary key,
    "name"                   text                           not null,
    "value"                  text                           not null,
    "housing_receipt_number" text                           null,
    "number_of_rooms"        integer                        null,
    "other_properties"       text                           null,
    "family_id"              uuid                           not null references "families" ("id") on delete cascade on update cascade,
    "tenant_id"              uuid                           not null references "tenants" ("id") on delete cascade on update cascade,
    "created_at"             timestamp(0) without time zone null,
    "updated_at"             timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_housings_id ON "housings" ("id");

CREATE INDEX idx_housings_name ON "housings" ("name");
