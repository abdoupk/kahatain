CREATE TABLE IF NOT EXISTS sponsors
(
    "id"                       uuid                           not null primary key,
    "first_name"               text                           null,
    "last_name"                text                           null,
    "phone_number"             text                           not null,
    "sponsor_type"             text                           not null,
    "birth_date"               date                           not null,
    "father_name"              text                           not null,
    "mother_name"              text                           not null,
    "birth_certificate_number" text                           null,
    "academic_level_id"        integer                        not null,
    "function"                 text                           null,
    "health_status"            text                           not null,
    "diploma"                  text                           null,
    "is_unemployed"            boolean                        not null,
    "ccp"                      text                           null,
    "gender"                   text                           not null,
    "family_id"                uuid                           not null references families (id) on delete cascade,
    tenant_id                  uuid                           not null references tenants (id) on delete cascade,
    "created_by"               uuid                           not null references users (id) on delete set null,
    "deleted_by"               uuid                           null references users (id) on delete set null,
    "deleted_at"               timestamp(0) without time zone null,
    "created_at"               timestamp(0) without time zone null,
    "updated_at"               timestamp(0) without time zone null
);

CREATE INDEX idx_sponsors_created_by ON sponsors ("created_by");

CREATE INDEX idx_sponsors_deleted_by ON sponsors ("deleted_by");

CREATE INDEX idx_sponsors_tenant_id ON sponsors ("tenant_id");
