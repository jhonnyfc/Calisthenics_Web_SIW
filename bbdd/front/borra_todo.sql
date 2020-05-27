SELECT 'DROP '||OBJECT_TYPE||' '||object_name|| CASE OBJECT_TYPE WHEN 'TABLE' THEN ' CASCADE CONSTRAINTS;' ELSE ';' END "Copiar, pegar y ejecutar" 
FROM USER_OBJECTS
WHERE OBJECT_TYPE NOT IN ('INDEX','TRIGGER');--para borar todos los objetos: Copiar el resultado, pegarlo y ejecutarlo



SELECT * FROM USER_OBJECTS;--Para comprobar



