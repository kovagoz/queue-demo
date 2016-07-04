DROP TABLE IF EXISTS log;

CREATE TABLE log (
    id serial,
    created_at timestamp NOT NULL,
    severity varchar(10) NOT NULL,
    message TEXT,
    PRIMARY KEY (id)
);
