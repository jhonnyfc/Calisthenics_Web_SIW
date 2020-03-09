/*
--Tabla Musculo
CREATE TABLE MUSCULO(
    IDMUSCULO NUMBER(1),
    NOMBRE VARCHAR2(20) NOT NULL,
    
    CONSTRAINT PK_MUSCULO PRIMARY KEY(IDMUSCULO),
    CONSTRAINT CH_IDMUSCULO CHECK(IDMUSCULO IN (0,1,2,3,4,5,6,7))
--0: triceps, 1: biceps, 2: pecho, 3: espalda, 4: hombros, 5: piernas, 6: core, 7: antebrazos
);
INSERT INTO MUSCULO VALUES ('0','Triceps');
INSERT INTO MUSCULO VALUES ('1','Biceps');
INSERT INTO MUSCULO VALUES ('2','Pecho');
INSERT INTO MUSCULO VALUES ('3','Espalda');
INSERT INTO MUSCULO VALUES ('4','Hombros');
INSERT INTO MUSCULO VALUES ('5','Piernas');
INSERT INTO MUSCULO VALUES ('6','Core');
INSERT INTO MUSCULO VALUES ('7','Antebrazos');
*/

--Tabla Grupo
CREATE TABLE GRUPO(
    IDGRUPO NUMBER(1),
    NOMBRE VARCHAR2(20) NOT NULL,
    
    CONSTRAINT PK_IDGRUPO PRIMARY KEY(IDGRUPO),
    CONSTRAINT CH_IDGRUPO CHECK(IDGRUPO IN (0,1,2,3,4,5,6))
--0: Full body, 1: pecho y triceps, 2: piernas, 3: espalda y biceps, 4: core, 5: hombros, 6: personalizado
);
INSERT INTO GRUPO VALUES ('0','Full Body');
INSERT INTO GRUPO VALUES ('1','Pecho y Triceps');
INSERT INTO GRUPO VALUES ('2','Piernas');
INSERT INTO GRUPO VALUES ('3','Espalda y biceps');
INSERT INTO GRUPO VALUES ('4','Core');
INSERT INTO GRUPO VALUES ('5','Hombros');
INSERT INTO GRUPO VALUES ('6','Personalizado');

--Tabla Ejercicio
CREATE TABLE EJERCICIO(
    IDEJERCICIO NUMBER(10),
    NOMBRE VARCHAR2(20) NOT NULL,
    NIVEL VARCHAR2(20) NOT NULL,
    DESCRIPCION VARCHAR2(500) NOT NULL,
    IDFOTO VARCHAR2(10) NOT NULL,
    
    CONSTRAINT PK_EJERCICIO PRIMARY KEY(IDEJERCICIO),
    CONSTRAINT CH_NIVEL CHECK(NIVEL IN ('Principiante','Intermedio','Avanzado'))
);

/*
--Atributo multivaluado de ejercicio
CREATE TABLE MUSCULO_EJERCICIO(
    IDMUSCULO NUMBER (1),
    IDEJERCICIO NUMBER(10) NOT NULL,
    
    CONSTRAINT PK_MUSCULO_EJERCICIO PRIMARY KEY(IDMUSCULO,IDEJERCICIO),
    CONSTRAINT FK_MUSCULO_EJERCICIO FOREIGN KEY (IDEJERCICIO) REFERENCES EJERCICIO(IDEJERCICIO) ON DELETE CASCADE,
    CONSTRAINT FK_MUSCULO FOREIGN KEY (IDMUSCULO) REFERENCES MUSCULO(IDMUSCULO) ON DELETE CASCADE
);
*/
--Tabla Rutina
CREATE TABLE RUTINA(
    IDRUTINA NUMBER(10),
    NOMBRE VARCHAR2(20) NOT NULL,
    IDGRUPO NUMBER(1) NOT NULL,
    IDUSUARIO VARCHAR2(10) NOT NULL,
    INTERVALO_TIEMPO NUMBER (6000) DEFAULT 180,--UNIDAD = SEGUNDOS
    
    CONSTRAINT PK_IDRUTINA PRIMARY KEY(IDRUTINA),
    CONSTRAINT FK_IDGRUPO FOREIGN KEY (IDGRUPO) REFERENCES GRUPO(IDGRUPO) ON DELETE CASCADE
);

--Tabla Ejercio_Rutina
CREATE TABLE EJERCICIO_RUTINA(
    IDRUTINA NUMBER(10),
    IDEJERCICIO NUMBER(10),
    
    CONSTRAINT PK_EJERCICIO_RUTINA PRIMARY KEY (IDRUTINA,IDEJERCICIO),
    CONSTRAINT FK_IDRUTINA FOREIGN KEY (IDRUTINA) REFERENCES RUTINA(IDRUTINA) ON DELETE CASCADE, 
    CONSTRAINT FK_IDEJERCICIO FOREIGN KEY (IDEJERCICIO) REFERENCES EJERCICIO(IDEJERCICIO) ON DELETE CASCADE
    
);

--Tabla Usuario
CREATE TABLE USUARIO(
    NICKNAME VARCHAR2(20),
    NOMBRE VARCHAR2(20) NOT NULL,
    APELLIDO VARCHAR2(20) DEFAULT NULL,
    CORREO VARCHAR2(50) NOT NULL,
    CONTRASEŅA VARCHAR2(50) NOT NULL,
    
    CONSTRAINT PK_NICKNAME PRIMARY KEY (NICKNAME)

);

--Tabla Valoracion
CREATE TABLE VALORACION(
    IDRUTINA NUMBER(10),
    VALORACION NUMBER(1) DEFAULT NULL,
    NICKNAME VARCHAR2(20),
    
    CONSTRAINT PK_VALORACION PRIMARY KEY (IDRUTINA,NICKNAME),
    CONSTRAINT CH_VALORACION CHECK(VALORACION IN (0,1,2,3,4,5)),
    CONSTRAINT FK_IDRUTINA_VALORACION FOREIGN KEY (IDRUTINA) REFERENCES RUTINA(IDRUTINA) ON DELETE CASCADE,
    CONSTRAINT FK_NICKAME_VALORACION FOREIGN KEY (NICKNAME) REFERENCES USUARIO(NICKNAME) ON DELETE CASCADE
);

--Tabla Tema
CREATE TABLE TEMA(
    IDTEMA NUMBER(10),
    NICKNAME VARCHAR2(20),
    FECHA_PUBLICACION DATE DEFAULT SYSDATE,
    NOMBRE VARCHAR2(50) NOT NULL,
    
    CONSTRAINT PK_IDTEMAS PRIMARY KEY (IDTEMA),
    CONSTRAINT FK_NICKNAME_TEMA FOREIGN KEY (NICKNAME) REFERENCES USUARIO(NICKNAME) ON DELETE CASCADE
);

--Tabla Mensaje
CREATE TABLE MENSAJE(
    IDMENSAJE NUMBER(10),
    NICKNAME VARCHAR2(20) NOT NULL,
    IDTEMA NUMBER(10) NOT NULL,
    CONTENIDO VARCHAR2(500) DEFAULT NULL,

    CONSTRAINT PK_IDMENSAJE PRIMARY KEY (IDMENSAJE),
    CONSTRAINT FK_NICKNAME_MENSAJE FOREIGN KEY (NICKNAME) REFERENCES USUARIO(NICKNAME) ON DELETE CASCADE,
    CONSTRAINT FK_IDTEMA_MENSAJE FOREIGN KEY (IDTEMA) REFERENCES TEMA(IDTEMA) ON DELETE CASCADE
);

--Tabla Publicacion
CREATE TABLE PUBLICACION(
    IDPUBLICACION NUMBER(10),
    FECHA_PUBLICACION DATE DEFAULT SYSDATE,
    CONTENIDO VARCHAR2(500) NOT NULL,
    AUTOR VARCHAR2(50) NOT NULL,
    
    CONSTRAINT PK_IDPUBLICACION PRIMARY KEY (IDPUBLICACION)
);

--Inserts de ejemplo:

INSERT INTO EJERCICIO VALUES (001,'Dominadas','Principiante','Subir y bajar.','3');
INSERT INTO MUSCULO_EJERCICIO VALUES (5,001);

SELECT *
FROM EJERCICIO E, MUSCULO_EJERCICIO EM
WHERE E.IDEJERCICIO=EM.IDEJERCICIO
;




























