CREATE TABLE final_BK_ADMINISTRADORES(
    ID_ADMIN    INTEGER,
    NOMBRE      VARCHAR(20) NOT NULL,
    APPELLIDO1  VARCHAR(20) NOT NULL,
    APPELLIDO2  VARCHAR(20),
    CORREO      VARCHAR(30) NOT NULL,
    PASSWORDA   VARCHAR(30) NOT NULL,
    FECH_ALTA   DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT PK_ADMIN PRIMARY KEY (ID_ADMIN));

INSERT INTO final_ADMINISTRADORES (ID_ADMIN,NOMBRE,APPELLIDO1,APPELLIDO2,CORREO,PASSWORDA)
    VALUES (1,'Jhonny','Chicaiza','Palomo','jhonnyfc88@gmail.com','123456');

CREATE TABLE `db_grupo33`.`ft` ( `xd` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , `gt` INT NULL DEFAULT NULL ) ENGINE = InnoDB;