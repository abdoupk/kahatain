create table if not exists sponsor_sponsorship
(
    "id"                  uuid primary key,
    "sponsor_id"          uuid                           not null references sponsors (id) on delete cascade,
    "medical_sponsorship" text                           null,
    "literacy_lessons"    text                           null,
    "direct_sponsorship"  double precision               null,
    "project_support"     text                           null,
    "tenant_id"           uuid                           not null references "tenants" ("id") on delete cascade on update cascade,
    "created_at"          timestamp(0) without time zone null,
    "deleted_at"          timestamp(0) without time zone null,
    "updated_at"          timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_sponsor_sponsorship_id ON sponsor_sponsorship ("id");

CREATE INDEX idx_sponsor_sponsorship_sponsor_id ON sponsor_sponsorship ("sponsor_id");

CREATE INDEX idx_sponsor_sponsorship_tenant_id ON sponsor_sponsorship ("tenant_id");
