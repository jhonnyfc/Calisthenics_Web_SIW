SELECT 'DROP '||OBJECT_TYPE||' '||object_name|| CASE OBJECT_TYPE WHEN 'TABLE' THEN ' CASCADE CONSTRAINTS;' ELSE ';' END "Copiar, pegar y ejecutar" 
FROM USER_OBJECTS
WHERE OBJECT_TYPE NOT IN ('INDEX','TRIGGER');--para borar todos los objetos: Copiar el resultado, pegarlo y ejecutarlo



SELECT * FROM USER_OBJECTS;--Para comprobar

DROP TABLE EJERCICIO CASCADE CONSTRAINTS;
DROP TABLE EJERCICIO_RUTINA CASCADE CONSTRAINTS;
DROP TABLE GRUPO CASCADE CONSTRAINTS;
DROP TABLE MENSAJE CASCADE CONSTRAINTS;
DROP TABLE MUSCULO CASCADE CONSTRAINTS;
DROP TABLE MUSCULO_EJERCICIO CASCADE CONSTRAINTS;
DROP TABLE PUBLICACION CASCADE CONSTRAINTS;
DROP TABLE RUTINA CASCADE CONSTRAINTS;
DROP TABLE TEMA CASCADE CONSTRAINTS;
DROP TABLE USUARIO CASCADE CONSTRAINTS;
DROP TABLE VALORACION CASCADE CONSTRAINTS;