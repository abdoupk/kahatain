CREATE TABLE IF NOT EXISTS member_preview
(
    "id"         uuid not null primary key,
    "user_id"    uuid not null,
    "tenant_id"  uuid not null references "tenants" ("id") on delete cascade,
    "preview_id" uuid not null
);

-- Create Indexes
CREATE INDEX idx_member_preview_id ON member_preview ("id");

