CREATE TABLE IF NOT EXISTS previews
(
    "id"           uuid                           not null primary key,
    "report"       text                           not null,
    "preview_date" date                           not null,
    "family_id"    text                           not null,
    "tenant_id"    uuid                           not null,
    "deleted_at"   timestamp(0) without time zone null,
    "created_at"   timestamp(0) without time zone null,
    "updated_at"   timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_preview_id ON previews ("id");

