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
CREATE TABLE final_GRUPO(
    IDGRUPO NUMBER(1),
    NOMBRE_MUSCULO VARCHAR2(20) NOT NULL,
    
    CONSTRAINT PK_IDGRUPO PRIMARY KEY(IDGRUPO),
    CONSTRAINT CH_IDGRUPO CHECK(IDGRUPO IN (0,1,2,3,4,5,6))
--0: Full body, 1: pecho y triceps, 2: piernas, 3: espalda y biceps, 4: core, 5: hombros, 6: personalizado
);
INSERT INTO final_GRUPO VALUES ('0','Full Body');
INSERT INTO final_GRUPO VALUES ('1','Pecho y Triceps');
INSERT INTO final_GRUPO VALUES ('2','Piernas');
INSERT INTO final_GRUPO VALUES ('3','Espalda y biceps');
INSERT INTO final_GRUPO VALUES ('4','Core');
INSERT INTO final_GRUPO VALUES ('5','Hombros');
INSERT INTO final_GRUPO VALUES ('6','Personalizado');
/*
CREATE TABLE final_GRUPO(
    IDGRUPO int(1) check (idgrupo in (0,1,2,3,4,5,6)),
    NOMBRE VARCHAR(20) NOT NULL,
    
    CONSTRAINT PK_IDGRUPO PRIMARY KEY(IDGRUPO)
);
*/

--Tabla Ejercicio
CREATE TABLE final_EJERCICIO(
    IDEJERCICIO NUMBER(10),
    NOMBRE_EJERCICIO VARCHAR2(20) NOT NULL,
    MUSCULO NUMBER(1) NOT NULL,
    NIVEL_EJERCICIO VARCHAR2(20) NOT NULL,
    DESCRIPCION VARCHAR2(500) NOT NULL,
    IDFOTO VARCHAR2(10) NOT NULL,
    FAVORITO INT(1) DEFAULT 0,
    
    CONSTRAINT PK_EJERCICIO PRIMARY KEY(IDEJERCICIO),
    CONSTRAINT FK_MUSCULO FOREIGN KEY (MUSCULO) REFERENCES final_GRUPO(IDGRUPO) ON DELETE CASCADE,
    CONSTRAINT CH_NIVEL CHECK(NIVEL_EJERCICIO IN ('Principiante','Intermedio','Avanzado'))
);
/* //Cuidado con los checks
CREATE TABLE final_EJERCICIO(
    IDEJERCICIO int(10),
    NOMBRE VARCHAR(20) NOT NULL,
    MUSCULO int(1) NOT NULL,
    NIVEL VARCHAR(20) NOT NULL CHECK (NIVEL in ('Principiante', 'Intermedio', 'Avanzado')),
    DESCRIPCION VARCHAR(500) NOT NULL,
    IDFOTO VARCHAR(10) NOT NULL,
    
    CONSTRAINT PK_EJERCICIO PRIMARY KEY(IDEJERCICIO),
    CONSTRAINT FK_MUSCULO FOREIGN KEY (MUSCULO) REFERENCES final_GRUPO(IDGRUPO) ON DELETE CASCADE
);
*/
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
CREATE TABLE final_RUTINA(
    IDRUTINA NUMBER(10),
    NOMBRE_RUTINA VARCHAR2(20) NOT NULL,
    IDGRUPO NUMBER(1) NOT NULL,
    IDUSUARIO VARCHAR2(10) NOT NULL,
    INTERVALO_TIEMPO NUMBER (10) DEFAULT 180,--UNIDAD = SEGUNDOS
    
    CONSTRAINT PK_IDRUTINA PRIMARY KEY(IDRUTINA),
    CONSTRAINT FK_IDGRUPO FOREIGN KEY (IDGRUPO) REFERENCES final_GRUPO(IDGRUPO) ON DELETE CASCADE
);

--Tabla Ejercio_Rutina
CREATE TABLE final_EJERCICIO_RUTINA(
    IDRUTINA NUMBER(10),
    IDEJERCICIO NUMBER(10),
    
    CONSTRAINT PK_EJERCICIO_RUTINA PRIMARY KEY (IDRUTINA,IDEJERCICIO),
    CONSTRAINT FK_IDRUTINA FOREIGN KEY (IDRUTINA) REFERENCES final_RUTINA(IDRUTINA) ON DELETE CASCADE, 
    CONSTRAINT FK_IDEJERCICIO FOREIGN KEY (IDEJERCICIO) REFERENCES final_EJERCICIO(IDEJERCICIO) ON DELETE CASCADE
    
);

--Tabla Usuario
CREATE TABLE final_USUARIO(
    NICKNAME VARCHAR2(20),
    NOMBRE VARCHAR2(20) NOT NULL,
    APELLIDO VARCHAR2(20) DEFAULT NULL,
    CORREO VARCHAR2(50) NOT NULL,
    CONTRASEŅA VARCHAR2(50) NOT NULL,
    
    CONSTRAINT PK_NICKNAME_USUARIO PRIMARY KEY (NICKNAME)

);

--Tabla Usuario_Rutina
CREATE TABLE final_USUARIO_RUTINA(
    IDRUTINA NUMBER(10),
    NICKNAME VARCHAR2(20),
    
    CONSTRAINT PK_EJERCICIO_USUARIO PRIMARY KEY (IDRUTINA,NICKNAME),
    CONSTRAINT FK_IDRUTINA_USUARIO FOREIGN KEY (IDRUTINA) REFERENCES final_RUTINA(IDRUTINA) ON DELETE CASCADE, 
    CONSTRAINT FK_IDEJERCICIO_USUARIO FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

--Tabla Valoracion
CREATE TABLE final_VALORACION(
    IDRUTINA NUMBER(10),
    VALORACION NUMBER(1) DEFAULT NULL,
    NICKNAME VARCHAR2(20),
    
    CONSTRAINT PK_VALORACION PRIMARY KEY (IDRUTINA,NICKNAME),
    CONSTRAINT CH_VALORACION CHECK(VALORACION IN (0,1,2,3,4,5)),
    CONSTRAINT FK_IDRUTINA_VALORACION FOREIGN KEY (IDRUTINA) REFERENCES final_RUTINA(IDRUTINA) ON DELETE CASCADE,
    CONSTRAINT FK_NICKAME_VALORACION FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

--Tabla Tema
CREATE TABLE final_TEMA(
    IDTEMA NUMBER(10),
    NICKNAME VARCHAR2(20),
    FECHA_PUBLICACION DATE DEFAULT SYSDATE,
    NOMBRE VARCHAR2(50) NOT NULL,
    
    CONSTRAINT PK_IDTEMAS PRIMARY KEY (IDTEMA),
    CONSTRAINT FK_NICKNAME_TEMA FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

--Tabla Mensaje
CREATE TABLE final_MENSAJE(
    IDMENSAJE NUMBER(10),
    NICKNAME VARCHAR2(20) NOT NULL,
    IDTEMA NUMBER(10) NOT NULL,
    CONTENIDO VARCHAR2(500) DEFAULT NULL,

    CONSTRAINT PK_IDMENSAJE PRIMARY KEY (IDMENSAJE),
    CONSTRAINT FK_NICKNAME_MENSAJE FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE,
    CONSTRAINT FK_IDTEMA_MENSAJE FOREIGN KEY (IDTEMA) REFERENCES final_TEMA(IDTEMA) ON DELETE CASCADE
);

--Tabla Publicacion
CREATE TABLE final_PUBLICACION(
    IDPUBLICACION NUMBER(10),
    TITULO VARCHAR2(50) NOT NULL,
    FECHA_PUBLICACION DATE DEFAULT SYSDATE,
    CONTENIDO VARCHAR2(500) NOT NULL,
    AUTOR VARCHAR2(50) NOT NULL,
    
    
    CONSTRAINT PK_IDPUBLICACION PRIMARY KEY (IDPUBLICACION)
);

--Inserts de ejemplo:

INSERT INTO final_EJERCICIO VALUES (001,'Dominadas',3,'Principiante','Subir y bajar.','3');
INSERT INTO final_EJERCICIO VALUES (002,'FLEXIONES',1,'Principiante','Subir y bajar.','4');
INSERT INTO final_EJERCICIO VALUES (003,'bandera humana',3,'Avanzado','Bandera.','5');
INSERT INTO final_EJERCICIO VALUES (004,'abdominales',4,'Principiante','Subir y bajar.','14');
INSERT INTO final_EJERCICIO VALUES (005,'FLEXIONES diamante',1,'Principiante','Subir y bajar.','pt24');
INSERT INTO final_EJERCICIO VALUES (006,'pino',5,'Principiante','pino.','eb14');

INSERT INTO final_RUTINA VALUES (1,'RUTINA1',5,'DANI',200);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,001);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,002);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,003);

INSERT INTO final_RUTINA (IDRUTINA,NOMBRE_RUTINA,IDGRUPO,IDUSUARIO) VALUES (3,'RUTINA2',2,'LOL');
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,004);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,005);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,006);

INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('1','Mi primera dominada','texto1','vadym1');
INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('2','MI PRIMER MUSCLE UP','texto2 ','vadym2');
INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('3','hola','texto3','vadym3');
INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('4','adiosssss','texto4','vadym4');


/*
SELECT *
FROM final_EJERCICIO 
;
*/


/* Script a ejecutar en mysql */
/*

CREATE TABLE final_GRUPO(
    IDGRUPO int(1) check (idgrupo in (0,1,2,3,4,5,6)),
    NOMBRE_MUSCULO VARCHAR(20) NOT NULL,
    
    CONSTRAINT PK_IDGRUPO PRIMARY KEY(IDGRUPO)
);

INSERT INTO final_GRUPO VALUES ('0','Full Body');
INSERT INTO final_GRUPO VALUES ('1','Pecho y Triceps');
INSERT INTO final_GRUPO VALUES ('2','Piernas');
INSERT INTO final_GRUPO VALUES ('3','Espalda y biceps');
INSERT INTO final_GRUPO VALUES ('4','Core');
INSERT INTO final_GRUPO VALUES ('5','Hombros');
INSERT INTO final_GRUPO VALUES ('6','Personalizado');


CREATE TABLE final_EJERCICIO(
    IDEJERCICIO int(10),
    NOMBRE_EJERCICIO VARCHAR(20) NOT NULL,
    MUSCULO int(1) NOT NULL,
    NIVEL_EJERCICIO VARCHAR(20) NOT NULL CHECK (NIVEL_EJERCICIO in ('Principiante', 'Intermedio', 'Avanzado')),
    DESCRIPCION VARCHAR(500) NOT NULL,
    IDFOTO VARCHAR(10) NOT NULL,
    
    CONSTRAINT PK_EJERCICIO PRIMARY KEY(IDEJERCICIO),
    CONSTRAINT FK_MUSCULO FOREIGN KEY (MUSCULO) REFERENCES final_GRUPO(IDGRUPO) ON DELETE CASCADE
);


CREATE TABLE final_RUTINA(
    IDRUTINA int(10),
    NOMBRE_RUTINA VARCHAR(20) NOT NULL,
    IDGRUPO int(1) NOT NULL,
    IDUSUARIO VARCHAR(10) NOT NULL,
    INTERVALO_TIEMPO int(10) DEFAULT 180,
    
    CONSTRAINT PK_IDRUTINA PRIMARY KEY(IDRUTINA),
    CONSTRAINT FK_IDGRUPO FOREIGN KEY (IDGRUPO) REFERENCES final_GRUPO(IDGRUPO) ON DELETE CASCADE
);


CREATE TABLE final_EJERCICIO_RUTINA(
    IDRUTINA int(10),
    IDEJERCICIO int(10),
    
    CONSTRAINT PK_EJERCICIO_RUTINA PRIMARY KEY (IDRUTINA,IDEJERCICIO),
    CONSTRAINT FK_IDRUTINA FOREIGN KEY (IDRUTINA) REFERENCES final_RUTINA(IDRUTINA) ON DELETE CASCADE, 
    CONSTRAINT FK_IDEJERCICIO FOREIGN KEY (IDEJERCICIO) REFERENCES final_EJERCICIO(IDEJERCICIO) ON DELETE CASCADE
    
);


CREATE TABLE final_USUARIO(
    NICKNAME VARCHAR(20),
    NOMBRE VARCHAR(20) NOT NULL,
    APELLIDO VARCHAR(20) DEFAULT NULL,
    CORREO VARCHAR(50) NOT NULL,
    CONTRASEŅA VARCHAR(50) NOT NULL,
    
    CONSTRAINT PK_NICKNAME_USUARIO PRIMARY KEY (NICKNAME)

);


	

CREATE TABLE final_VALORACION(
    IDRUTINA int(10),
    VALORACION int(1) DEFAULT NULL CHECK (VALORACION IN (0,1,2,3,4,5)),
    NICKNAME VARCHAR(20),
    
    CONSTRAINT PK_VALORACION PRIMARY KEY (IDRUTINA,NICKNAME),
    CONSTRAINT FK_IDRUTINA_VALORACION FOREIGN KEY (IDRUTINA) REFERENCES final_RUTINA(IDRUTINA) ON DELETE CASCADE,
    CONSTRAINT FK_NICKAME_VALORACION FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

CREATE TABLE final_TEMA(
    IDTEMA int(10),
    NICKNAME VARCHAR(20),
    FECHA_PUBLICACION TIMESTAMP DEFAULT NOW(),
    NOMBRE VARCHAR(50) NOT NULL,
    
    CONSTRAINT PK_IDTEMAS PRIMARY KEY (IDTEMA),
    CONSTRAINT FK_NICKNAME_TEMA FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

CREATE TABLE final_MENSAJE(
    IDMENSAJE int(10),
    NICKNAME VARCHAR(20) NOT NULL,
    IDTEMA int(10) NOT NULL,
    CONTENIDO VARCHAR(500) DEFAULT NULL,

    CONSTRAINT PK_IDMENSAJE PRIMARY KEY (IDMENSAJE),
    CONSTRAINT FK_NICKNAME_MENSAJE FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE,
    CONSTRAINT FK_IDTEMA_MENSAJE FOREIGN KEY (IDTEMA) REFERENCES final_TEMA(IDTEMA) ON DELETE CASCADE
);

CREATE TABLE final_PUBLICACION(
    IDPUBLICACION int(10),
    TITULO VARCHAR(50) NOT NULL,
    FECHA_PUBLICACION TIMESTAMP DEFAULT NOW(),
    CONTENIDO VARCHAR(500) NOT NULL,
    AUTOR VARCHAR(50) NOT NULL,
    
    
    CONSTRAINT PK_IDPUBLICACION PRIMARY KEY (IDPUBLICACION)
);


INSERT INTO final_EJERCICIO VALUES (001,'Dominadas',3,'Principiante','Subir y bajar.','eb004.jpg');
INSERT INTO final_EJERCICIO VALUES (002,'FLEXIONES',1,'Principiante','Subir y bajar.','pt001.jpg');
INSERT INTO final_EJERCICIO VALUES (003,'bandera humana',3,'Avanzado','Bandera.','eb009.jpg');
INSERT INTO final_EJERCICIO VALUES (004,'Plancha abdominal',5,'Principiante','Subir y bajar.','pt012.jpg');
INSERT INTO final_EJERCICIO VALUES (005,'FLEXIONES diamante',1,'Principiante','Subir y bajar.','pt007.jpg');
INSERT INTO final_EJERCICIO VALUES (006,'pino',6,'Principiante','pino.','h002.jpg');
INSERT INTO final_EJERCICIO VALUES (007,'Dominadas arqueras',3,'Principiante','Subir y bajar.','eb011.jpg');
INSERT INTO final_EJERCICIO VALUES (008,'Flexiones inclinadas',1,'Principiante','Subir y bajar.','pt002.jpg');
INSERT INTO final_EJERCICIO VALUES (009,'Pistol squat',2,'Avanzado','Subir y bajar.','p009.jpg');
INSERT INTO final_EJERCICIO VALUES (010,'Back lever',1,'Intermedio','Subir y mantener.','h008.jpg');
INSERT INTO final_EJERCICIO VALUES (011,'Sentadillas sumo',2,'Principiante','Subir y bajar.','p008.jpg');



INSERT INTO final_USUARIO VALUES ('danidbg','Dani', 'del Barrio','dani@gmail.com','dani123');

INSERT INTO final_RUTINA VALUES (2,'RUTINA2',2,'Dani2',180);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,004);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,005);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,006);

INSERT INTO final_RUTINA VALUES (1,'RUTINA1',5,'DANI',200);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,001);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,002);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,003);

INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('1','Mi primera dominada','texto1','vadym1');
INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('2','MI PRIMER MUSCLE UP','texto2 ','vadym2');
INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('3','hola','texto3','vadym3');
INSERT INTO final_PUBLICACION (IDPUBLICACION,TITULO,CONTENIDO,AUTOR) VALUES ('4','adiosssss','texto4','vadym4');

INSERT INTO final_TEMA (idtema, nickname, nombre) VALUES (001, 'danidbg', 'estoy mamadisimo');


*/




















