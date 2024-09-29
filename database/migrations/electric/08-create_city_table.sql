CREATE TABLE IF NOT EXISTS cities
(
    id                 INTEGER      NOT NULL PRIMARY KEY,
    commune_name       VARCHAR(255) NOT NULL,
    commune_name_ascii VARCHAR(255) NOT NULL,
    daira_name         VARCHAR(255) NOT NULL,
    daira_name_ascii   VARCHAR(255) NOT NULL,
    wilaya_code        VARCHAR(4)   NOT NULL,
    wilaya_name        VARCHAR(255) NOT NULL,
    wilaya_name_ascii  VARCHAR(255) NOT NULL,
    latitude           VARCHAR(255) NOT NULL,
    longitude          VARCHAR(255) NOT NULL,
    post_code          VARCHAR(5)   NOT NULL
);

CREATE INDEX idx_cities_id ON cities (id);
CREATE INDEX idx_cities_commune_name ON cities (commune_name);
CREATE INDEX idx_cities_daira_name ON cities (daira_name);
CREATE INDEX idx_cities_wilaya_code ON cities (wilaya_code);
CREATE INDEX idx_cities_wilaya_name ON cities (wilaya_name);
CREATE INDEX idx_cities_post_code ON cities (post_code);
