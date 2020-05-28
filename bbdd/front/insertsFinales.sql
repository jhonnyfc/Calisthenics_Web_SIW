INSERT INTO final_USUARIO (NICKNAME, NOMBRE, APELLIDO, CORREO, CONTRASEÑA, SEXO) VALUES ('laura123','Laura', 'Garcia Perez','laura@gmail.com','58907c27b5ac1ad7289a6a56657b9e90','M');
INSERT INTO final_USUARIO (NICKNAME, NOMBRE, APELLIDO, CORREO, CONTRASEÑA, SEXO) VALUES ('Esther_99','Esther', 'Garcia Arroyo','esther@gmail.com','2679515fce1abbf859666f75261c0c32','M');
INSERT INTO final_USUARIO (NICKNAME, NOMBRE, APELLIDO, CORREO, CONTRASEÑA, SEXO) VALUES ('MartinXD','Martin', 'Galan','martin@gmail.com','34f74c049edea51851c6924f4a386762','H');
INSERT INTO final_USUARIO (NICKNAME, NOMBRE, APELLIDO, CORREO, CONTRASEÑA, SEXO) VALUES ('carlos91','Carlos', 'Garcia del Bosque','carlos@gmail.com','9ad48828b0955513f7cf0f7f6510c8f8','PND');



INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('¿Cómo comenzar en la calistenia?','En la calistenia, como en cualquier otro deporte, se tarda mucho tiempo mejorar. Pero eso no es lo importante. Lo importante es la constancia y el querer ser siempre mejor que ayer, y sobretodo, disfrutar del camino. Por último, si alguien no sabe como empezar en esta modalidad, pueden descargarse gratis mi aplicación móvil: CalisteniaApp.','Yerai Street Workout');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('','','Buff Academy');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('','','PowerExplosive');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('','','CrisFreeStyle Workout');


INSERT INTO final_TEMA (nickname, nombre, contenido)VALUES ("laura123", "Primera dominada","Tengo un problema con las dominadas. Llevo entrenando 3 meses ya y aunque haya mejorado mucho, no consigo hacer una dominada. ¿Cómo puedo mejorar mi fuerza en los ejercicios de jalón?");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("MartinXD", 1, "Solo necesitas seguir entrenanando. Y en un tiempo la lograrás.");
INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (1, 1, "Efectivamente. Sigue entrenando y la conseguirás.", 'Esther_99');
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("carlos91", 1, "Prueba hacer un par de veces a la semana una rutina especifica para ganar fuerza en este tipo de ejercicios y ya verás como en nada la lograrás.");
INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (2, 1, "Muchas gracias, lo haré.", 'laura123');

INSERT INTO final_TEMA (nickname, nombre, contenido)VALUES ("MartinXD", "Tips para full planche","Buenos días, he creado este hilo para hablar aquí sobre todos los trucos y consejos para lograr cuando antes la full planche.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("MartinXD", 2, "Lo primero, decir que lo más importante para sacar la full planche es tener paciencia. Este es uno de los movimientos más difíciles de la calistenia y requiere mucho esfuerzo. Y por segundo, en mi experiencia personal, lo que mejor me ha funcionado es realizar dos rutinas semanales específicas para sacar la full. Con esto yo creo que se consigue mucha fuerza en los hombros.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("carlos91", 2, "Yo la saqué hace un año ya. Y lo que me ayudo a lograrla fue tener dominadas las flexiones a pino. Me parece un ejercicio fundamental.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("laura123", 2, "Yo estoy a punto de tenela. Yo la trabajo en rutinas especificas 3 veces a la semana. Y el ejercicio que más me gusta es hacer el pino y bajar (hacer la negativa) hasta llegar a laposiciónde full planche. Si no puedes marcarla, tan solo dejate caer (lo mas lento posible) y esto sería una repetición. Empieza haciendo unas pocas, y verás mejoras bastante ráìdo.");
INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (5, 2, "Guauuuu, gran ejercicio, lo voy a implementar en mi rutina ya.", 'carlos91');
INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (5, 2, "Gran ejercicio.", 'MartinXD');

INSERT INTO final_TEMA (nickname, nombre, contenido)VALUES ("carlos91", "Utilizar magnesio","Es tan importante el magnesio? ¿Dónde podría comprarlo?");


INSERT INTO final_likes_tema VALUES (1, "laura123");
INSERT INTO final_likes_tema VALUES (1, "Esther_99");
INSERT INTO final_likes_tema VALUES (1, "MartinXD");
INSERT INTO final_likes_tema VALUES (2, "MartinXD");


INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Rutina espalda-biceps',3,'danidbg',180, "Principiante");
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,6);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,8);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,11);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,7);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Básicos pecho',1,'danidbg',240, "Intermedio");
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,26);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,29);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,32);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,27);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,34);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,33);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Abdominales de acero',4,'danidbg',90, "Intermedio");
INSERT INTO final_EJERCICIO_RUTINA VALUES (3,1);
INSERT INTO final_EJERCICIO_RUTINA VALUES (3,2);
INSERT INTO final_EJERCICIO_RUTINA VALUES (3,3);
INSERT INTO final_EJERCICIO_RUTINA VALUES (3,4);
INSERT INTO final_EJERCICIO_RUTINA VALUES (3,5);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Hombros fuertes',5,'danidbg',120, "Avanzado");
INSERT INTO final_EJERCICIO_RUTINA VALUES (4,17);
INSERT INTO final_EJERCICIO_RUTINA VALUES (4,22);
INSERT INTO final_EJERCICIO_RUTINA VALUES (4,23);
INSERT INTO final_EJERCICIO_RUTINA VALUES (4,19);
INSERT INTO final_EJERCICIO_RUTINA VALUES (4,25);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Básico piernas',2,'danidbg',180, "Principiante");
INSERT INTO final_EJERCICIO_RUTINA VALUES (5,42);
INSERT INTO final_EJERCICIO_RUTINA VALUES (5,43);
INSERT INTO final_EJERCICIO_RUTINA VALUES (5,39);
INSERT INTO final_EJERCICIO_RUTINA VALUES (5,41);
INSERT INTO final_EJERCICIO_RUTINA VALUES (5,40);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Abdominales faciles',4,'danidbg',120, "Principiante");
INSERT INTO final_EJERCICIO_RUTINA VALUES (6,2);
INSERT INTO final_EJERCICIO_RUTINA VALUES (6,3);
INSERT INTO final_EJERCICIO_RUTINA VALUES (6,4);
INSERT INTO final_EJERCICIO_RUTINA VALUES (6,5);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Rutina bandera',3,'danidbg',180, "Avanzado");
INSERT INTO final_EJERCICIO_RUTINA VALUES (7,11);
INSERT INTO final_EJERCICIO_RUTINA VALUES (7,12);
INSERT INTO final_EJERCICIO_RUTINA VALUES (7,16);
INSERT INTO final_EJERCICIO_RUTINA VALUES (7,14);
INSERT INTO final_EJERCICIO_RUTINA VALUES (7,15);


INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Piernas fuertes',2,'danidbg',90, "Avanzado");
INSERT INTO final_EJERCICIO_RUTINA VALUES (8,42);
INSERT INTO final_EJERCICIO_RUTINA VALUES (8,44);
INSERT INTO final_EJERCICIO_RUTINA VALUES (8,47);
INSERT INTO final_EJERCICIO_RUTINA VALUES (8,48);
INSERT INTO final_EJERCICIO_RUTINA VALUES (8,49);
INSERT INTO final_EJERCICIO_RUTINA VALUES (8,50);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('Pecho-triceps intermedio',1,'danidbg',90, "Intermedio");
INSERT INTO final_EJERCICIO_RUTINA VALUES (9,26);
INSERT INTO final_EJERCICIO_RUTINA VALUES (9,31);
INSERT INTO final_EJERCICIO_RUTINA VALUES (9,35);
INSERT INTO final_EJERCICIO_RUTINA VALUES (9,33);
INSERT INTO final_EJERCICIO_RUTINA VALUES (9,36);



















