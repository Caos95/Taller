-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2025 a las 00:52:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taller`
--
CREATE DATABASE IF NOT EXISTS `taller` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `taller`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `listarroles` ()   BEGIN
SELECT 
id_rol,
nombre_rol
FROM 
rol
WHERE
nombre_rol != 'Administrador';
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ADMINISTRADOR` ()   begin
    SELECT
        u.id_usuario,
        au.id_administrador,
        u.nombre_usuario,
        r.nombre_rol AS rol_nombre,
        au.nombre_administrador,
        au.rut_administrador,
        au.email_administrador AS email,
        u.sexo,
        u.activo
    FROM
        administrador_usuario AS au
    INNER JOIN
        usuario AS u ON au.id_usuario = u.id_usuario
    INNER JOIN
        rol AS r ON u.id_rol = r.id_rol;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CLIENTE` ()   begin
select * from cliente;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ADMINISTRADOR` ()   BEGIN
    SELECT id_rol, nombre_rol
    FROM rol
    WHERE nombre_rol = 'Administrador';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DUENO` ()   begin

select * from dueno_taller;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HISTORIAL` ()   BEGIN
select * from historial_vehiculo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HISTORIAL_POR_CLIENTE` (IN `p_id_cliente` INT)   BEGIN
    SELECT * FROM historial_vehiculo
    WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_MECANICO` ()   begin
	Select
    u.id_usuario,
    m.rut_mecanico,
    m.nombre_mecanico,
    m.especialidad_mecanico,
    m.telefono_mecanico,
    m.email_mecanico,
    u.nombre_usuario,
    u.activo,
    u.sexo,
    t.nombre_taller
from 
mecanico as m
inner join 
usuario as u on m.id_usuario = u.id_usuario
inner join
taller as t on m.id_taller = t.id_taller;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_MECANICO_POR_TALLER` (IN `p_id_taller` INT)   BEGIN
    SELECT * FROM mecanico
    WHERE id_taller = p_id_taller;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ROL` ()   select * from rol$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_SERVICIO` ()   BEGIN
select * from servicio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_SERVICIO_POR_CLIENTE` (IN `p_id_cliente` INT)   BEGIN
    -- Muestra todos los servicios de un cliente, sin importar el taller
    SELECT 
        s.*, 
        t.nombre_taller, 
        m.nombre_mecanico
    FROM servicio s
    JOIN vehiculo v ON s.id_vehiculo = v.id_vehiculo
    LEFT JOIN taller t ON s.id_taller = t.id_taller
    LEFT JOIN mecanico m ON s.id_mecanico = m.id_mecanico
    WHERE v.id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_SERVICIO_POR_MECANICO` (IN `p_id_mecanico` INT)   BEGIN
    -- Muestra solo los servicios asignados a ESE mecánico
    SELECT 
        s.*, 
        v.marca_vehiculo, v.modelo_vehiculo, 
        c.nombre_cliente
    FROM servicio s
    JOIN vehiculo v ON s.id_vehiculo = v.id_vehiculo
    JOIN cliente c ON v.id_cliente = c.id_cliente
    WHERE s.id_mecanico = p_id_mecanico;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_SERVICIO_POR_TALLER` (IN `p_id_taller` INT)   BEGIN
    -- Muestra servicios de ESE taller, con datos del cliente y vehículo
    SELECT 
        s.*, 
        v.marca_vehiculo, v.modelo_vehiculo, 
        c.nombre_cliente,
        m.nombre_mecanico
    FROM servicio s
    JOIN vehiculo v ON s.id_vehiculo = v.id_vehiculo
    JOIN cliente c ON v.id_cliente = c.id_cliente
    JOIN mecanico m ON s.id_mecanico = m.id_mecanico
    WHERE s.id_taller = p_id_taller;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TALLER` ()   begin
select * from taller;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_USUARIO` ()   BEGIN
    SELECT
        u.id_usuario,
        u.nombre_usuario,
        COALESCE(c.nombre_cliente, m.nombre_mecanico, d.nombre_dueno_taller) AS nombre_completo,
        COALESCE(c.rut_cliente, m.rut_mecanico, d.rut_dueno_taller) AS rut,
        u.sexo,
        u.activo,
        u.id_rol,
        r.nombre_rol AS rol_nombre
    FROM
        usuario AS u
    INNER JOIN
        rol AS r ON u.id_rol = r.id_rol
    LEFT JOIN
        cliente AS c ON u.id_usuario = c.id_usuario
    LEFT JOIN
        mecanico AS m ON u.id_usuario = m.id_usuario
    LEFT JOIN
        dueno_taller AS d ON u.id_usuario = d.id_usuario
    WHERE
        r.nombre_rol <> 'Administrador';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_VEHICULO` ()   SELECT * FROM vehiculo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_VEHICULO_POR_CLIENTE` (IN `p_id_cliente` INT)   BEGIN
    SELECT * FROM vehiculo
    WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFCAR_MECANICO` (IN `p_rut` VARCHAR(50), IN `p_nombre_mecanico` VARCHAR(100), IN `p_especialidad_mecanico` VARCHAR(100), IN `p_telefono_mecanico` VARCHAR(20), IN `p_email_mecanico` VARCHAR(100))   begin
update mecanico
set
nombre_mecanico=p_nombre_mecanico,
especialidad_mecanico=p_especialidad_mecanico,
telefono_mecanico=p_telefono_mecanico,
email_mecanico=p_email_mecanico
where rut_mecanico = p_rut;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ADMINISTRADOR` (IN `p_rut` VARCHAR(20), IN `p_nombre` VARCHAR(100), IN `p_email` VARCHAR(100))   begin
update administrador_usuario
set
nombre_administrador = p_nombre,
email_administrador = p_email
where rut_administrador = p_rut;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CLIENTE` (IN `p_rut_cliente` VARCHAR(20), IN `p_nuevo_nombre` VARCHAR(100), IN `p_nueva_direccion` VARCHAR(200), IN `p_nuevo_telefono` VARCHAR(20), IN `p_nuevo_email` VARCHAR(100))   BEGIN
update cliente
set
nombre_cliente=p_nuevo_nombre,
direccion_cliente=p_nueva_direccion,
telefono_cliente=p_nuevo_telefono,
email_cliente=p_nuevo_email
where rut_cliente=p_rut_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_COLOR` (IN `p_patente` VARCHAR(12), IN `p_color_nuevo` VARCHAR(50))   BEGIN
    -- Actualizar el color del vehículo con la patente especificada
    UPDATE vehiculo
    SET color_vehiculo = p_color_nuevo
    WHERE patente_vehiculo = p_patente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_DUENO` (IN `p_rut` VARCHAR(20), IN `p_nombre` VARCHAR(100), IN `p_telefono` VARCHAR(20), IN `p_email` VARCHAR(100))   begin
update dueno_taller
set
nombre_dueno_taller = p_nombre,
telefono_dueno_taller = p_telefono,
email_dueno_taller =p_email
where rut_dueno_taller = p_rut; 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO` (IN `p_id_usuario` INT, IN `p_estado` TINYINT)   BEGIN
update usuario
set activo=p_estado
where id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_HISTORIAL` (IN `p_id_historial` INT, IN `p_fecha_cambio` DATE, IN `p_tipo_evento` VARCHAR(50), IN `p_observaciones` TEXT)   BEGIN
update historial_vehiculo
set
fecha_cambio = p_fecha_cambio,
tipo_evento = p_tipo_evento,
observaciones = p_observaciones
where id_historial = p_id_historial;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ROL` (IN `p_nombre_rol_actual` VARCHAR(50), IN `p_nombre_rol_nuevo` VARCHAR(50))   BEGIN
UPDATE rol
set nombre_rol = p_nombre_rol_nuevo
where nombre_rol = p_nombre_rol_actual;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_SERVICIO` (IN `p_id_servicio` INT, IN `p_descripcion` TEXT, IN `p_costo` INT)   BEGIN
update servicio
set
descripcion_servicio = p_descripcion,
costo_servicio = p_costo
where id_servicio = p_id_servicio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_TALLER` (IN `p_id_taller` INT, IN `p_nombre` VARCHAR(100), IN `p_direccion` VARCHAR(200), IN `p_telefono` VARCHAR(20), IN `p_email` VARCHAR(100))   begin
update taller
set
nombre_taller = p_nombre,
direccion_taller = p_direccion,
telefono_taller = p_telefono,
email_taller = p_email
where id_taller = p_id_taller; 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_OBTENER_CONTEXTO_USUARIO` (IN `p_id_usuario` INT, IN `p_nombre_rol` VARCHAR(50))   BEGIN
    IF p_nombre_rol = 'cliente' THEN
        -- Devuelve el id_cliente
        SELECT id_cliente AS id_contexto, NULL AS id_taller 
        FROM cliente WHERE id_usuario = p_id_usuario;
        
    ELSEIF p_nombre_rol = 'dueño' THEN
        -- Devuelve el id_dueno_taller. Tu backend deberá buscar los talleres con este ID.
        SELECT id_dueno_taller AS id_contexto, NULL AS id_taller 
        FROM dueno_taller WHERE id_usuario = p_id_usuario;
        
    ELSEIF p_nombre_rol = 'mecanico' THEN
        -- Devuelve el id_mecanico Y el id_taller al que pertenece
        SELECT id_mecanico AS id_contexto, id_taller 
        FROM mecanico WHERE id_usuario = p_id_usuario;
        
    ELSE
        -- Admin u otro rol no tienen contexto específico
        SELECT NULL AS id_contexto, NULL AS id_taller;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_OBTENER_NOMBRE_POR_ROL` (IN `p_id_usuario` INT)   BEGIN
    SELECT
        u.id_usuario,
        u.nombre_usuario,
        r.nombre_rol,
        CASE r.nombre_rol
            WHEN 'cliente' THEN c.nombre_cliente
            WHEN 'mecanico' THEN m.nombre_mecanico
            WHEN 'ADMINISTRADOR' THEN a.nombre_administrador
            WHEN 'dueño' THEN d.nombre_dueno_taller
            ELSE NULL
        END AS nombre_completo
    FROM
        usuario u
    JOIN
        rol r ON u.id_rol = r.id_rol
    LEFT JOIN
        cliente c ON u.id_usuario = c.id_usuario
    LEFT JOIN
        mecanico m ON u.id_usuario = m.id_usuario
    LEFT JOIN
        administrador_usuario a ON u.id_usuario = a.id_usuario
    LEFT JOIN
        dueno_taller d ON u.id_usuario = d.id_usuario
    WHERE
        u.id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RECUPERAR_CONTRASENA` (IN `p_id_usuario` INT, IN `p_nueva_contrasena` VARCHAR(255))   begin
    update usuario
    set clave = p_nueva_contrasena
    WHERE id_usuario = p_id_usuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ADMINISTRADOR` (IN `p_rut` VARCHAR(20), IN `p_nombre` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_id_usuario` INT)   begin
insert into administrador_usuario
(
  rut_administrador,
    nombre_administrador,
    email_administrador,
    id_usuario
)
values(
  p_rut,
    p_nombre,
    p_email,
    p_id_usuario
);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_CLIENTE` (IN `p_rut_cliente` VARCHAR(20), IN `p_nombre_cliente` VARCHAR(100), IN `p_direccion_cliente` VARCHAR(200), IN `p_telefono_cliente` VARCHAR(20), IN `p_email_cliente` VARCHAR(100), IN `p_id_usuario` INT)   BEGIN
    INSERT INTO cliente (
        rut_cliente,
        nombre_cliente,
        direccion_cliente,
        telefono_cliente,
        email_cliente, 
        id_usuario    
    )
    VALUES (
        p_rut_cliente,
        p_nombre_cliente,
        p_direccion_cliente,
        p_telefono_cliente, 
        p_email_cliente,   
        p_id_usuario      
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_DUENO` (IN `p_rut` VARCHAR(20), IN `p_nombre` VARCHAR(100), IN `p_telefono` VARCHAR(20), IN `p_email` VARCHAR(100), IN `p_id_usuario` INT)   begin
insert into dueno_taller(
rut_dueno_taller,
nombre_dueno_taller,
telefono_dueno_taller,
email_dueno_taller,
id_usuario
) values(
p_rut,
p_nombre,
p_telefono,
p_email,
p_id_usuario);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_HISTORIAL` (IN `p_id_vehiculo` INT, IN `p_id_cliente` INT, IN `p_fecha_cambio` DATE, IN `p_tipo_evento` VARCHAR(50), IN `p_observaciones` TEXT)   BEGIN
insert into historial_vehiculo
(
id_vehiculo,
id_cliente,
fecha_cambio,
tipo_evento,
observaciones
)
values
(
p_id_vehiculo,
p_id_cliente,
p_fecha_cambio,
p_tipo_evento,
p_observaciones
);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_MECANICO` (IN `p_rut_mecanico` VARCHAR(20), IN `p_nombre_mecanico` VARCHAR(100), IN `p_especialidad_mecanico` VARCHAR(20), IN `p_telefono_mecanico` VARCHAR(20), IN `p_email_mecanico` VARCHAR(100), IN `p_id_usuario` INT, IN `p_id_taller` INT)   BEGIN
insert into  mecanico(
rut_mecanico,
nombre_mecanico,
especialidad_mecanico,
telefono_mecanico,
email_mecanico,
id_usuario,
id_taller)
values(
p_rut_mecanico,
p_nombre_mecanico,
p_especialidad_mecanico,
p_telefono_mecanico,
p_email_mecanico,
p_id_usuario,
p_id_taller);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_MECANICO_COMPLETO` (IN `p_usuario` VARCHAR(255), IN `p_contra` VARCHAR(255), IN `p_sexo` CHAR(1), IN `p_id_rol` INT, IN `p_rut_mecanico` VARCHAR(20), IN `p_nombre_mecanico` VARCHAR(100), IN `p_especialidad_mecanico` VARCHAR(20), IN `p_telefono_mecanico` VARCHAR(20), IN `p_email_mecanico` VARCHAR(100), IN `p_id_taller` INT)   BEGIN
    -- Declarar variables para el ID del nuevo usuario y para manejo de errores
    DECLARE id_nuevo_usuario INT;
    DECLARE resultado_out INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Si ocurre un error, revierte la transacción
        ROLLBACK;
        -- Si es un error de duplicado (usuario o rut), devuelve 2.
        IF (SELECT 1 FROM `information_schema`.`STATISTICS` WHERE `TABLE_SCHEMA` = DATABASE() AND `TABLE_NAME` = 'usuario' AND `INDEX_NAME` = 'nombre_usuario' AND (SELECT 1 FROM `usuario` WHERE `nombre_usuario` = p_usuario)) THEN
            SET resultado_out = 2;
        ELSEIF (SELECT 1 FROM `information_schema`.`STATISTICS` WHERE `TABLE_SCHEMA` = DATABASE() AND `TABLE_NAME` = 'mecanico' AND `INDEX_NAME` = 'rut_mecanico' AND (SELECT 1 FROM `mecanico` WHERE `rut_mecanico` = p_rut_mecanico)) THEN
            SET resultado_out = 2;
        ELSE
            SET resultado_out = 0;
        END IF;
        SELECT resultado_out AS 'resultado';
    END;

    -- Iniciar transacción
    START TRANSACTION;

    -- 1. Registrar el usuario y obtener su ID
    CALL SP_REGISTRAR_USUARIO(p_usuario, p_contra, p_id_rol, p_sexo, 1, @id_nuevo_usuario);
    SET id_nuevo_usuario = @id_nuevo_usuario;

    -- 2. Registrar los datos del mecánico con el ID del nuevo usuario
    CALL SP_REGISTRAR_MECANICO(
        p_rut_mecanico,
        p_nombre_mecanico,
        p_especialidad_mecanico,
        p_telefono_mecanico,
        p_email_mecanico,
        id_nuevo_usuario,
        p_id_taller
    );
    
    -- Si todo fue bien, confirma la transacción
    COMMIT;
    -- Devuelve 1 para indicar éxito
    SET resultado_out = 1;
    SELECT resultado_out AS 'resultado';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ROL` (IN `N_ROL` VARCHAR(50))   BEGIN
INSERT INTO ROL (nombre_rol)
VALUES (N_ROL);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_SERVICIO` (IN `p_id_vehiculo` INT, IN `p_id_taller` INT, IN `p_id_mecanico` INT, IN `p_fecha_servicio` DATE, IN `p_descripcion` TEXT, IN `p_costo_servicio` INT)   begin
insert into servicio(id_vehiculo,
id_taller, 
id_mecanico,
fecha_servicio,
descripcion_servicio,
costo_servicio)
values
(
p_id_vehiculo,
p_id_taller,
p_id_mecanico,
p_fecha_servicio,
p_descripcion,
p_costo_servicio
);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TALLER` (IN `p_nombre` VARCHAR(100), IN `p_direccion` VARCHAR(200), IN `p_telefono` VARCHAR(20), IN `p_email` VARCHAR(100), IN `p_id_dueno` INT)   begin
insert into taller(
nombre_taller,
direccion_taller,
telefono_taller,
email_taller,
id_dueno_taller
)
values
(
p_nombre,
p_direccion,
p_telefono,
p_email,
p_id_dueno
);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_USUARIO` (IN `p_nombre_usuario` VARCHAR(50), IN `p_clave_usuario` VARCHAR(255), IN `p_id_rol` INT, IN `p_sexo` CHAR(1), IN `p_activo_usuario` TINYINT, OUT `id_nuevo_usuario` INT)   BEGIN
    INSERT INTO usuario(nombre_usuario, clave, id_rol, sexo, activo) 
    VALUES(p_nombre_usuario, p_clave_usuario, p_id_rol, p_sexo, p_activo_usuario);
    
    -- Devolvemos el ID del usuario recién insertado
    SET id_nuevo_usuario = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_VEHICULO` (IN `vin_vehiculo` VARCHAR(50), IN `marca_vehiculo` VARCHAR(50), IN `modelo_vehiculo` VARCHAR(50), IN `anio_vehiculo` INT, IN `color_vehiculo` VARCHAR(50), IN `id_cliente` INT)   BEGIN
  INSERT INTO vehiculo(vin_vehiculo,marca_vehiculo,modelo_vehiculo,anio_vehiculo,color_vehiculo,id_cliente) VALUES(vin_vehiculo,marca_vehiculo,modelo_vehiculo,anio_vehiculo,color_vehiculo,id_cliente);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VERIFICAR_USUARIO` (IN `p_nombre_usuario` VARCHAR(50))   BEGIN
    SELECT
        u.id_usuario,
        u.nombre_usuario,
        u.clave,
        u.id_rol,
        u.activo,
        r.nombre_rol,
        u.sexo 
    FROM usuario u
    INNER JOIN rol r ON u.id_rol = r.id_rol
    WHERE u.nombre_usuario = p_nombre_usuario;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador_usuario`
--

CREATE TABLE `administrador_usuario` (
  `id_administrador` int(11) NOT NULL,
  `rut_administrador` varchar(20) NOT NULL,
  `nombre_administrador` varchar(100) NOT NULL,
  `email_administrador` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador_usuario`
--

INSERT INTO `administrador_usuario` (`id_administrador`, `rut_administrador`, `nombre_administrador`, `email_administrador`, `id_usuario`) VALUES
(1, '18978569-0', 'Ariel Cartes', 'drsnake1995@gmail.com', 1),
(11, '14158985-0', 'Zacarias pinto', 'z.pinto@gmail.com', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `rut_cliente` varchar(20) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `direccion_cliente` varchar(200) DEFAULT NULL,
  `telefono_cliente` varchar(20) DEFAULT NULL,
  `email_cliente` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `rut_cliente`, `nombre_cliente`, `direccion_cliente`, `telefono_cliente`, `email_cliente`, `id_usuario`) VALUES
(1, '15656589-0', 'Enrique', 'AV. Siempre viva 14', '988566545', 'esepulveda@gmail.com', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueno_taller`
--

CREATE TABLE `dueno_taller` (
  `id_dueno_taller` int(11) NOT NULL,
  `rut_dueno_taller` varchar(20) NOT NULL,
  `nombre_dueno_taller` varchar(100) NOT NULL,
  `telefono_dueno_taller` varchar(20) DEFAULT NULL,
  `email_dueno_taller` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dueno_taller`
--

INSERT INTO `dueno_taller` (`id_dueno_taller`, `rut_dueno_taller`, `nombre_dueno_taller`, `telefono_dueno_taller`, `email_dueno_taller`, `id_usuario`) VALUES
(1, '14562369-5', 'Carmen Careaga', '965845625', 'c.careaga@gmail.com', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_vehiculo`
--

CREATE TABLE `historial_vehiculo` (
  `id_historial` int(11) NOT NULL,
  `id_vehiculo` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha_cambio` date NOT NULL,
  `tipo_evento` varchar(50) NOT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mecanico`
--

CREATE TABLE `mecanico` (
  `id_mecanico` int(11) NOT NULL,
  `rut_mecanico` varchar(20) NOT NULL,
  `nombre_mecanico` varchar(100) NOT NULL,
  `especialidad_mecanico` varchar(100) DEFAULT NULL,
  `telefono_mecanico` varchar(20) DEFAULT NULL,
  `email_mecanico` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_taller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mecanico`
--

INSERT INTO `mecanico` (`id_mecanico`, `rut_mecanico`, `nombre_mecanico`, `especialidad_mecanico`, `telefono_mecanico`, `email_mecanico`, `id_usuario`, `id_taller`) VALUES
(1, '14563259-5', 'Pedro', 'Automotriz', '965656565', 'asd@asd.cl', 2, 1),
(2, '123256325-4', 'Ariel Sanhueza', 'Electromecanico', '963656263', 'asanhueza@gmail.com', 16, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'cliente'),
(3, 'dueño'),
(4, 'mecanico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `id_vehiculo` int(11) DEFAULT NULL,
  `id_taller` int(11) DEFAULT NULL,
  `id_mecanico` int(11) DEFAULT NULL,
  `fecha_servicio` date NOT NULL,
  `descripcion_servicio` text NOT NULL,
  `costo_servicio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

CREATE TABLE `taller` (
  `id_taller` int(11) NOT NULL,
  `nombre_taller` varchar(100) NOT NULL,
  `direccion_taller` varchar(200) DEFAULT NULL,
  `telefono_taller` varchar(20) DEFAULT NULL,
  `email_taller` varchar(100) DEFAULT NULL,
  `id_dueno_taller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `taller`
--

INSERT INTO `taller` (`id_taller`, `nombre_taller`, `direccion_taller`, `telefono_taller`, `email_taller`, `id_dueno_taller`) VALUES
(1, 'SerCart', 'Las cinias 49', '964562585', 'sercart@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `sexo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `clave`, `id_rol`, `activo`, `sexo`) VALUES
(1, 'admin', '$2y$10$RWNK5OBmX1iXpCpvYODHVeaAQHU/KHkL4TCl5n9s9mkNmEr2SlHWK', 1, 1, 'M'),
(2, 'pcereceda', '$2y$10$PWZzNFQHLESVDpDgKg5Bo.K3vnS86RIJthfFoTfgjoBx0GbdfoP7K', 4, 1, 'M'),
(4, 'e.sepulveda', '$10$RWNK5OBmX1iXpCpvYODHVeaAQHU/KHkL4TCl5n9s9mkNmEr2SlHWK', 2, 1, 'M'),
(14, 'zpinto', '$2y$10$PWZzNFQHLESVDpDgKg5Bo.K3vnS86RIJthfFoTfgjoBx0GbdfoP7K', 1, 1, 'M'),
(15, 'c.careaga', '$2y$10$PWZzNFQHLESVDpDgKg5Bo.K3vnS86RIJthfFoTfgjoBx0GbdfoP7K', 3, 1, 'M'),
(16, 'asanhueza', '$2y$10$kawQAabMjOUe94CiKJEpuOMhGQ2/6OcWfe3gH2uN/SCRcjFj084EO', 4, 0, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `vin_vehiculo` varchar(50) NOT NULL,
  `marca_vehiculo` varchar(50) DEFAULT NULL,
  `modelo_vehiculo` varchar(50) DEFAULT NULL,
  `anio_vehiculo` int(11) DEFAULT NULL,
  `color_vehiculo` varchar(50) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador_usuario`
--
ALTER TABLE `administrador_usuario`
  ADD PRIMARY KEY (`id_administrador`),
  ADD UNIQUE KEY `rut_administrador` (`rut_administrador`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `rut_cliente` (`rut_cliente`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `dueno_taller`
--
ALTER TABLE `dueno_taller`
  ADD PRIMARY KEY (`id_dueno_taller`),
  ADD UNIQUE KEY `rut_dueno_taller` (`rut_dueno_taller`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `historial_vehiculo`
--
ALTER TABLE `historial_vehiculo`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_vehiculo` (`id_vehiculo`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `mecanico`
--
ALTER TABLE `mecanico`
  ADD PRIMARY KEY (`id_mecanico`),
  ADD UNIQUE KEY `rut_mecanico` (`rut_mecanico`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `fk_mecanico_taller` (`id_taller`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_vehiculo` (`id_vehiculo`),
  ADD KEY `id_taller` (`id_taller`),
  ADD KEY `id_mecanico` (`id_mecanico`);

--
-- Indices de la tabla `taller`
--
ALTER TABLE `taller`
  ADD PRIMARY KEY (`id_taller`),
  ADD KEY `id_dueno_taller` (`id_dueno_taller`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD UNIQUE KEY `vin_vehiculo` (`vin_vehiculo`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador_usuario`
--
ALTER TABLE `administrador_usuario`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dueno_taller`
--
ALTER TABLE `dueno_taller`
  MODIFY `id_dueno_taller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historial_vehiculo`
--
ALTER TABLE `historial_vehiculo`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mecanico`
--
ALTER TABLE `mecanico`
  MODIFY `id_mecanico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `taller`
--
ALTER TABLE `taller`
  MODIFY `id_taller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador_usuario`
--
ALTER TABLE `administrador_usuario`
  ADD CONSTRAINT `administrador_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `dueno_taller`
--
ALTER TABLE `dueno_taller`
  ADD CONSTRAINT `dueno_taller_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `historial_vehiculo`
--
ALTER TABLE `historial_vehiculo`
  ADD CONSTRAINT `historial_vehiculo_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`),
  ADD CONSTRAINT `historial_vehiculo_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Filtros para la tabla `mecanico`
--
ALTER TABLE `mecanico`
  ADD CONSTRAINT `fk_mecanico_taller` FOREIGN KEY (`id_taller`) REFERENCES `taller` (`id_taller`),
  ADD CONSTRAINT `mecanico_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`),
  ADD CONSTRAINT `servicio_ibfk_2` FOREIGN KEY (`id_taller`) REFERENCES `taller` (`id_taller`),
  ADD CONSTRAINT `servicio_ibfk_3` FOREIGN KEY (`id_mecanico`) REFERENCES `mecanico` (`id_mecanico`);

--
-- Filtros para la tabla `taller`
--
ALTER TABLE `taller`
  ADD CONSTRAINT `taller_ibfk_1` FOREIGN KEY (`id_dueno_taller`) REFERENCES `dueno_taller` (`id_dueno_taller`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
