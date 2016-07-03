DROP TABLE IF EXISTS log;

CREATE TABLE log (
    id serial,
    ts timestamp NOT NULL,
    severity varchar(10) NOT NULL,
    msg TEXT,
    PRIMARY KEY (id)
);
