create table if not exists "personal_access_tokens"
(
    "id"             uuid                           not null primary key,
    "tokenable_type" text                           not null,
    "tokenable_id"   uuid                           not null,
    "name"           text                           not null,
    "token"          text                           not null,
    "abilities"      text                           null,
    "last_used_at"   timestamp(0) without time zone null,
    "expires_at"     timestamp(0) without time zone null,
    "created_at"     timestamp(0) without time zone null,
    "updated_at"     timestamp(0) without time zone null
);

create index "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens" ("tokenable_type", "tokenable_id");

-- TODO: check how to fix
-- alter table
--     "personal_access_tokens"
-- add
--     constraint "personal_access_tokens_token_unique" unique ("token");
