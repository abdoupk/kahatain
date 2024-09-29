create table if not exists spouses
(
    "id"         uuid primary key,
    "first_name" text                           not null,
    "last_name"  text                           not null,
    "birth_date" date                           not null,
    "death_date" date                           not null,
    "function"   text                           not null,
    "income"     double precision               null,
    "family_id"  uuid                           not null references families (id) on delete cascade,
    "tenant_id"  uuid                           not null references tenants (id) on delete cascade,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null
);

-- Create Indexes
CREATE INDEX idx_spouses_id ON spouses ("id");

CREATE INDEX idx_spouses_family_id ON spouses ("family_id");

CREATE INDEX idx_spouses_tenant_id ON spouses ("tenant_id");

CREATE INDEX idx_spouses_name ON spouses ("first_name", "last_name");

CREATE INDEX idx_spouses_birth_date ON spouses ("birth_date");

CREATE INDEX idx_spouses_death_date ON spouses ("death_date");

CREATE INDEX idx_spouses_function ON spouses ("function");

CREATE INDEX idx_spouses_income ON spouses ("income");
