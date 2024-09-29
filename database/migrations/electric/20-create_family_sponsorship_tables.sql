create table if not exists family_sponsorship
(
    "id"                 uuid primary key,
    "family_id"          uuid                           not null references families (id) on delete cascade,
    "monthly_allowance"  text                           null,
    "ramadan_basket"     text                           null,
    "zakat"              text                           null,
    "housing_assistance" text                           null,
    "eid_al_adha"        text                           null,
    "tenant_id"          uuid                           not null references "tenants" ("id") on delete cascade on update cascade,
    "created_at"         timestamp(0) without time zone null,
    "deleted_at"         timestamp(0) without time zone null,
    "updated_at"         timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_family_sponsorship_id ON family_sponsorship ("id");

CREATE INDEX idx_family_sponsorship_family_id ON family_sponsorship ("family_id");

CREATE INDEX idx_family_sponsorship_tenant_id ON family_sponsorship ("tenant_id");
