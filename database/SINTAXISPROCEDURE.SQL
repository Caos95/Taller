DELIMITER $$
CREATE PROCEDURE SP_LISTAR_USUARIO()
BEGIN
	SELECT
        u.id_usuario,
        u.nombre_usuario,
        u.sexo,
        u.activo,
        u.id_rol,
        r.nombre_rol AS rol_nombre
FROM
usuario AS u
INNER JOIN
rol AS r ON u.id_rol = r.id_rol;
END $$
DELIMITER ;
