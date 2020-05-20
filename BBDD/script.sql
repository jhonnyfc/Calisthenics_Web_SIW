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
    IDEJERCICIO INT(10) NOT NULL AUTO_INCREMENT,
    NOMBRE_EJERCICIO VARCHAR(20) NOT NULL,
    MUSCULO int(1) NOT NULL,
    NIVEL_EJERCICIO VARCHAR(20) NOT NULL CHECK (NIVEL_EJERCICIO in ('Principiante', 'Intermedio', 'Avanzado')),
    DESCRIPCION VARCHAR(500) NOT NULL,
    IDFOTO VARCHAR(10) NOT NULL,
    
    CONSTRAINT PK_EJERCICIO PRIMARY KEY(IDEJERCICIO),
    CONSTRAINT FK_MUSCULO FOREIGN KEY (MUSCULO) REFERENCES final_GRUPO(IDGRUPO) ON DELETE CASCADE
);


CREATE TABLE final_RUTINA(
    IDRUTINA INT(10) NOT NULL AUTO_INCREMENT,
    NOMBRE_RUTINA VARCHAR(20) NOT NULL,
    IDGRUPO int(1) NOT NULL,
    IDUSUARIO VARCHAR(10) NOT NULL,
    INTERVALO_TIEMPO int(10) DEFAULT 180,
    NIVEL_RUTINA VARCHAR(20) NOT NULL CHECK (NIVEL_RUTINA in ('Principiante', 'Intermedio', 'Avanzado')),
    
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
    CONTRASEÑA VARCHAR(50) NOT NULL,
    SEXO VARCHAR(4) NOT NULL CHECK (SEXO in ('H', 'M', 'Otro', 'PND')),

    CONSTRAINT PK_NICKNAME_USUARIO PRIMARY KEY (NICKNAME)

);


    

CREATE TABLE final_VALORACION(
    IDRUTINA INT(10) NOT NULL AUTO_INCREMENT,
    VALORACION int(1) DEFAULT NULL CHECK (VALORACION IN (0,1,2,3,4,5)),
    NICKNAME VARCHAR(20),
    
    CONSTRAINT PK_VALORACION PRIMARY KEY (IDRUTINA,NICKNAME),
    CONSTRAINT FK_IDRUTINA_VALORACION FOREIGN KEY (IDRUTINA) REFERENCES final_RUTINA(IDRUTINA) ON DELETE CASCADE,
    CONSTRAINT FK_NICKAME_VALORACION FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

CREATE TABLE final_TEMA(
    IDTEMA INT(10) NOT NULL AUTO_INCREMENT,
    NICKNAME VARCHAR(20),
    FECHA_PUBLICACION TIMESTAMP DEFAULT NOW(),
    NOMBRE VARCHAR(50) NOT NULL,
    
    CONSTRAINT PK_IDTEMAS PRIMARY KEY (IDTEMA),
    CONSTRAINT FK_NICKNAME_TEMA FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
);

CREATE TABLE final_MENSAJE(
    IDMENSAJE INT(10) NOT NULL AUTO_INCREMENT,
    NICKNAME VARCHAR(20) NOT NULL,
    IDTEMA int(10) NOT NULL,
    CONTENIDO VARCHAR(500) DEFAULT NULL,
    FECHA_PUBLICACION_MENSAJE TIMESTAMP DEFAULT NOW(),
    CONSTRAINT PK_IDMENSAJE PRIMARY KEY (IDMENSAJE),
    CONSTRAINT FK_IDTEMA_MENSAJE FOREIGN KEY (IDTEMA) REFERENCES final_TEMA(IDTEMA) ON DELETE CASCADE
);

CREATE TABLE final_LIKES_TEMA(
    IDTEMA int(10),
    NICKNAME VARCHAR(20),
    
    CONSTRAINT PK_LIKES_MENSAJE PRIMARY KEY (IDTEMA,NICKNAME),
    CONSTRAINT FK_IDMTEMA FOREIGN KEY (IDTEMA) REFERENCES final_TEMA(IDTEMA) ON DELETE CASCADE, 
    CONSTRAINT FK_NICKNAME FOREIGN KEY (NICKNAME) REFERENCES final_USUARIO(NICKNAME) ON DELETE CASCADE
    
);

CREATE TABLE final_PUBLICACION(
    IDPUBLICACION INT(10) NOT NULL AUTO_INCREMENT,
    TITULO VARCHAR(50) NOT NULL,
    FECHA_PUBLICACION TIMESTAMP DEFAULT NOW(),
    CONTENIDO VARCHAR(500) NOT NULL,
    AUTOR VARCHAR(50) NOT NULL,
    
    
    CONSTRAINT PK_IDPUBLICACION PRIMARY KEY (IDPUBLICACION)
);


INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Dominadas',3,'Principiante','Subir y bajar.','eb004.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('FLEXIONES',1,'Principiante','Subir y bajar.','pt001.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Plancha abdominal',5,'Principiante','Subir y bajar.','pt012.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('FLEXIONES diamante',1,'Principiante','Subir y bajar.','pt007.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('pino',6,'Principiante','pino.','h002.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Flexiones inclinadas',1,'Principiante','Subir y bajar.','pt002.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Pistol squat',2,'Avanzado','Subir y bajar.','p009.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Back lever',1,'Intermedio','Subir y mantener.','h008.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Sentadillas sumo',2,'Principiante','Subir y bajar.','p008.jpg');
INSERT INTO final_EJERCICIO ( nombre_ejercicio, musculo, nivel_ejercicio, descripcion, idfoto) VALUES ('Dominadas',3,'Principiante','Subir y bajar.','eb004.jpg');


INSERT INTO final_USUARIO VALUES ('danidbg','Dani', 'del Barrio','dani@gmail.com','dani123','M');

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('RUTINA2',2,'Dani2',180, "Intermedio");
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,004);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,005);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,006);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('RUTINA1',5,'DANI',200, "Principiante");

INSERT INTO final_EJERCICIO_RUTINA VALUES (1,001);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,002);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,003);

INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('Mi primera dominada','texto1','vadym1');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('MI PRIMER MUSCLE UP','texto2 ','vadym2');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('hola','texto3','vadym3');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('adiosssss','texto4','vadym4');

INSERT INTO final_TEMA (nickname, nombre)VALUES ("danidbg", "primera dominada");
INSERT INTO final_mensaje (nickname, idtema, contenido) VALUES ("danidbg", 1, "no consigo hacer asfadg jdansj nsdkjgnsdjgnsdgjnksjdnsk.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 1, "Vete al gym la calistenia no sirve de nada.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 1, "ESPABILAESPABILAESPABILAESPABILAESPABILA.");



INSERT INTO final_TEMA (nickname, nombre)VALUES ("danidbg", "primera flexion");
INSERT INTO final_mensaje (nickname, idtema, contenido) VALUES ("danidbg", 2, "no consigo hacer asfadg jdansj nsdkjgnsdjgnsdgjnksjdnsk.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 2, "Vete al gym la calistenia no sirve de nada.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 2, "ESPABILAESPABILAESPABILAESPABILAESPABILA.");


INSERT INTO final_likes_tema VALUES (1, "danidbg");
INSERT INTO final_likes_tema VALUES (2, "danidbg");














