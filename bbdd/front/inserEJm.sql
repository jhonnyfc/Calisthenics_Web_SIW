INSERT INTO final_USUARIO (NICKNAME, NOMBRE, APELLIDO, CORREO, CONTRASEÑA, SEXO) VALUES ('danidbg','Dani', 'del Barrio','dani@gmail.com','dani123','M');

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('RUTINA2',2,'Dani2',180, "Intermedio");
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,4);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,5);
INSERT INTO final_EJERCICIO_RUTINA VALUES (1,6);

INSERT INTO final_RUTINA (NOMBRE_RUTINA, IDGRUPO, IDUSUARIO, INTERVALO_TIEMPO, NIVEL_RUTINA) VALUES ('RUTINA1',5,'DANI',200, "Principiante");

INSERT INTO final_EJERCICIO_RUTINA VALUES (2,1);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,2);
INSERT INTO final_EJERCICIO_RUTINA VALUES (2,3);

INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('Mi primera dominada','texto1','vadym1');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('MI PRIMER MUSCLE UP','texto2 ','vadym2');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('hola','texto3','vadym3');
INSERT INTO final_PUBLICACION (TITULO,CONTENIDO,AUTOR) VALUES ('adiosssss','texto4','vadym4');

INSERT INTO final_TEMA (nickname, nombre, contenido)VALUES ("danidbg", "primera dominada","no consigo hacer asfadg jdansj nsdkjgnsdjgnsdgjnksjdnsk." );
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 1, "Vete al gym la calistenia no sirve de nada.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 1, "ESPABILAESPABILAESPABILAESPABILAESPABILA.");



INSERT INTO final_TEMA (nickname, nombre, contenido)VALUES ("danidbg", "primera flexion", "PRIMEARA FLEAISONFASF MENSAJE TEMA.");
INSERT INTO final_mensaje (nickname, idtema, contenido) VALUES ("danidbg", 2, "no consigo hacer asfadg jdansj nsdkjgnsdjgnsdgjnksjdnsk.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 2, "Vete al gym la calistenia no sirve de nada.");
INSERT INTO final_mensaje  (nickname, idtema, contenido) VALUES ("danidbg", 2, "ESPABILAESPABILAESPABILAESPABILAESPABILA.");


INSERT INTO final_likes_tema VALUES (1, "danidbg");
INSERT INTO final_likes_tema VALUES (2, "danidbg");

INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (2, 1, "CONTENIDO DE PRUEBA SECUNDARIO", 'danidbg');
INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (2, 1, "Eres un parguelita, vadiy puto amo", 'danidbg');
INSERT INTO final_MENSAJES_SECUNDARIOS (IDMENSAJE, IDTEMA, CONTENIDO, NICKNAME) VALUES (3, 2, "la calistenia es de lo mejorcito k hay en el muindola calistenia es de lo mejorcito k hay en el muindola calistenia es de lo mejorcito k hay en el muindo", 'danidbg');
