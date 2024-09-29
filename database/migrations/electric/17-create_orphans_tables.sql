create table if not exists orphans
(
    "id"                     uuid primary key,
    "first_name"             text                           not null,
    "last_name"              text                           not null,
    "birth_date"             date                           not null,
    "family_status"          text                           null,
    "health_status"          text                           not null,
    "academic_level_id"      integer                        null,
    "vocational_training_id" integer                        null,
    "shoes_size"             text                           null,
    "pants_size"             text                           null,
    "shirt_size"             text                           null,
    "gender"                 text                           not null,
    "income"                 double precision               null,
    "is_handicapped"         boolean                        not null,
    "is_unemployed"          boolean                        not null,
    "note"                   text                           null,
    "tenant_id"              uuid                           not null references tenants (id) on delete cascade,
    "family_id"              uuid                           not null references families (id) on delete cascade,
    "sponsor_id"             uuid                           not null references sponsors (id) on delete cascade,
    "created_by"             uuid                           not null references users (id) on delete set null,
    "deleted_by"             uuid                           null references users (id) on delete set null,
    "created_at"             timestamp(0) without time zone null,
    "updated_at"             timestamp(0) without time zone null,
    "deleted_at"             timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_orphans_id ON orphans ("id");

CREATE INDEX idx_orphans_tenant_id ON orphans ("tenant_id");

CREATE INDEX idx_orphans_family_id ON orphans ("family_id");

CREATE INDEX idx_orphans_created_by ON orphans ("created_by");

CREATE INDEX idx_orphans_deleted_by ON orphans ("deleted_by");

CREATE INDEX idx_orphans_name ON orphans ("first_name", "last_name");

CREATE INDEX idx_orphans_birth_date ON orphans ("birth_date");

CREATE INDEX idx_orphans_family_status ON orphans ("family_status");

CREATE INDEX idx_orphans_health_status ON orphans ("health_status");

CREATE INDEX idx_orphans_academic_level ON orphans ("academic_level_id");

CREATE INDEX idx_orphans_shoes_size ON orphans ("shoes_size");

CREATE INDEX idx_orphans_pants_size ON orphans ("pants_size");

CREATE INDEX idx_orphans_shirt_size ON orphans ("shirt_size");

CREATE INDEX idx_orphans_note ON orphans ("note");
