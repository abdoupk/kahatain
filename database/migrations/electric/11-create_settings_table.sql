CREATE TYPE color_scheme AS ENUM (
    'default',
    'theme_1',
    'theme_2',
    'theme_3',
    'theme_4'
    );

CREATE TYPE theme AS ENUM (
    'enigma',
    'icewall',
    'tinker',
    'rubick'
    );

CREATE TYPE appearance AS ENUM ('light', 'dark');

CREATE TYPE layout AS ENUM ('top_menu', 'simple_menu', 'side_menu');

create table if not exists "settings"
(
    "id"            uuid                           not null primary key,
    "user_id"       uuid                           not null references "users" ("id"),
    "theme"         theme                          not null,
    "color_scheme"  color_scheme                   not null,
    "layout"        layout                         not null,
    "appearance"    appearance                     not null,
    "notifications" jsonb                          null,
    "locale"        text                           not null,
    "tenant_id"     uuid                           not null references "tenants" ("id") on delete cascade,
    "created_at"    timestamp(0) without time zone null,
    "updated_at"    timestamp(0) without time zone null
);

CREATE INDEX idx_settings_id ON settings (id);

CREATE INDEX idx_settings_user_id ON settings (user_id);
