create table if not exists "domains"
(
    "id"         uuid                           not null primary key,
    "domain"     text                           not null,
    "tenant_id"  uuid                           not null references "tenants" ("id") on delete cascade on update cascade,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp(0) without time zone null
);

create index idx_domains_id on domains (id);


-- TODO: check how to fix

-- alter table
--     "domains"
-- add
--     constraint "domains_domain_unique" unique ("domain");
