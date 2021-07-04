#BUSINESS
CREATE TABLE business (
    email   VARCHAR (255) PRIMARY KEY
                          NOT NULL,
    pass    VARCHAR (255) NOT NULL,
    name    TEXT (100)    NOT NULL,
    contact INTEGER (10)  UNIQUE
                          NOT NULL
                          CHECK (contact <= 9999999999),
    accno   INTEGER (50)  UNIQUE
                          DEFAULT (NULL) 
                          CHECK (accno > 99999999 AND 
                                 accno < 99999999999999999),
    ifsc    VARCHAR (11)  DEFAULT (NULL) 
);


#CUSTOMERS
CREATE TABLE customers (
    email   VARCHAR (255) NOT NULL,
    pass    VARCHAR (255) NOT NULL,
    name    TEXT (100)    NOT NULL,
    contact               UNIQUE
                          NOT NULL,
    pimage  VARCHAR (255) UNIQUE
                          DEFAULT NULL,
    PRIMARY KEY (
        email
    )
);


#PACKAGES
CREATE TABLE packages (
    pid        VARCHAR (255) PRIMARY KEY
                             NOT NULL,
    name       TEXT (100)    NOT NULL,
    dest       TEXT (100)    NOT NULL,
    dur        INTEGER (2)   NOT NULL
                             CHECK (dur < 31),
    cost       INTEGER (6)   NOT NULL
                             CHECK (cost > 2000 AND 
                                    cost < 200000),
    places     TEXT (200)    NOT NULL,
    food       INTEGER (1)   NOT NULL
                             CHECK (food IN (0, 1) ),
    ttype      TEXT (20)     NOT NULL
                             CHECK (ttype IN ('Air', 'Land') ),
    route      TEXT          NOT NULL,
    activities TEXT (100)    DEFAULT NULL,
    [desc]     TEXT (1000)   NOT NULL,
    islisted   INTEGER (1)   NOT NULL
                             CHECK (islisted IN (0, 1) ),
    bemail     VARCHAR (255) NOT NULL
                             REFERENCES business (email),
    stag1      TEXT (50)     NOT NULL,
    stag2      TEXT (50)     NOT NULL,
    stag3      TEXT (50)     NOT NULL,
    stag4      TEXT (50)     NOT NULL
);

#PKG_INFO
CREATE TABLE pkg_info (
    bid      VARCHAR (255) PRIMARY KEY
                           NOT NULL,
    pid      VARCHAR (255) NOT NULL
                           REFERENCES packages (pid),
    fromdate DATE          NOT NULL,
    todate   DATE          NOT NULL,
    approval INTEGER (1)   DEFAULT (NULL) 
                           CHECK (approval IN (0, 1) ),
    ispaid   INTEGER (1)   DEFAULT (NULL) 
                           CHECK (ispaid IN (0, 1) ),
    caccno   INTEGER (30)  NOT NULL,
    email                  NOT NULL
                           REFERENCES customers (email) 
);

#GUEST_INFO
CREATE TABLE guest_info (
    gemail VARCHAR (255) NOT NULL
                         REFERENCES pkg_info (email),
    name   TEXT (100)    NOT NULL,
    age    INTEGER (2)   CHECK (age < 90) 
                         NOT NULL,
    bid    VARCHAR (255) REFERENCES pkg_info (bid) 
                         NOT NULL,
    id     INTEGER (12)  NOT NULL,
    slno   INTEGER       PRIMARY KEY AUTOINCREMENT
                         NOT NULL
);


#REVIEW
CREATE TABLE review (
    email       VARCHAR (255) REFERENCES customers (email) 
                              NOT NULL,
    pid         VARCHAR (255) REFERENCES packages (pid) 
                              NOT NULL,
    bid                       NOT NULL,
    rimage      VARCHAR (255) DEFAULT NULL,
    description TEXT (1000)   DEFAULT NULL,
    rating      INT (1)       NOT NULL,
    PRIMARY KEY (
        email,
        pid
    )
);

#ADMIN
CREATE TABLE admin (
    email VARCHAR (255) PRIMARY KEY
                        NOT NULL,
    pass  VARCHAR (255) NOT NULL,
    name  TEXT (100)    NOT NULL
);



