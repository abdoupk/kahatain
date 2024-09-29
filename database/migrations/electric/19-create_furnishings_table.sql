create table if not exists "furnishings"
(
    "id"                uuid                           not null primary key,
    "television"        text                           not null,
    "refrigerator"      text                           not null,
    "fireplace"         text                           not null,
    "washing_machine"   text                           not null,
    "water_heater"      text                           not null,
    "oven"              text                           not null,
    "wardrobe"          text                           not null,
    "cupboard"          text                           not null,
    "covers"            text                           not null,
    "mattresses"        text                           not null,
    "other_furnishings" text                           not null,
    "family_id"         uuid                           not null references "families" ("id") on delete cascade on update cascade,
    "tenant_id"         uuid                           not null references "tenants" ("id") on delete cascade on update cascade,
    "created_at"        timestamp(0) without time zone null,
    "updated_at"        timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_furnishings_id ON "furnishings" ("id");
