/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100017
Source Host           : localhost:3306
Source Database       : ctc

Target Server Type    : MYSQL
Target Server Version : 100017
File Encoding         : 65001

Date: 2017-03-24 15:28:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for actividades_empresa
-- ----------------------------
DROP TABLE IF EXISTS `actividades_empresa`;
CREATE TABLE `actividades_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of actividades_empresa
-- ----------------------------
INSERT INTO `actividades_empresa` VALUES ('1', 'Comercio Exterior');
INSERT INTO `actividades_empresa` VALUES ('2', 'Agropecuaria');
INSERT INTO `actividades_empresa` VALUES ('3', 'Arquitectura');
INSERT INTO `actividades_empresa` VALUES ('4', 'Banca / Financiera');
INSERT INTO `actividades_empresa` VALUES ('5', 'Consultoría');
INSERT INTO `actividades_empresa` VALUES ('6', 'Consumo masivo');
INSERT INTO `actividades_empresa` VALUES ('7', 'Comercio');
INSERT INTO `actividades_empresa` VALUES ('8', 'Aérea');
INSERT INTO `actividades_empresa` VALUES ('9', 'Defensa');
INSERT INTO `actividades_empresa` VALUES ('10', 'Educación');
INSERT INTO `actividades_empresa` VALUES ('11', 'Energía');
INSERT INTO `actividades_empresa` VALUES ('12', 'Farmacéutica');
INSERT INTO `actividades_empresa` VALUES ('13', 'Gobierno');
INSERT INTO `actividades_empresa` VALUES ('14', 'Internet');
INSERT INTO `actividades_empresa` VALUES ('15', 'Jurídica');
INSERT INTO `actividades_empresa` VALUES ('16', 'Manufactura');
INSERT INTO `actividades_empresa` VALUES ('17', 'Publicidad / Marketing / RRPP');
INSERT INTO `actividades_empresa` VALUES ('18', 'Minería / Petróleo / Gas');
INSERT INTO `actividades_empresa` VALUES ('19', 'Medios');
INSERT INTO `actividades_empresa` VALUES ('20', 'ONGs');
INSERT INTO `actividades_empresa` VALUES ('21', 'Transporte');
INSERT INTO `actividades_empresa` VALUES ('22', 'Otra');
INSERT INTO `actividades_empresa` VALUES ('23', 'Servicios');
INSERT INTO `actividades_empresa` VALUES ('24', 'Entretenimiento');
INSERT INTO `actividades_empresa` VALUES ('25', 'Diseño');
INSERT INTO `actividades_empresa` VALUES ('26', 'Financiera');
INSERT INTO `actividades_empresa` VALUES ('27', 'Química');
INSERT INTO `actividades_empresa` VALUES ('28', 'Seguros');
INSERT INTO `actividades_empresa` VALUES ('29', 'Supermercado / Hipermercado');
INSERT INTO `actividades_empresa` VALUES ('30', 'Pesca');
INSERT INTO `actividades_empresa` VALUES ('31', 'Forestal');
INSERT INTO `actividades_empresa` VALUES ('32', 'Biotecnología');
INSERT INTO `actividades_empresa` VALUES ('33', 'Telecomunicaciones');
INSERT INTO `actividades_empresa` VALUES ('34', 'Informática / Tecnología');
INSERT INTO `actividades_empresa` VALUES ('35', 'Construcción');
INSERT INTO `actividades_empresa` VALUES ('36', 'Automotriz');
INSERT INTO `actividades_empresa` VALUES ('37', 'Salud');
INSERT INTO `actividades_empresa` VALUES ('38', 'Turismo');
INSERT INTO `actividades_empresa` VALUES ('39', 'Hotelería');
INSERT INTO `actividades_empresa` VALUES ('40', 'Imprenta');
INSERT INTO `actividades_empresa` VALUES ('41', 'Holding');
INSERT INTO `actividades_empresa` VALUES ('42', 'Inmobiliaria');
INSERT INTO `actividades_empresa` VALUES ('43', 'Siderurgia');
INSERT INTO `actividades_empresa` VALUES ('44', 'Textil');
INSERT INTO `actividades_empresa` VALUES ('45', 'Agro-Industrial');
INSERT INTO `actividades_empresa` VALUES ('46', 'Gastronomía');
INSERT INTO `actividades_empresa` VALUES ('47', 'Alimenticia');
INSERT INTO `actividades_empresa` VALUES ('48', 'Artesanal');
INSERT INTO `actividades_empresa` VALUES ('49', 'Información e Investigación');
INSERT INTO `actividades_empresa` VALUES ('50', 'Correo');
INSERT INTO `actividades_empresa` VALUES ('51', 'Editorial');
INSERT INTO `actividades_empresa` VALUES ('52', 'Ganadería');
INSERT INTO `actividades_empresa` VALUES ('53', 'AFJP');
INSERT INTO `actividades_empresa` VALUES ('54', 'Higiene y Perfumería');
INSERT INTO `actividades_empresa` VALUES ('55', 'Papelera');
INSERT INTO `actividades_empresa` VALUES ('56', 'Laboratorio');
INSERT INTO `actividades_empresa` VALUES ('57', 'Petroquímica');
INSERT INTO `actividades_empresa` VALUES ('58', 'Retail');
INSERT INTO `actividades_empresa` VALUES ('59', 'Transportadora');
INSERT INTO `actividades_empresa` VALUES ('60', 'Tabacalera');
INSERT INTO `actividades_empresa` VALUES ('61', 'Plásticos');

-- ----------------------------
-- Table structure for areas
-- ----------------------------
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) DEFAULT NULL,
  `amigable` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of areas
-- ----------------------------
INSERT INTO `areas` VALUES ('1', 'Administración, Contabilidad y Finanzas', 'administracion-contabilidad-y-finanzas');
INSERT INTO `areas` VALUES ('2', 'Aduana y Comercio Exterior', 'aduana-y-comercio-exterior');
INSERT INTO `areas` VALUES ('3', 'Abastecimiento y Logística', 'abastecimiento-y-logistica');
INSERT INTO `areas` VALUES ('4', 'Ingeniería Civil y Construcción', 'ingenieria-civil-y-construccion');
INSERT INTO `areas` VALUES ('5', 'Comercial, Ventas y Negocios', 'comercial-ventas-y-negocios');
INSERT INTO `areas` VALUES ('6', 'Educación, Docencia e Investigación', 'educacion-docencia-e-investigacion');
INSERT INTO `areas` VALUES ('7', 'Gastronomía y Turismo', 'gastronomia-y-turismo');
INSERT INTO `areas` VALUES ('8', 'Gerencia y Dirección General', 'gerencia-y-direccion-general');
INSERT INTO `areas` VALUES ('9', 'Legales', 'legales');
INSERT INTO `areas` VALUES ('10', 'Marketing y Publicidad', 'marketing-y-publicidad');
INSERT INTO `areas` VALUES ('11', 'Producción y Manufactura', 'produccion-y-manufactura');
INSERT INTO `areas` VALUES ('12', 'Recursos Humanos y Capacitación', 'recursos-humanos-y-capacitacion');
INSERT INTO `areas` VALUES ('13', 'Comunicación, Relaciones Institucionales y Públicas', 'comunicacion-relaciones-institucionales-y-publicas');
INSERT INTO `areas` VALUES ('14', 'Tecnología, Sistemas y Telecomunicaciones', 'tecnologia-sistemas-y-telecomunicaciones');
INSERT INTO `areas` VALUES ('15', 'Oficios y Otros', 'oficios-y-otros');
INSERT INTO `areas` VALUES ('16', 'Salud, Medicina y Farmacia', 'salud-medicina-y-farmacia');
INSERT INTO `areas` VALUES ('17', 'Atención al Cliente, Call Center y Telemarketing', 'atencion-al-cliente-call-center-y-telemarketing');
INSERT INTO `areas` VALUES ('18', 'Secretarias y Recepción', 'secretarias-y-recepcion');
INSERT INTO `areas` VALUES ('19', 'Seguros', 'seguros');
INSERT INTO `areas` VALUES ('20', 'Minería, Petróleo y Gas', 'mineria-petroleo-y-gas');
INSERT INTO `areas` VALUES ('21', 'Ingenierías', 'ingenierias');
INSERT INTO `areas` VALUES ('22', 'Diseño', 'diseno');

-- ----------------------------
-- Table structure for areas_estudio
-- ----------------------------
DROP TABLE IF EXISTS `areas_estudio`;
CREATE TABLE `areas_estudio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of areas_estudio
-- ----------------------------
INSERT INTO `areas_estudio` VALUES ('1', 'Organización Industrial');
INSERT INTO `areas_estudio` VALUES ('2', 'Abogacía / Derecho / Leyes');
INSERT INTO `areas_estudio` VALUES ('3', 'Geofísica');
INSERT INTO `areas_estudio` VALUES ('4', 'Adm. de Empresas');
INSERT INTO `areas_estudio` VALUES ('5', 'Ing. Comercial');
INSERT INTO `areas_estudio` VALUES ('6', 'Ing. Nuclear');
INSERT INTO `areas_estudio` VALUES ('7', 'Arquitectura');
INSERT INTO `areas_estudio` VALUES ('8', 'Seguros');
INSERT INTO `areas_estudio` VALUES ('9', 'Bellas Artes');
INSERT INTO `areas_estudio` VALUES ('10', 'Tecnología de Alimentos');
INSERT INTO `areas_estudio` VALUES ('11', 'Biología');
INSERT INTO `areas_estudio` VALUES ('12', 'Ciencias Políticas');
INSERT INTO `areas_estudio` VALUES ('13', 'Intérprete');
INSERT INTO `areas_estudio` VALUES ('14', 'Ciencias Físicas');
INSERT INTO `areas_estudio` VALUES ('15', 'Ciencias de la Educación');
INSERT INTO `areas_estudio` VALUES ('16', 'Computación / Informática');
INSERT INTO `areas_estudio` VALUES ('17', 'Apoderado Aduanal');
INSERT INTO `areas_estudio` VALUES ('18', 'Contabilidad / Auditoría');
INSERT INTO `areas_estudio` VALUES ('19', 'Asesoría Legal Internacional');
INSERT INTO `areas_estudio` VALUES ('20', 'Construcción / Obras Civiles');
INSERT INTO `areas_estudio` VALUES ('21', 'Asistente de Tráfico');
INSERT INTO `areas_estudio` VALUES ('22', 'Diseño Gráfico');
INSERT INTO `areas_estudio` VALUES ('23', 'Capacitación Comercio Exterior');
INSERT INTO `areas_estudio` VALUES ('24', 'Economía');
INSERT INTO `areas_estudio` VALUES ('25', 'Compras Internacionales/Importación');
INSERT INTO `areas_estudio` VALUES ('26', 'Enfermería');
INSERT INTO `areas_estudio` VALUES ('27', 'Consultorías Comercio Exterior');
INSERT INTO `areas_estudio` VALUES ('28', 'Finanzas Internacionales');
INSERT INTO `areas_estudio` VALUES ('29', 'Asesoría en Comercio Exterior Jubilado');
INSERT INTO `areas_estudio` VALUES ('30', 'Filosofía');
INSERT INTO `areas_estudio` VALUES ('31', 'Asesoría en Comercio Exterior');
INSERT INTO `areas_estudio` VALUES ('32', 'Fisioterapia');
INSERT INTO `areas_estudio` VALUES ('33', 'Mercadotecnia Internacional');
INSERT INTO `areas_estudio` VALUES ('34', 'Fotografía');
INSERT INTO `areas_estudio` VALUES ('35', 'Tecnologías de la Información');
INSERT INTO `areas_estudio` VALUES ('36', 'Ventas Internacionales/Exportación');
INSERT INTO `areas_estudio` VALUES ('37', 'Historia');
INSERT INTO `areas_estudio` VALUES ('38', 'Administración Agropecuaria');
INSERT INTO `areas_estudio` VALUES ('39', 'Geografía');
INSERT INTO `areas_estudio` VALUES ('40', 'Ing. Agropecuario');
INSERT INTO `areas_estudio` VALUES ('41', 'Hotelería');
INSERT INTO `areas_estudio` VALUES ('42', 'Call Center');
INSERT INTO `areas_estudio` VALUES ('43', 'Ing. Aerospacial');
INSERT INTO `areas_estudio` VALUES ('44', 'Ing. Industrial');
INSERT INTO `areas_estudio` VALUES ('45', 'Ing. Eléctrica');
INSERT INTO `areas_estudio` VALUES ('46', 'Ing. Electrónica');
INSERT INTO `areas_estudio` VALUES ('47', 'Ing. Hidraúlica');
INSERT INTO `areas_estudio` VALUES ('48', 'Ing. Informática');
INSERT INTO `areas_estudio` VALUES ('49', 'Ing. Naval');
INSERT INTO `areas_estudio` VALUES ('50', 'Ing. Obras Civiles/Construcción');
INSERT INTO `areas_estudio` VALUES ('51', 'Ing. Química');
INSERT INTO `areas_estudio` VALUES ('52', 'Ing. Sonido');
INSERT INTO `areas_estudio` VALUES ('53', 'Ing. Transporte');
INSERT INTO `areas_estudio` VALUES ('54', 'Medicina');
INSERT INTO `areas_estudio` VALUES ('55', 'Matemáticas');
INSERT INTO `areas_estudio` VALUES ('56', 'Música');
INSERT INTO `areas_estudio` VALUES ('57', 'Odontología');
INSERT INTO `areas_estudio` VALUES ('58', 'Periodismo');
INSERT INTO `areas_estudio` VALUES ('59', 'Comunicación Social');
INSERT INTO `areas_estudio` VALUES ('60', 'Publicidad');
INSERT INTO `areas_estudio` VALUES ('61', 'Química');
INSERT INTO `areas_estudio` VALUES ('62', 'Relaciones Públicas');
INSERT INTO `areas_estudio` VALUES ('63', 'Secretariado');
INSERT INTO `areas_estudio` VALUES ('64', 'Sociología');
INSERT INTO `areas_estudio` VALUES ('65', 'Trabajo Social');
INSERT INTO `areas_estudio` VALUES ('66', 'Turismo');
INSERT INTO `areas_estudio` VALUES ('67', 'Veterinaria');
INSERT INTO `areas_estudio` VALUES ('68', 'Ing. Ambiental');
INSERT INTO `areas_estudio` VALUES ('69', 'Ing. Matemática');
INSERT INTO `areas_estudio` VALUES ('70', 'Ing. Mecánica/Metalúrgica');
INSERT INTO `areas_estudio` VALUES ('71', 'Ing. en Sistemas');
INSERT INTO `areas_estudio` VALUES ('72', 'Ing. en Minas');
INSERT INTO `areas_estudio` VALUES ('73', 'Acuicultura');
INSERT INTO `areas_estudio` VALUES ('74', 'Adm. y Gestión Pública');
INSERT INTO `areas_estudio` VALUES ('75', 'Agronegocios');
INSERT INTO `areas_estudio` VALUES ('76', 'Análisis de Sistemas');
INSERT INTO `areas_estudio` VALUES ('77', 'Antropología');
INSERT INTO `areas_estudio` VALUES ('78', 'Arqueología');
INSERT INTO `areas_estudio` VALUES ('79', 'Astronomía');
INSERT INTO `areas_estudio` VALUES ('80', 'Cartografía');
INSERT INTO `areas_estudio` VALUES ('81', 'Comercio Int./Ext.');
INSERT INTO `areas_estudio` VALUES ('82', 'Comunicación Audiovisual');
INSERT INTO `areas_estudio` VALUES ('83', 'Dibujo Técnico');
INSERT INTO `areas_estudio` VALUES ('84', 'Diseño Industrial');
INSERT INTO `areas_estudio` VALUES ('85', 'Diseño de Vestuario / Textil / Modas');
INSERT INTO `areas_estudio` VALUES ('86', 'Ecología');
INSERT INTO `areas_estudio` VALUES ('87', 'Ing. Alimentos');
INSERT INTO `areas_estudio` VALUES ('88', 'Ing. Forestal');
INSERT INTO `areas_estudio` VALUES ('89', 'Ing. Pesquera / Cultivos Marinos');
INSERT INTO `areas_estudio` VALUES ('90', 'Literatura');
INSERT INTO `areas_estudio` VALUES ('91', 'Nutrición');
INSERT INTO `areas_estudio` VALUES ('92', 'Oceanografía');
INSERT INTO `areas_estudio` VALUES ('93', 'Paisajismo');
INSERT INTO `areas_estudio` VALUES ('94', 'Programación');
INSERT INTO `areas_estudio` VALUES ('95', 'Bibliotecología');
INSERT INTO `areas_estudio` VALUES ('96', 'Bioquímica');
INSERT INTO `areas_estudio` VALUES ('97', 'Electrónica');
INSERT INTO `areas_estudio` VALUES ('98', 'Ing. Telecomunicaciones');
INSERT INTO `areas_estudio` VALUES ('99', 'Laboratorio (Mecánica) Dental');
INSERT INTO `areas_estudio` VALUES ('100', 'Mecánica / Metalúrgica');
INSERT INTO `areas_estudio` VALUES ('101', 'Relaciones Internac.');
INSERT INTO `areas_estudio` VALUES ('102', 'Seguridad Industrial');
INSERT INTO `areas_estudio` VALUES ('103', 'Terapia Ocupacional');
INSERT INTO `areas_estudio` VALUES ('104', 'Electricidad');
INSERT INTO `areas_estudio` VALUES ('105', 'Estadística');
INSERT INTO `areas_estudio` VALUES ('106', 'Farmacia');
INSERT INTO `areas_estudio` VALUES ('107', 'Finanzas');
INSERT INTO `areas_estudio` VALUES ('108', 'Ingeniero vial');
INSERT INTO `areas_estudio` VALUES ('109', 'Gastronomía / Cocina');
INSERT INTO `areas_estudio` VALUES ('110', 'Geología / Geomensura / Topografía');
INSERT INTO `areas_estudio` VALUES ('111', 'Hidráulica');
INSERT INTO `areas_estudio` VALUES ('112', 'Ingeniero en construcción');
INSERT INTO `areas_estudio` VALUES ('113', 'Enología');
INSERT INTO `areas_estudio` VALUES ('114', 'Ing. Petróleo');
INSERT INTO `areas_estudio` VALUES ('115', 'Marketing / Comercialización');
INSERT INTO `areas_estudio` VALUES ('116', 'Medio Ambiente');
INSERT INTO `areas_estudio` VALUES ('117', 'Minería / Petróleo / Gas');
INSERT INTO `areas_estudio` VALUES ('118', 'Psicología');
INSERT INTO `areas_estudio` VALUES ('119', 'Psicopedagogía');
INSERT INTO `areas_estudio` VALUES ('120', 'Recursos Humanos / Relac. Ind.');
INSERT INTO `areas_estudio` VALUES ('121', 'Tecnología Médica / Laboratorio');
INSERT INTO `areas_estudio` VALUES ('122', 'Telecomunicaciones');
INSERT INTO `areas_estudio` VALUES ('123', 'Traducción ');
INSERT INTO `areas_estudio` VALUES ('124', 'Transporte');
INSERT INTO `areas_estudio` VALUES ('125', 'Bachiller');
INSERT INTO `areas_estudio` VALUES ('126', 'Educacion');
INSERT INTO `areas_estudio` VALUES ('127', 'Maestro Mayor de Obras');
INSERT INTO `areas_estudio` VALUES ('128', 'Perito Mercantil');
INSERT INTO `areas_estudio` VALUES ('129', 'Tecnico');
INSERT INTO `areas_estudio` VALUES ('130', 'Ing. Agrónomo');
INSERT INTO `areas_estudio` VALUES ('131', 'Ing. en Materiales');
INSERT INTO `areas_estudio` VALUES ('132', 'Fonoaudiologia');
INSERT INTO `areas_estudio` VALUES ('133', 'Diseño de Imagen y Sonido');
INSERT INTO `areas_estudio` VALUES ('134', 'Ciencias del Ejercicio / Educacion Física');
INSERT INTO `areas_estudio` VALUES ('135', 'Actuaría');
INSERT INTO `areas_estudio` VALUES ('136', 'BioFisica');
INSERT INTO `areas_estudio` VALUES ('137', 'Otra');
INSERT INTO `areas_estudio` VALUES ('138', 'Ing. - otros');
INSERT INTO `areas_estudio` VALUES ('139', 'Procesos / Calidad Total');
INSERT INTO `areas_estudio` VALUES ('140', 'Biotecnología');
INSERT INTO `areas_estudio` VALUES ('141', 'Agrimensor');
INSERT INTO `areas_estudio` VALUES ('142', 'Ing. Recursos Hídricos');
INSERT INTO `areas_estudio` VALUES ('143', 'Bioingeniería');
INSERT INTO `areas_estudio` VALUES ('144', 'Kinesiología');
INSERT INTO `areas_estudio` VALUES ('145', 'Escribanía');

-- ----------------------------
-- Table structure for areas_sectores
-- ----------------------------
DROP TABLE IF EXISTS `areas_sectores`;
CREATE TABLE `areas_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_area` int(11) DEFAULT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `amigable` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of areas_sectores
-- ----------------------------
INSERT INTO `areas_sectores` VALUES ('1', '2', 'Apoderado Aduanal', 'apoderado-aduanal');
INSERT INTO `areas_sectores` VALUES ('2', '2', 'Compras Internacionales/Importación', 'compras-internacionales-importacion');
INSERT INTO `areas_sectores` VALUES ('3', '2', 'Consultorías Comercio Exterior', 'consultorias-comercio-exterior');
INSERT INTO `areas_sectores` VALUES ('4', '2', 'Ventas Internacionales/Exportación', 'ventas-internacionales-exportacion');
INSERT INTO `areas_sectores` VALUES ('5', '1', 'Administración', 'administracion');
INSERT INTO `areas_sectores` VALUES ('6', '1', 'Análisis de Riesgos', 'analisis-de-riesgos');
INSERT INTO `areas_sectores` VALUES ('7', '1', 'Auditoría', 'auditoria');
INSERT INTO `areas_sectores` VALUES ('8', '1', 'Clearing', 'clearing');
INSERT INTO `areas_sectores` VALUES ('9', '1', 'Consultoria', 'consultoria');
INSERT INTO `areas_sectores` VALUES ('10', '1', 'Contabilidad', 'contabilidad');
INSERT INTO `areas_sectores` VALUES ('11', '1', 'Control de Gestión', 'control-de-gestion');
INSERT INTO `areas_sectores` VALUES ('12', '1', 'Corporate Finance / Banca Inversión', 'corporate-finance-banca-inversion');
INSERT INTO `areas_sectores` VALUES ('13', '1', 'Créditos y Cobranzas', 'creditos-y-cobranzas');
INSERT INTO `areas_sectores` VALUES ('14', '1', 'Cuentas Corrientes', 'cuentas-corrientes');
INSERT INTO `areas_sectores` VALUES ('15', '1', 'Evaluación Económica', 'evaluacion-economica');
INSERT INTO `areas_sectores` VALUES ('16', '1', 'Facturación', 'facturacion');
INSERT INTO `areas_sectores` VALUES ('17', '1', 'Finanzas', 'finanzas');
INSERT INTO `areas_sectores` VALUES ('18', '1', 'Finanzas Internacionales', 'finanzas-internacionales');
INSERT INTO `areas_sectores` VALUES ('19', '1', 'Impuestos', 'impuestos');
INSERT INTO `areas_sectores` VALUES ('20', '1', 'Inversiones / Proyectos de Inversión', 'inversiones-proyectos-de-inversion');
INSERT INTO `areas_sectores` VALUES ('21', '1', 'Mercado de Capitales', 'mercado-de-capitales');
INSERT INTO `areas_sectores` VALUES ('22', '1', 'Organización y Métodos', 'organizacion-y-metodos');
INSERT INTO `areas_sectores` VALUES ('23', '1', 'Planeamiento económico-financiero', 'planeamiento-economico-financiero');
INSERT INTO `areas_sectores` VALUES ('24', '1', 'Tesorería', 'tesoreria');
INSERT INTO `areas_sectores` VALUES ('25', '4', 'Arquitectura', 'arquitectura');
INSERT INTO `areas_sectores` VALUES ('26', '4', 'Construcción', 'construccion');
INSERT INTO `areas_sectores` VALUES ('27', '4', 'Dirección de Obra', 'direccion-de-obra');
INSERT INTO `areas_sectores` VALUES ('28', '4', 'Ingeniería Civil', 'ingenieria-civil');
INSERT INTO `areas_sectores` VALUES ('29', '4', 'Instrumentación', 'instrumentacion');
INSERT INTO `areas_sectores` VALUES ('30', '4', 'Operaciones', 'operaciones');
INSERT INTO `areas_sectores` VALUES ('31', '4', 'Seguridad e Higiene', 'seguridad-e-higiene');
INSERT INTO `areas_sectores` VALUES ('32', '4', 'Topografía', 'topografia');
INSERT INTO `areas_sectores` VALUES ('33', '4', 'Urbanismo', 'urbanismo');
INSERT INTO `areas_sectores` VALUES ('34', '3', 'Abastecimiento', 'abastecimiento');
INSERT INTO `areas_sectores` VALUES ('35', '3', 'Almacén / Depósito / Expedición', 'almacen-deposito-expedicion');
INSERT INTO `areas_sectores` VALUES ('36', '3', 'Asistente de Tráfico', 'asistente-de-trafico');
INSERT INTO `areas_sectores` VALUES ('37', '3', 'Compras', 'compras');
INSERT INTO `areas_sectores` VALUES ('38', '3', 'Distribución', 'distribucion');
INSERT INTO `areas_sectores` VALUES ('39', '3', 'Logística', 'logistica');
INSERT INTO `areas_sectores` VALUES ('40', '3', 'Transporte', 'transporte');
INSERT INTO `areas_sectores` VALUES ('41', '5', 'Comercial', 'comercial');
INSERT INTO `areas_sectores` VALUES ('42', '5', 'Comercio Exterior', 'comercio-exterior');
INSERT INTO `areas_sectores` VALUES ('43', '5', 'Desarrollo de Negocios', 'desarrollo-de-negocios');
INSERT INTO `areas_sectores` VALUES ('44', '5', 'Negocios Internacionales', 'negocios-internacionales');
INSERT INTO `areas_sectores` VALUES ('45', '5', 'Planeamiento comercial', 'planeamiento-comercial');
INSERT INTO `areas_sectores` VALUES ('46', '5', 'Ventas', 'ventas');
INSERT INTO `areas_sectores` VALUES ('47', '6', 'Bienestar Estudiantil', 'bienestar-estudiantil');
INSERT INTO `areas_sectores` VALUES ('48', '6', 'Educación', 'educacion');
INSERT INTO `areas_sectores` VALUES ('49', '6', 'Educación especial', 'educacion-especial');
INSERT INTO `areas_sectores` VALUES ('50', '6', 'Educación/ Docentes', 'educacion-docentes');
INSERT INTO `areas_sectores` VALUES ('51', '6', 'Idiomas', 'idiomas');
INSERT INTO `areas_sectores` VALUES ('52', '6', 'Investigación y Desarrollo', 'investigacion-y-desarrollo');
INSERT INTO `areas_sectores` VALUES ('53', '6', 'Psicopedagogía', 'psicopedagogia');
INSERT INTO `areas_sectores` VALUES ('54', '7', 'Camareros', 'camareros');
INSERT INTO `areas_sectores` VALUES ('55', '7', 'Casinos', 'casinos');
INSERT INTO `areas_sectores` VALUES ('56', '7', 'Gastronomia', 'gastronomia');
INSERT INTO `areas_sectores` VALUES ('57', '7', 'Hotelería', 'hoteleria');
INSERT INTO `areas_sectores` VALUES ('58', '7', 'Turismo', 'turismo');
INSERT INTO `areas_sectores` VALUES ('59', '8', 'Dirección', 'direccion');
INSERT INTO `areas_sectores` VALUES ('60', '8', 'Gerencia / Dirección General', 'gerencia-direccion-general');
INSERT INTO `areas_sectores` VALUES ('61', '9', 'Asesoría Legal Internacional', 'asesoria-legal-internacional');
INSERT INTO `areas_sectores` VALUES ('62', '9', 'Garantías', 'garantias');
INSERT INTO `areas_sectores` VALUES ('63', '9', 'Legal', 'legal');
INSERT INTO `areas_sectores` VALUES ('64', '10', 'Business Intelligence', 'business-intelligence');
INSERT INTO `areas_sectores` VALUES ('65', '10', 'Community Management', 'community-management');
INSERT INTO `areas_sectores` VALUES ('66', '10', 'Creatividad', 'creatividad');
INSERT INTO `areas_sectores` VALUES ('67', '10', 'E-commerce', 'e-commerce');
INSERT INTO `areas_sectores` VALUES ('68', '10', 'Marketing', 'marketing');
INSERT INTO `areas_sectores` VALUES ('69', '10', 'Media Planning', 'media-planning');
INSERT INTO `areas_sectores` VALUES ('70', '10', 'Mercadotecnia Internacional', 'mercadotecnia-internacional');
INSERT INTO `areas_sectores` VALUES ('71', '10', 'Multimedia', 'multimedia');
INSERT INTO `areas_sectores` VALUES ('72', '10', 'Producto', 'producto');
INSERT INTO `areas_sectores` VALUES ('73', '11', 'Calidad', 'calidad');
INSERT INTO `areas_sectores` VALUES ('74', '11', 'Mantenimiento', 'mantenimiento');
INSERT INTO `areas_sectores` VALUES ('75', '11', 'Producción', 'produccion');
INSERT INTO `areas_sectores` VALUES ('76', '11', 'Programación de producción', 'programacion-de-produccion');
INSERT INTO `areas_sectores` VALUES ('77', '12', 'Administración de Personal', 'administracion-de-personal');
INSERT INTO `areas_sectores` VALUES ('78', '12', 'Capacitación', 'capacitacion');
INSERT INTO `areas_sectores` VALUES ('79', '12', 'Capacitación Comercio Exterior', 'capacitacion-comercio-exterior');
INSERT INTO `areas_sectores` VALUES ('80', '12', 'Compensación y Planilla', 'compensacion-y-planilla');
INSERT INTO `areas_sectores` VALUES ('81', '12', 'Recursos Humanos', 'recursos-humanos');
INSERT INTO `areas_sectores` VALUES ('82', '12', 'Selección', 'seleccion');
INSERT INTO `areas_sectores` VALUES ('83', '14', 'Administración de Base de Datos', 'administracion-de-base-de-datos');
INSERT INTO `areas_sectores` VALUES ('84', '14', 'Análisis Funcional', 'analisis-funcional');
INSERT INTO `areas_sectores` VALUES ('85', '14', 'Data Entry', 'data-entry');
INSERT INTO `areas_sectores` VALUES ('86', '14', 'Data Warehousing', 'data-warehousing');
INSERT INTO `areas_sectores` VALUES ('87', '14', 'Infraestructura', 'infraestructura');
INSERT INTO `areas_sectores` VALUES ('88', '14', 'Internet', 'internet');
INSERT INTO `areas_sectores` VALUES ('89', '14', 'Liderazgo de Proyecto', 'liderazgo-de-proyecto');
INSERT INTO `areas_sectores` VALUES ('90', '14', 'Programación', 'programacion');
INSERT INTO `areas_sectores` VALUES ('91', '14', 'Redes', 'redes');
INSERT INTO `areas_sectores` VALUES ('92', '14', 'Seguridad Informática', 'seguridad-informatica');
INSERT INTO `areas_sectores` VALUES ('93', '14', 'Sistemas', 'sistemas');
INSERT INTO `areas_sectores` VALUES ('94', '14', 'Soporte Técnico', 'soporte-tecnico');
INSERT INTO `areas_sectores` VALUES ('95', '14', 'Tecnologia / Sistemas', 'tecnologia-sistemas');
INSERT INTO `areas_sectores` VALUES ('96', '14', 'Tecnologías de la Información', 'tecnologias-de-la-informacion');
INSERT INTO `areas_sectores` VALUES ('97', '14', 'Telecomunicaciones', 'telecomunicaciones');
INSERT INTO `areas_sectores` VALUES ('98', '14', 'Testing / QA / QC', 'testing-qa-qc');
INSERT INTO `areas_sectores` VALUES ('99', '13', 'Comunicacion', 'comunicacion');
INSERT INTO `areas_sectores` VALUES ('100', '13', 'Comunicaciones Externas', 'comunicaciones-externas');
INSERT INTO `areas_sectores` VALUES ('101', '13', 'Comunicaciones Internas', 'comunicaciones-internas');
INSERT INTO `areas_sectores` VALUES ('102', '13', 'Periodismo', 'periodismo');
INSERT INTO `areas_sectores` VALUES ('103', '13', 'Relaciones Institucionales/Publicas', 'relaciones-institucionales-publicas');
INSERT INTO `areas_sectores` VALUES ('104', '13', 'Responsabilidad Social', 'responsabilidad-social');
INSERT INTO `areas_sectores` VALUES ('105', '15', 'Aeropuertos', 'aeropuertos');
INSERT INTO `areas_sectores` VALUES ('106', '15', 'Arte y Cultura', 'arte-y-cultura');
INSERT INTO `areas_sectores` VALUES ('107', '15', 'Back Office', 'back-office');
INSERT INTO `areas_sectores` VALUES ('108', '15', 'Cadetería', 'cadeteria');
INSERT INTO `areas_sectores` VALUES ('109', '15', 'Caja', 'caja');
INSERT INTO `areas_sectores` VALUES ('110', '15', 'Estética y Cuidado Personal', 'estetica-y-cuidado-personal');
INSERT INTO `areas_sectores` VALUES ('111', '15', 'Independientes', 'independientes');
INSERT INTO `areas_sectores` VALUES ('112', '15', 'Jóvenes Profesionales', 'jovenes-profesionales');
INSERT INTO `areas_sectores` VALUES ('113', '15', 'Mantenimiento y Limpieza', 'mantenimiento-y-limpieza');
INSERT INTO `areas_sectores` VALUES ('114', '15', 'Oficios y Profesiones', 'oficios-y-profesiones');
INSERT INTO `areas_sectores` VALUES ('115', '15', 'Otros', 'otros');
INSERT INTO `areas_sectores` VALUES ('116', '15', 'Packaging', 'packaging');
INSERT INTO `areas_sectores` VALUES ('117', '15', 'Pasantía / Trainee', 'pasantia-trainee');
INSERT INTO `areas_sectores` VALUES ('118', '15', 'Planeamiento', 'planeamiento');
INSERT INTO `areas_sectores` VALUES ('119', '15', 'Promotoras/es', 'promotoras-es');
INSERT INTO `areas_sectores` VALUES ('120', '15', 'Prácticas Profesionales', 'practicas-profesionales');
INSERT INTO `areas_sectores` VALUES ('121', '15', 'Seguridad', 'seguridad');
INSERT INTO `areas_sectores` VALUES ('122', '15', 'Servicios', 'servicios');
INSERT INTO `areas_sectores` VALUES ('123', '15', 'Trabajo Social', 'trabajo-social');
INSERT INTO `areas_sectores` VALUES ('124', '15', 'Traduccion', 'traduccion');
INSERT INTO `areas_sectores` VALUES ('125', '15', 'Transporte', 'transporte');
INSERT INTO `areas_sectores` VALUES ('126', '17', 'Atención al Cliente', 'atencion-al-cliente');
INSERT INTO `areas_sectores` VALUES ('127', '17', 'Call Center', 'call-center');
INSERT INTO `areas_sectores` VALUES ('128', '17', 'Telemarketing', 'telemarketing');
INSERT INTO `areas_sectores` VALUES ('129', '16', 'Bioquímica', 'bioquimica');
INSERT INTO `areas_sectores` VALUES ('130', '16', 'Farmacéutica', 'farmaceutica');
INSERT INTO `areas_sectores` VALUES ('131', '16', 'Laboratorio', 'laboratorio');
INSERT INTO `areas_sectores` VALUES ('132', '16', 'Medicina', 'medicina');
INSERT INTO `areas_sectores` VALUES ('133', '16', 'Química', 'quimica');
INSERT INTO `areas_sectores` VALUES ('134', '16', 'Salud', 'salud');
INSERT INTO `areas_sectores` VALUES ('135', '16', 'Veterinaria', 'veterinaria');
INSERT INTO `areas_sectores` VALUES ('136', '18', 'Asistente', 'asistente');
INSERT INTO `areas_sectores` VALUES ('137', '18', 'Recepcionista', 'recepcionista');
INSERT INTO `areas_sectores` VALUES ('138', '18', 'Secretaria', 'secretaria');
INSERT INTO `areas_sectores` VALUES ('139', '18', 'Telefonista', 'telefonista');
INSERT INTO `areas_sectores` VALUES ('140', '19', 'Administracion de Seguros', 'administracion-de-seguros');
INSERT INTO `areas_sectores` VALUES ('141', '19', 'Auditoría de Seguros', 'auditoria-de-seguros');
INSERT INTO `areas_sectores` VALUES ('142', '19', 'Seguros', 'seguros');
INSERT INTO `areas_sectores` VALUES ('143', '19', 'Tecnico de Seguros', 'tecnico-de-seguros');
INSERT INTO `areas_sectores` VALUES ('144', '19', 'Venta de Seguros', 'venta-de-seguros');
INSERT INTO `areas_sectores` VALUES ('145', '20', 'Exploración Minera y Petroquimica', 'exploracion-minera-y-petroquimica');
INSERT INTO `areas_sectores` VALUES ('146', '20', 'Ingeniería Geológica', 'ingenieria-geologica');
INSERT INTO `areas_sectores` VALUES ('147', '20', 'Ingeniería en Minas', 'ingenieria-en-minas');
INSERT INTO `areas_sectores` VALUES ('148', '20', 'Ingeniería en Petróleo y Petroquímica', 'ingenieria-en-petroleo-y-petroquimica');
INSERT INTO `areas_sectores` VALUES ('149', '20', 'Instrumentación Minera', 'instrumentacion-minera');
INSERT INTO `areas_sectores` VALUES ('150', '20', 'Medio Ambiente', 'medio-ambiente');
INSERT INTO `areas_sectores` VALUES ('151', '20', 'Mineria/Petroleo/Gas', 'mineria-petroleo-gas');
INSERT INTO `areas_sectores` VALUES ('152', '20', 'Seguridad Industrial', 'seguridad-industrial');
INSERT INTO `areas_sectores` VALUES ('153', '21', 'Ingeniería  Automotriz', 'ingenieria-automotriz');
INSERT INTO `areas_sectores` VALUES ('154', '21', 'Ingeniería  Eléctrica y Electrónica', 'ingenieria-electrica-y-electronica');
INSERT INTO `areas_sectores` VALUES ('155', '21', 'Ingeniería  Industrial', 'ingenieria-industrial');
INSERT INTO `areas_sectores` VALUES ('156', '21', 'Ingeniería  Mecánica', 'ingenieria-mecanica');
INSERT INTO `areas_sectores` VALUES ('157', '21', 'Ingeniería  Metalurgica', 'ingenieria-metalurgica');
INSERT INTO `areas_sectores` VALUES ('158', '21', 'Ingeniería  Textil', 'ingenieria-textil');
INSERT INTO `areas_sectores` VALUES ('159', '21', 'Ingeniería Agrónoma', 'ingenieria-agronoma');
INSERT INTO `areas_sectores` VALUES ('160', '21', 'Ingeniería Electromecánica', 'ingenieria-electromecanica');
INSERT INTO `areas_sectores` VALUES ('161', '21', 'Ingeniería Oficina Técnica / Proyecto', 'ingenieria-oficina-tecnica-proyecto');
INSERT INTO `areas_sectores` VALUES ('162', '21', 'Ingeniería Química', 'ingenieria-quimica');
INSERT INTO `areas_sectores` VALUES ('163', '21', 'Ingeniería de Procesos', 'ingenieria-de-procesos');
INSERT INTO `areas_sectores` VALUES ('164', '21', 'Ingeniería de Producto', 'ingenieria-de-producto');
INSERT INTO `areas_sectores` VALUES ('165', '21', 'Ingeniería de Ventas', 'ingenieria-de-ventas');
INSERT INTO `areas_sectores` VALUES ('166', '21', 'Ingeniería en Alimentos', 'ingenieria-en-alimentos');
INSERT INTO `areas_sectores` VALUES ('167', '21', 'Otras Ingenierias', 'otras-ingenierias');
INSERT INTO `areas_sectores` VALUES ('168', '22', 'Diseño', 'diseno');
INSERT INTO `areas_sectores` VALUES ('169', '22', 'Diseño Gráfico', 'diseno-grafico');
INSERT INTO `areas_sectores` VALUES ('170', '22', 'Diseño Industrial', 'diseno-industrial');
INSERT INTO `areas_sectores` VALUES ('171', '22', 'Diseño Multimedia', 'diseno-multimedia');
INSERT INTO `areas_sectores` VALUES ('172', '22', 'Diseño Textil e Indumentaria', 'diseno-textil-e-indumentaria');
INSERT INTO `areas_sectores` VALUES ('173', '22', 'Diseño Web', 'diseno-web');
INSERT INTO `areas_sectores` VALUES ('174', '22', 'Diseño de Interiores / Decoración', 'diseno-de-interiores-decoracion');

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES ('2', 'deportes', '2017-02-10 15:35:24', '2017-02-10 15:35:24');

-- ----------------------------
-- Table structure for configuraciones
-- ----------------------------
DROP TABLE IF EXISTS `configuraciones`;
CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iva` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of configuraciones
-- ----------------------------
INSERT INTO `configuraciones` VALUES ('1', '0.12');

-- ----------------------------
-- Table structure for empresas
-- ----------------------------
DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  `nombre_responsable` varchar(64) DEFAULT NULL,
  `apellido_responsable` varchar(32) DEFAULT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `razon_social` varchar(64) DEFAULT NULL,
  `clave` varchar(64) DEFAULT NULL,
  `correo_electronico` varchar(48) DEFAULT NULL,
  `telefono` varchar(48) DEFAULT NULL,
  `sitio_web` varchar(64) DEFAULT NULL,
  `facebook` varchar(64) DEFAULT NULL,
  `twitter` varchar(64) DEFAULT NULL,
  `instagram` varchar(64) DEFAULT NULL,
  `snapchat` varchar(64) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `codigo_recuperacion` varchar(16) DEFAULT NULL,
  `id_actividad` int(11) DEFAULT NULL,
  `cuit` varchar(255) DEFAULT NULL,
  `suspendido` tinyint(1) DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of empresas
-- ----------------------------
INSERT INTO `empresas` VALUES ('1', '1', '0', '', '1', 'Mi empresa', null, '1', '1@1.com', null, '  www.url.com3', 'facebook.com/empresa', 'twitter.com/empresa', 'instagram.com/empresa', 'snapchat.com/empresa', '2016-12-06 13:39:29', '2016-12-06 13:39:29', null, '34', null, null, '0');
INSERT INTO `empresas` VALUES ('2', '2', '26', '1', '1', '1', '1', '1', '2@2.com', '', 'www.prueba.com', '', '', '', '', '2016-12-21 02:33:48', '2016-12-21 02:33:48', null, null, null, null, '1');
INSERT INTO `empresas` VALUES ('6', '3', '0', '3', '3', '3', '3', '1', '3@3.com', '', 'www.prueba3.com', '', '', '', '', '2017-01-12 01:05:49', '2017-01-12 01:05:49', null, null, null, null, '0');
INSERT INTO `empresas` VALUES ('7', '4', '0', '4', '4', '4', '4', '1', '4@4.com', '', 'www.prueba4.com', '', '', '', '', '2017-01-12 01:05:49', '2017-01-12 01:05:49', null, null, null, null, '0');

-- ----------------------------
-- Table structure for empresas_chat
-- ----------------------------
DROP TABLE IF EXISTS `empresas_chat`;
CREATE TABLE `empresas_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid_usuario1` int(11) DEFAULT NULL,
  `uid_usuario2` int(11) DEFAULT NULL,
  `mensaje` text,
  `fecha_envio` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `fecha_lectura_usuario1` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `fecha_lectura_usuario2` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresas_chat
-- ----------------------------
INSERT INTO `empresas_chat` VALUES ('42', '1', '6', 'Hola Alexis, tengo una vacante justo para ti...!', '2017-03-24 14:35:48', '2017-03-24 14:35:48', null);
INSERT INTO `empresas_chat` VALUES ('43', '1', '6', 'Que tal?', '2017-03-24 14:40:13', '2017-03-24 14:40:13', null);
INSERT INTO `empresas_chat` VALUES ('44', '6', '1', 'Todo fino', '2017-03-24 14:10:52', '2017-03-24 14:10:52', '2017-03-24 14:10:57');
INSERT INTO `empresas_chat` VALUES ('45', '1', '6', 'hey soul sister', '2017-03-24 14:56:07', '2017-03-24 14:56:07', null);
INSERT INTO `empresas_chat` VALUES ('46', '1', '6', 'hey soul sister', '2017-03-24 14:56:12', '2017-03-24 14:56:12', null);
INSERT INTO `empresas_chat` VALUES ('47', '1', '6', 'hey soul sister', '2017-03-24 14:57:08', '2017-03-24 14:57:08', null);
INSERT INTO `empresas_chat` VALUES ('48', '1', '6', 'heeeey', '2017-03-24 14:57:32', '2017-03-24 14:57:32', null);

-- ----------------------------
-- Table structure for empresas_contrataciones
-- ----------------------------
DROP TABLE IF EXISTS `empresas_contrataciones`;
CREATE TABLE `empresas_contrataciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `id_publicacion` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `finalizado` tinyint(1) DEFAULT NULL,
  `cancelado` tinyint(1) DEFAULT NULL,
  `fecha_finalizado` date DEFAULT NULL,
  `calificacion` float DEFAULT NULL,
  `comentario` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresas_contrataciones
-- ----------------------------
INSERT INTO `empresas_contrataciones` VALUES ('1', '1', '2017-01-25', '1370', '2', '1', '0', '2017-01-27', '5', 'excelente en todo. muy contento con el resultado');
INSERT INTO `empresas_contrataciones` VALUES ('2', '1', '2017-01-30', '1305', '1', '1', null, null, '3', 'comunicacion y duracion mal...');
INSERT INTO `empresas_contrataciones` VALUES ('3', '1', '2017-01-30', '1305', '1', '0', null, null, null, null);
INSERT INTO `empresas_contrataciones` VALUES ('4', '1', '2017-01-30', '1305', '1', '0', null, null, null, null);

-- ----------------------------
-- Table structure for empresas_pagos
-- ----------------------------
DROP TABLE IF EXISTS `empresas_pagos`;
CREATE TABLE `empresas_pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `informacion` text,
  `plan` int(11) DEFAULT NULL,
  `servicio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresas_pagos
-- ----------------------------

-- ----------------------------
-- Table structure for empresas_planes
-- ----------------------------
DROP TABLE IF EXISTS `empresas_planes`;
CREATE TABLE `empresas_planes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_plan` date DEFAULT NULL,
  `logo_home` tinyint(1) NOT NULL,
  `link_empresa` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresas_planes
-- ----------------------------
INSERT INTO `empresas_planes` VALUES ('1', '2', '3', '2017-03-30', '2017-03-30', '2', '1');
INSERT INTO `empresas_planes` VALUES ('2', '1', '2', '2017-03-30', '2017-03-30', '1', '0');
INSERT INTO `empresas_planes` VALUES ('5', '6', '4', '2017-03-30', '2017-03-30', '3', '1');
INSERT INTO `empresas_planes` VALUES ('6', '7', '4', '2017-03-30', '2017-03-30', '3', '1');

-- ----------------------------
-- Table structure for empresas_publicaciones_especiales
-- ----------------------------
DROP TABLE IF EXISTS `empresas_publicaciones_especiales`;
CREATE TABLE `empresas_publicaciones_especiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `titulo` varchar(32) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresas_publicaciones_especiales
-- ----------------------------
INSERT INTO `empresas_publicaciones_especiales` VALUES ('4', '6', '1', 'prueba', 'Esta es una prueba para ver el tamaño que se mostrara 2 lineas per si sto sepasa entnces mostramos', '28', null, '2017-02-05');
INSERT INTO `empresas_publicaciones_especiales` VALUES ('5', '7', '2', 'prueba link', '', '0', 'https://www.youtube.com/watch?v=CCEAD8PYBAg', '2017-02-06');

-- ----------------------------
-- Table structure for empresas_servicios
-- ----------------------------
DROP TABLE IF EXISTS `empresas_servicios`;
CREATE TABLE `empresas_servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_servicio` date DEFAULT NULL,
  `curriculos_disponibles` int(11) DEFAULT NULL,
  `filtros_personalizados` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of empresas_servicios
-- ----------------------------
INSERT INTO `empresas_servicios` VALUES ('1', '2', '4', '2017-01-07', '2017-01-31', '0', '0');
INSERT INTO `empresas_servicios` VALUES ('2', '1', '4', '2017-01-12', '2017-03-02', '0', '0');
INSERT INTO `empresas_servicios` VALUES ('5', '6', '4', '2017-01-12', '2017-01-12', '15', '0');
INSERT INTO `empresas_servicios` VALUES ('6', '7', '4', '2017-02-12', '2017-01-12', '15', '0');

-- ----------------------------
-- Table structure for estado_estudio
-- ----------------------------
DROP TABLE IF EXISTS `estado_estudio`;
CREATE TABLE `estado_estudio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of estado_estudio
-- ----------------------------
INSERT INTO `estado_estudio` VALUES ('1', 'En Curso');
INSERT INTO `estado_estudio` VALUES ('2', 'Graduado');
INSERT INTO `estado_estudio` VALUES ('3', 'Abandonado');

-- ----------------------------
-- Table structure for estados_civiles
-- ----------------------------
DROP TABLE IF EXISTS `estados_civiles`;
CREATE TABLE `estados_civiles` (
  `id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estados_civiles
-- ----------------------------
INSERT INTO `estados_civiles` VALUES ('1', 'Soltero/a');
INSERT INTO `estados_civiles` VALUES ('2', 'Casado/a');
INSERT INTO `estados_civiles` VALUES ('3', 'Union Libre');
INSERT INTO `estados_civiles` VALUES ('4', 'Divorciado/a');
INSERT INTO `estados_civiles` VALUES ('5', 'Pareja de Hecho');
INSERT INTO `estados_civiles` VALUES ('6', 'Viudo/a');

-- ----------------------------
-- Table structure for idiomas
-- ----------------------------
DROP TABLE IF EXISTS `idiomas`;
CREATE TABLE `idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of idiomas
-- ----------------------------
INSERT INTO `idiomas` VALUES ('1', 'Alemán');
INSERT INTO `idiomas` VALUES ('2', 'Chino Mandarín');
INSERT INTO `idiomas` VALUES ('3', 'Coreano');
INSERT INTO `idiomas` VALUES ('4', 'Español');
INSERT INTO `idiomas` VALUES ('5', 'Francés');
INSERT INTO `idiomas` VALUES ('6', 'Inglés');
INSERT INTO `idiomas` VALUES ('7', 'Italiano');
INSERT INTO `idiomas` VALUES ('8', 'Japonés');
INSERT INTO `idiomas` VALUES ('9', 'Portugués');

-- ----------------------------
-- Table structure for imagenes
-- ----------------------------
DROP TABLE IF EXISTS `imagenes`;
CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(48) DEFAULT NULL,
  `directorio` varchar(32) DEFAULT NULL,
  `extension` varchar(8) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `nombre` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of imagenes
-- ----------------------------
INSERT INTO `imagenes` VALUES ('3', '3', 'product', 'jpg', '2017-02-05 10:18:45', '2017-02-05 10:18:45', '3');
INSERT INTO `imagenes` VALUES ('25', '25', 'profile', 'jpg', '2017-01-15 09:51:41', '2017-01-15 09:51:41', '25');
INSERT INTO `imagenes` VALUES ('26', '26', 'profile', 'jpg', '2017-01-15 10:24:00', '2017-01-15 10:24:00', '26');
INSERT INTO `imagenes` VALUES ('27', '27', 'profile', 'jpg', '2017-02-02 04:17:16', '2017-02-02 04:17:16', '27');
INSERT INTO `imagenes` VALUES ('28', '28', 'product', 'jpg', '2017-02-05 10:20:18', '2017-02-05 10:20:18', '28');
INSERT INTO `imagenes` VALUES ('29', '29', 'notices', 'jpg', '2017-02-10 02:05:53', '2017-02-10 03:12:21', '29');
INSERT INTO `imagenes` VALUES ('30', '30', 'ad', 'jpg', '2017-02-16 02:27:25', '2017-02-16 02:27:25', '30');
INSERT INTO `imagenes` VALUES ('32', '32', 'ad', 'jpg', '2017-02-16 02:35:15', '2017-02-16 02:35:15', '32');
INSERT INTO `imagenes` VALUES ('33', '33', 'ad', 'jpg', '2017-02-16 03:19:02', '2017-02-16 03:19:02', '33');
INSERT INTO `imagenes` VALUES ('34', '34', 'ad', 'jpg', '2017-02-16 03:19:36', '2017-02-16 03:19:36', '34');
INSERT INTO `imagenes` VALUES ('35', '35', 'ad', 'jpg', '2017-02-16 03:19:50', '2017-02-16 03:19:50', '35');
INSERT INTO `imagenes` VALUES ('36', '36', 'ad', 'jpg', '2017-02-20 07:38:44', '2017-02-20 07:38:44', '36');

-- ----------------------------
-- Table structure for membresias
-- ----------------------------
DROP TABLE IF EXISTS `membresias`;
CREATE TABLE `membresias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `moneda` varchar(16) DEFAULT NULL,
  `logo_home` tinyint(1) DEFAULT NULL,
  `curriculos_disponibles` int(11) DEFAULT NULL,
  `filtros_personalizados` tinyint(1) DEFAULT NULL,
  `link_empresa` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of membresias
-- ----------------------------
INSERT INTO `membresias` VALUES ('1', 'Gratis', '0', 'USD', '0', '10', '0', '0');
INSERT INTO `membresias` VALUES ('2', 'Bronce', '1120.5', 'USD', '1', '40', '1', '0');
INSERT INTO `membresias` VALUES ('3', 'Busqueda en base x 40', '1120.5', 'USD', '0', '40', '0', '0');
INSERT INTO `membresias` VALUES ('4', 'Plata', '2739', 'USD', '2', '0', '1', '0');
INSERT INTO `membresias` VALUES ('5', 'Busqueda en base x 80', '1743', 'USD', '0', '100', '1', '0');
INSERT INTO `membresias` VALUES ('6', 'Oro', '5602.5', 'USD', '2', null, '1', '1');
INSERT INTO `membresias` VALUES ('7', 'Busqueda en base x 150', '2739', 'USD', '0', '150', '1', '0');

-- ----------------------------
-- Table structure for mensajes
-- ----------------------------
DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario1` int(11) DEFAULT NULL,
  `id_usuario2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mensajes
-- ----------------------------
INSERT INTO `mensajes` VALUES ('1', '1', '1');
INSERT INTO `mensajes` VALUES ('2', '2', '1');

-- ----------------------------
-- Table structure for mensajes_respuestas
-- ----------------------------
DROP TABLE IF EXISTS `mensajes_respuestas`;
CREATE TABLE `mensajes_respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mensaje` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo_usuario` varchar(255) DEFAULT NULL,
  `mensaje` text,
  `fecha_hora` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mensajes_respuestas
-- ----------------------------
INSERT INTO `mensajes_respuestas` VALUES ('1', '1', '2', '1', 'Hola', '2016-12-20 10:08:50');
INSERT INTO `mensajes_respuestas` VALUES ('2', '1', '2', '1', 'Mundo', '2016-12-20 10:09:20');
INSERT INTO `mensajes_respuestas` VALUES ('3', '1', '1', '2', 'Que paso?', '2016-12-20 10:09:39');
INSERT INTO `mensajes_respuestas` VALUES ('4', '1', '2', '1', 'Nada', '2016-12-20 10:12:53');
INSERT INTO `mensajes_respuestas` VALUES ('5', '2', '2', '1', 'Hi', '2016-12-20 10:13:49');
INSERT INTO `mensajes_respuestas` VALUES ('6', '1', '1', '2', 'como que nada?', '2016-12-20 08:58:34');
INSERT INTO `mensajes_respuestas` VALUES ('8', '1', '1', '2', 'dime', '2016-12-20 09:12:11');
INSERT INTO `mensajes_respuestas` VALUES ('9', '1', '1', '2', '????', '2016-12-20 09:26:21');
INSERT INTO `mensajes_respuestas` VALUES ('10', '1', '1', '2', 'heeey!', '2016-12-21 04:32:09');
INSERT INTO `mensajes_respuestas` VALUES ('11', '1', '2', '1', 'jodete', '2016-12-21 06:32:37');
INSERT INTO `mensajes_respuestas` VALUES ('15', '2', '1', '2', 'que paho?', '2016-12-21 04:40:17');
INSERT INTO `mensajes_respuestas` VALUES ('25', '2', '1', '2', '???', '2016-12-21 06:24:29');
INSERT INTO `mensajes_respuestas` VALUES ('26', '2', '1', '2', 'decime', '2016-12-21 06:26:15');
INSERT INTO `mensajes_respuestas` VALUES ('27', '2', '1', '2', 'aaa?', '2016-12-21 06:38:31');
INSERT INTO `mensajes_respuestas` VALUES ('28', '2', '1', '2', '???', '2016-12-21 06:40:06');
INSERT INTO `mensajes_respuestas` VALUES ('32', '2', '1', '2', 'To capture the search text all we need is a simple input text field. To make the feature a little more exciting we are also going to show the number of results underneath the text input. For this we need to add a div tag with the ID – “filter-count”', '2016-12-21 06:45:05');
INSERT INTO `mensajes_respuestas` VALUES ('33', '2', '1', '2', 'sos un puto', '2016-12-21 06:46:14');
INSERT INTO `mensajes_respuestas` VALUES ('34', '2', '1', '2', 'asddasdas', '2016-12-21 06:46:34');
INSERT INTO `mensajes_respuestas` VALUES ('35', '2', '1', '2', 'heeey', '2016-12-21 06:49:45');
INSERT INTO `mensajes_respuestas` VALUES ('36', '2', '1', '2', 'que paso locote', '2016-12-21 06:50:36');
INSERT INTO `mensajes_respuestas` VALUES ('37', '2', '1', '2', 'que hay', '2016-12-21 06:50:47');
INSERT INTO `mensajes_respuestas` VALUES ('38', '1', '1', '2', '???', '2017-01-03 16:08:31');
INSERT INTO `mensajes_respuestas` VALUES ('39', '2', '1', '2', '???', '2017-01-03 19:23:02');
INSERT INTO `mensajes_respuestas` VALUES ('40', '1', '1', '2', '...', '2017-01-03 19:23:16');
INSERT INTO `mensajes_respuestas` VALUES ('41', '1', '1', '2', 'xc', '2017-01-03 21:44:13');
INSERT INTO `mensajes_respuestas` VALUES ('42', '1', '1', '2', 'wena choro', '2017-01-03 21:44:50');
INSERT INTO `mensajes_respuestas` VALUES ('43', '1', '1', '2', 'oliii', '2017-01-03 21:44:59');
INSERT INTO `mensajes_respuestas` VALUES ('44', '1', '1', '2', 'wena wena', '2017-01-03 21:45:00');
INSERT INTO `mensajes_respuestas` VALUES ('45', '1', '1', '2', 'lgo asi', '2017-01-03 21:45:07');
INSERT INTO `mensajes_respuestas` VALUES ('46', '1', '1', '2', 'pero mas isi', '2017-01-03 21:45:16');
INSERT INTO `mensajes_respuestas` VALUES ('47', '1', '1', '2', 'pero mas isi', '2017-01-03 21:45:16');
INSERT INTO `mensajes_respuestas` VALUES ('48', '1', '1', '2', 'xd', '2017-01-03 21:45:16');
INSERT INTO `mensajes_respuestas` VALUES ('49', '1', '1', '2', 'ya', '2017-01-03 21:45:20');
INSERT INTO `mensajes_respuestas` VALUES ('50', '1', '1', '2', 'para hoy', '2017-01-03 21:45:25');
INSERT INTO `mensajes_respuestas` VALUES ('51', '1', '1', '2', 'XDDD', '2017-01-03 21:45:32');
INSERT INTO `mensajes_respuestas` VALUES ('52', '1', '1', '2', 'nos vemos', '2017-01-03 21:45:36');
INSERT INTO `mensajes_respuestas` VALUES ('53', '1', '1', '2', 'no se vaya', '2017-01-03 21:45:43');
INSERT INTO `mensajes_respuestas` VALUES ('54', '1', '1', '2', 'XDDDD', '2017-01-03 21:46:07');

-- ----------------------------
-- Table structure for metodos_accesos
-- ----------------------------
DROP TABLE IF EXISTS `metodos_accesos`;
CREATE TABLE `metodos_accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of metodos_accesos
-- ----------------------------
INSERT INTO `metodos_accesos` VALUES ('1', 'Web');
INSERT INTO `metodos_accesos` VALUES ('2', 'Facebook');

-- ----------------------------
-- Table structure for nivel_estudio
-- ----------------------------
DROP TABLE IF EXISTS `nivel_estudio`;
CREATE TABLE `nivel_estudio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nivel_estudio
-- ----------------------------
INSERT INTO `nivel_estudio` VALUES ('1', 'Secundario');
INSERT INTO `nivel_estudio` VALUES ('2', 'Terciario');
INSERT INTO `nivel_estudio` VALUES ('3', 'Universitario');
INSERT INTO `nivel_estudio` VALUES ('4', 'Posgrado');
INSERT INTO `nivel_estudio` VALUES ('5', 'Master');
INSERT INTO `nivel_estudio` VALUES ('6', 'Doctorado');
INSERT INTO `nivel_estudio` VALUES ('7', 'Otro');

-- ----------------------------
-- Table structure for nivel_idioma
-- ----------------------------
DROP TABLE IF EXISTS `nivel_idioma`;
CREATE TABLE `nivel_idioma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nivel_idioma
-- ----------------------------
INSERT INTO `nivel_idioma` VALUES ('1', 'Básico');
INSERT INTO `nivel_idioma` VALUES ('2', 'Intermedio');
INSERT INTO `nivel_idioma` VALUES ('3', 'Avanzado');
INSERT INTO `nivel_idioma` VALUES ('4', 'Nativo');

-- ----------------------------
-- Table structure for noticias
-- ----------------------------
DROP TABLE IF EXISTS `noticias`;
CREATE TABLE `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_imagen` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `amigable` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `veces_leido` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of noticias
-- ----------------------------
INSERT INTO `noticias` VALUES ('1', '29', '0', 'mis favoritos3', 'mis-favoritos3', '<p>lo que sea2 :D</p>', '2017-02-10 10:12:40', '2017-02-10 10:12:40', '7');

-- ----------------------------
-- Table structure for paises
-- ----------------------------
DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL DEFAULT '',
  `moneda` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=251 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paises
-- ----------------------------
INSERT INTO `paises` VALUES ('1', 'Andorra', 'EUR');
INSERT INTO `paises` VALUES ('2', 'United Arab Emirates', 'AED');
INSERT INTO `paises` VALUES ('3', 'Afghanistan', 'AFN');
INSERT INTO `paises` VALUES ('4', 'Antigua and Barbuda', 'XCD');
INSERT INTO `paises` VALUES ('5', 'Anguilla', 'XCD');
INSERT INTO `paises` VALUES ('6', 'Albania', 'ALL');
INSERT INTO `paises` VALUES ('7', 'Armenia', 'AMD');
INSERT INTO `paises` VALUES ('8', 'Angola', 'AOA');
INSERT INTO `paises` VALUES ('10', 'Argentina', 'ARS');
INSERT INTO `paises` VALUES ('11', 'American Samoa', 'USD');
INSERT INTO `paises` VALUES ('12', 'Austria', 'EUR');
INSERT INTO `paises` VALUES ('13', 'Australia', 'AUD');
INSERT INTO `paises` VALUES ('14', 'Aruba', 'AWG');
INSERT INTO `paises` VALUES ('15', 'Åland', 'EUR');
INSERT INTO `paises` VALUES ('16', 'Azerbaijan', 'AZN');
INSERT INTO `paises` VALUES ('17', 'Bosnia and Herzegovina', 'BAM');
INSERT INTO `paises` VALUES ('18', 'Barbados', 'BBD');
INSERT INTO `paises` VALUES ('19', 'Bangladesh', 'BDT');
INSERT INTO `paises` VALUES ('20', 'Belgium', 'EUR');
INSERT INTO `paises` VALUES ('21', 'Burkina Faso', 'XOF');
INSERT INTO `paises` VALUES ('22', 'Bulgaria', 'BGN');
INSERT INTO `paises` VALUES ('23', 'Bahrain', 'BHD');
INSERT INTO `paises` VALUES ('24', 'Burundi', 'BIF');
INSERT INTO `paises` VALUES ('25', 'Benin', 'XOF');
INSERT INTO `paises` VALUES ('26', 'Saint Barthélemy', 'EUR');
INSERT INTO `paises` VALUES ('27', 'Bermuda', 'BMD');
INSERT INTO `paises` VALUES ('28', 'Brunei', 'BND');
INSERT INTO `paises` VALUES ('29', 'Bolivia', 'BOB');
INSERT INTO `paises` VALUES ('30', 'Bonaire', 'USD');
INSERT INTO `paises` VALUES ('31', 'Brazil', 'BRL');
INSERT INTO `paises` VALUES ('32', 'Bahamas', 'BSD');
INSERT INTO `paises` VALUES ('33', 'Bhutan', 'BTN');
INSERT INTO `paises` VALUES ('34', 'Bouvet Island', 'NOK');
INSERT INTO `paises` VALUES ('35', 'Botswana', 'BWP');
INSERT INTO `paises` VALUES ('36', 'Belarus', 'BYR');
INSERT INTO `paises` VALUES ('37', 'Belize', 'BZD');
INSERT INTO `paises` VALUES ('38', 'Canada', 'CAD');
INSERT INTO `paises` VALUES ('39', 'Cocos [Keeling] Islands', 'AUD');
INSERT INTO `paises` VALUES ('40', 'Democratic Republic of the Congo', 'CDF');
INSERT INTO `paises` VALUES ('41', 'Central African Republic', 'XAF');
INSERT INTO `paises` VALUES ('42', 'Republic of the Congo', 'XAF');
INSERT INTO `paises` VALUES ('43', 'Switzerland', 'CHF');
INSERT INTO `paises` VALUES ('44', 'Ivory Coast', 'XOF');
INSERT INTO `paises` VALUES ('45', 'Cook Islands', 'NZD');
INSERT INTO `paises` VALUES ('46', 'Chile', 'CLP');
INSERT INTO `paises` VALUES ('47', 'Cameroon', 'XAF');
INSERT INTO `paises` VALUES ('48', 'China', 'CNY');
INSERT INTO `paises` VALUES ('49', 'Colombia', 'COP');
INSERT INTO `paises` VALUES ('50', 'Costa Rica', 'CRC');
INSERT INTO `paises` VALUES ('51', 'Cuba', 'CUP');
INSERT INTO `paises` VALUES ('52', 'Cape Verde', 'CVE');
INSERT INTO `paises` VALUES ('53', 'Curacao', 'ANG');
INSERT INTO `paises` VALUES ('54', 'Christmas Island', 'AUD');
INSERT INTO `paises` VALUES ('55', 'Cyprus', 'EUR');
INSERT INTO `paises` VALUES ('56', 'Czechia', 'CZK');
INSERT INTO `paises` VALUES ('57', 'Germany', 'EUR');
INSERT INTO `paises` VALUES ('58', 'Djibouti', 'DJF');
INSERT INTO `paises` VALUES ('59', 'Denmark', 'DKK');
INSERT INTO `paises` VALUES ('60', 'Dominica', 'XCD');
INSERT INTO `paises` VALUES ('61', 'Dominican Republic', 'DOP');
INSERT INTO `paises` VALUES ('62', 'Algeria', 'DZD');
INSERT INTO `paises` VALUES ('63', 'Ecuador', 'USD');
INSERT INTO `paises` VALUES ('64', 'Estonia', 'EUR');
INSERT INTO `paises` VALUES ('65', 'Egypt', 'EGP');
INSERT INTO `paises` VALUES ('66', 'Western Sahara', 'MAD');
INSERT INTO `paises` VALUES ('67', 'Eritrea', 'ERN');
INSERT INTO `paises` VALUES ('68', 'Spain', 'EUR');
INSERT INTO `paises` VALUES ('69', 'Ethiopia', 'ETB');
INSERT INTO `paises` VALUES ('70', 'Finland', 'EUR');
INSERT INTO `paises` VALUES ('71', 'Fiji', 'FJD');
INSERT INTO `paises` VALUES ('72', 'Falkland Islands', 'FKP');
INSERT INTO `paises` VALUES ('73', 'Micronesia', 'USD');
INSERT INTO `paises` VALUES ('74', 'Faroe Islands', 'DKK');
INSERT INTO `paises` VALUES ('75', 'France', 'EUR');
INSERT INTO `paises` VALUES ('76', 'Gabon', 'XAF');
INSERT INTO `paises` VALUES ('77', 'United Kingdom', 'GBP');
INSERT INTO `paises` VALUES ('78', 'Grenada', 'XCD');
INSERT INTO `paises` VALUES ('79', 'Georgia', 'GEL');
INSERT INTO `paises` VALUES ('80', 'French Guiana', 'EUR');
INSERT INTO `paises` VALUES ('81', 'Guernsey', 'GBP');
INSERT INTO `paises` VALUES ('82', 'Ghana', 'GHS');
INSERT INTO `paises` VALUES ('83', 'Gibraltar', 'GIP');
INSERT INTO `paises` VALUES ('84', 'Greenland', 'DKK');
INSERT INTO `paises` VALUES ('85', 'Gambia', 'GMD');
INSERT INTO `paises` VALUES ('86', 'Guinea', 'GNF');
INSERT INTO `paises` VALUES ('87', 'Guadeloupe', 'EUR');
INSERT INTO `paises` VALUES ('88', 'Equatorial Guinea', 'XAF');
INSERT INTO `paises` VALUES ('89', 'Greece', 'EUR');
INSERT INTO `paises` VALUES ('90', 'South Georgia and the South Sandwich Islands', 'GBP');
INSERT INTO `paises` VALUES ('91', 'Guatemala', 'GTQ');
INSERT INTO `paises` VALUES ('92', 'Guam', 'USD');
INSERT INTO `paises` VALUES ('93', 'Guinea-Bissau', 'XOF');
INSERT INTO `paises` VALUES ('94', 'Guyana', 'GYD');
INSERT INTO `paises` VALUES ('95', 'Hong Kong', 'HKD');
INSERT INTO `paises` VALUES ('96', 'Heard Island and McDonald Islands', 'AUD');
INSERT INTO `paises` VALUES ('97', 'Honduras', 'HNL');
INSERT INTO `paises` VALUES ('98', 'Croatia', 'HRK');
INSERT INTO `paises` VALUES ('99', 'Haiti', 'HTG');
INSERT INTO `paises` VALUES ('100', 'Hungary', 'HUF');
INSERT INTO `paises` VALUES ('101', 'Indonesia', 'IDR');
INSERT INTO `paises` VALUES ('102', 'Ireland', 'EUR');
INSERT INTO `paises` VALUES ('103', 'Israel', 'ILS');
INSERT INTO `paises` VALUES ('104', 'Isle of Man', 'GBP');
INSERT INTO `paises` VALUES ('105', 'India', 'INR');
INSERT INTO `paises` VALUES ('106', 'British Indian Ocean Territory', 'USD');
INSERT INTO `paises` VALUES ('107', 'Iraq', 'IQD');
INSERT INTO `paises` VALUES ('108', 'Iran', 'IRR');
INSERT INTO `paises` VALUES ('109', 'Iceland', 'ISK');
INSERT INTO `paises` VALUES ('110', 'Italy', 'EUR');
INSERT INTO `paises` VALUES ('111', 'Jersey', 'GBP');
INSERT INTO `paises` VALUES ('112', 'Jamaica', 'JMD');
INSERT INTO `paises` VALUES ('113', 'Jordan', 'JOD');
INSERT INTO `paises` VALUES ('114', 'Japan', 'JPY');
INSERT INTO `paises` VALUES ('115', 'Kenya', 'KES');
INSERT INTO `paises` VALUES ('116', 'Kyrgyzstan', 'KGS');
INSERT INTO `paises` VALUES ('117', 'Cambodia', 'KHR');
INSERT INTO `paises` VALUES ('118', 'Kiribati', 'AUD');
INSERT INTO `paises` VALUES ('119', 'Comoros', 'KMF');
INSERT INTO `paises` VALUES ('120', 'Saint Kitts and Nevis', 'XCD');
INSERT INTO `paises` VALUES ('121', 'North Korea', 'KPW');
INSERT INTO `paises` VALUES ('122', 'South Korea', 'KRW');
INSERT INTO `paises` VALUES ('123', 'Kuwait', 'KWD');
INSERT INTO `paises` VALUES ('124', 'Cayman Islands', 'KYD');
INSERT INTO `paises` VALUES ('125', 'Kazakhstan', 'KZT');
INSERT INTO `paises` VALUES ('126', 'Laos', 'LAK');
INSERT INTO `paises` VALUES ('127', 'Lebanon', 'LBP');
INSERT INTO `paises` VALUES ('128', 'Saint Lucia', 'XCD');
INSERT INTO `paises` VALUES ('129', 'Liechtenstein', 'CHF');
INSERT INTO `paises` VALUES ('130', 'Sri Lanka', 'LKR');
INSERT INTO `paises` VALUES ('131', 'Liberia', 'LRD');
INSERT INTO `paises` VALUES ('132', 'Lesotho', 'LSL');
INSERT INTO `paises` VALUES ('133', 'Lithuania', 'EUR');
INSERT INTO `paises` VALUES ('134', 'Luxembourg', 'EUR');
INSERT INTO `paises` VALUES ('135', 'Latvia', 'EUR');
INSERT INTO `paises` VALUES ('136', 'Libya', 'LYD');
INSERT INTO `paises` VALUES ('137', 'Morocco', 'MAD');
INSERT INTO `paises` VALUES ('138', 'Monaco', 'EUR');
INSERT INTO `paises` VALUES ('139', 'Moldova', 'MDL');
INSERT INTO `paises` VALUES ('140', 'Montenegro', 'EUR');
INSERT INTO `paises` VALUES ('141', 'Saint Martin', 'EUR');
INSERT INTO `paises` VALUES ('142', 'Madagascar', 'MGA');
INSERT INTO `paises` VALUES ('143', 'Marshall Islands', 'USD');
INSERT INTO `paises` VALUES ('144', 'Macedonia', 'MKD');
INSERT INTO `paises` VALUES ('145', 'Mali', 'XOF');
INSERT INTO `paises` VALUES ('146', 'Myanmar [Burma]', 'MMK');
INSERT INTO `paises` VALUES ('147', 'Mongolia', 'MNT');
INSERT INTO `paises` VALUES ('148', 'Macao', 'MOP');
INSERT INTO `paises` VALUES ('149', 'Northern Mariana Islands', 'USD');
INSERT INTO `paises` VALUES ('150', 'Martinique', 'EUR');
INSERT INTO `paises` VALUES ('151', 'Mauritania', 'MRO');
INSERT INTO `paises` VALUES ('152', 'Montserrat', 'XCD');
INSERT INTO `paises` VALUES ('153', 'Malta', 'EUR');
INSERT INTO `paises` VALUES ('154', 'Mauritius', 'MUR');
INSERT INTO `paises` VALUES ('155', 'Maldives', 'MVR');
INSERT INTO `paises` VALUES ('156', 'Malawi', 'MWK');
INSERT INTO `paises` VALUES ('157', 'Mexico', 'MXN');
INSERT INTO `paises` VALUES ('158', 'Malaysia', 'MYR');
INSERT INTO `paises` VALUES ('159', 'Mozambique', 'MZN');
INSERT INTO `paises` VALUES ('160', 'Namibia', 'NAD');
INSERT INTO `paises` VALUES ('161', 'New Caledonia', 'XPF');
INSERT INTO `paises` VALUES ('162', 'Niger', 'XOF');
INSERT INTO `paises` VALUES ('163', 'Norfolk Island', 'AUD');
INSERT INTO `paises` VALUES ('164', 'Nigeria', 'NGN');
INSERT INTO `paises` VALUES ('165', 'Nicaragua', 'NIO');
INSERT INTO `paises` VALUES ('166', 'Netherlands', 'EUR');
INSERT INTO `paises` VALUES ('167', 'Norway', 'NOK');
INSERT INTO `paises` VALUES ('168', 'Nepal', 'NPR');
INSERT INTO `paises` VALUES ('169', 'Nauru', 'AUD');
INSERT INTO `paises` VALUES ('170', 'Niue', 'NZD');
INSERT INTO `paises` VALUES ('171', 'New Zealand', 'NZD');
INSERT INTO `paises` VALUES ('172', 'Oman', 'OMR');
INSERT INTO `paises` VALUES ('173', 'Panama', 'PAB');
INSERT INTO `paises` VALUES ('174', 'Peru', 'PEN');
INSERT INTO `paises` VALUES ('175', 'French Polynesia', 'XPF');
INSERT INTO `paises` VALUES ('176', 'Papua New Guinea', 'PGK');
INSERT INTO `paises` VALUES ('177', 'Philippines', 'PHP');
INSERT INTO `paises` VALUES ('178', 'Pakistan', 'PKR');
INSERT INTO `paises` VALUES ('179', 'Poland', 'PLN');
INSERT INTO `paises` VALUES ('180', 'Saint Pierre and Miquelon', 'EUR');
INSERT INTO `paises` VALUES ('181', 'Pitcairn Islands', 'NZD');
INSERT INTO `paises` VALUES ('182', 'Puerto Rico', 'USD');
INSERT INTO `paises` VALUES ('183', 'Palestine', 'ILS');
INSERT INTO `paises` VALUES ('184', 'Portugal', 'EUR');
INSERT INTO `paises` VALUES ('185', 'Palau', 'USD');
INSERT INTO `paises` VALUES ('186', 'Paraguay', 'PYG');
INSERT INTO `paises` VALUES ('187', 'Qatar', 'QAR');
INSERT INTO `paises` VALUES ('188', 'Réunion', 'EUR');
INSERT INTO `paises` VALUES ('189', 'Romania', 'RON');
INSERT INTO `paises` VALUES ('190', 'Serbia', 'RSD');
INSERT INTO `paises` VALUES ('191', 'Russia', 'RUB');
INSERT INTO `paises` VALUES ('192', 'Rwanda', 'RWF');
INSERT INTO `paises` VALUES ('193', 'Saudi Arabia', 'SAR');
INSERT INTO `paises` VALUES ('194', 'Solomon Islands', 'SBD');
INSERT INTO `paises` VALUES ('195', 'Seychelles', 'SCR');
INSERT INTO `paises` VALUES ('196', 'Sudan', 'SDG');
INSERT INTO `paises` VALUES ('197', 'Sweden', 'SEK');
INSERT INTO `paises` VALUES ('198', 'Singapore', 'SGD');
INSERT INTO `paises` VALUES ('199', 'Saint Helena', 'SHP');
INSERT INTO `paises` VALUES ('200', 'Slovenia', 'EUR');
INSERT INTO `paises` VALUES ('201', 'Svalbard and Jan Mayen', 'NOK');
INSERT INTO `paises` VALUES ('202', 'Slovakia', 'EUR');
INSERT INTO `paises` VALUES ('203', 'Sierra Leone', 'SLL');
INSERT INTO `paises` VALUES ('204', 'San Marino', 'EUR');
INSERT INTO `paises` VALUES ('205', 'Senegal', 'XOF');
INSERT INTO `paises` VALUES ('206', 'Somalia', 'SOS');
INSERT INTO `paises` VALUES ('207', 'Suriname', 'SRD');
INSERT INTO `paises` VALUES ('208', 'South Sudan', 'SSP');
INSERT INTO `paises` VALUES ('209', 'São Tomé and Príncipe', 'STD');
INSERT INTO `paises` VALUES ('210', 'El Salvador', 'USD');
INSERT INTO `paises` VALUES ('211', 'Sint Maarten', 'ANG');
INSERT INTO `paises` VALUES ('212', 'Syria', 'SYP');
INSERT INTO `paises` VALUES ('213', 'Swaziland', 'SZL');
INSERT INTO `paises` VALUES ('214', 'Turks and Caicos Islands', 'USD');
INSERT INTO `paises` VALUES ('215', 'Chad', 'XAF');
INSERT INTO `paises` VALUES ('216', 'French Southern Territories', 'EUR');
INSERT INTO `paises` VALUES ('217', 'Togo', 'XOF');
INSERT INTO `paises` VALUES ('218', 'Thailand', 'THB');
INSERT INTO `paises` VALUES ('219', 'Tajikistan', 'TJS');
INSERT INTO `paises` VALUES ('220', 'Tokelau', 'NZD');
INSERT INTO `paises` VALUES ('221', 'East Timor', 'USD');
INSERT INTO `paises` VALUES ('222', 'Turkmenistan', 'TMT');
INSERT INTO `paises` VALUES ('223', 'Tunisia', 'TND');
INSERT INTO `paises` VALUES ('224', 'Tonga', 'TOP');
INSERT INTO `paises` VALUES ('225', 'Turkey', 'TRY');
INSERT INTO `paises` VALUES ('226', 'Trinidad and Tobago', 'TTD');
INSERT INTO `paises` VALUES ('227', 'Tuvalu', 'AUD');
INSERT INTO `paises` VALUES ('228', 'Taiwan', 'TWD');
INSERT INTO `paises` VALUES ('229', 'Tanzania', 'TZS');
INSERT INTO `paises` VALUES ('230', 'Ukraine', 'UAH');
INSERT INTO `paises` VALUES ('231', 'Uganda', 'UGX');
INSERT INTO `paises` VALUES ('232', 'U.S. Minor Outlying Islands', 'USD');
INSERT INTO `paises` VALUES ('233', 'United States', 'USD');
INSERT INTO `paises` VALUES ('234', 'Uruguay', 'UYU');
INSERT INTO `paises` VALUES ('235', 'Uzbekistan', 'UZS');
INSERT INTO `paises` VALUES ('236', 'Vatican City', 'EUR');
INSERT INTO `paises` VALUES ('237', 'Saint Vincent and the Grenadines', 'XCD');
INSERT INTO `paises` VALUES ('238', 'Venezuela', 'VEF');
INSERT INTO `paises` VALUES ('239', 'British Virgin Islands', 'USD');
INSERT INTO `paises` VALUES ('240', 'U.S. Virgin Islands', 'USD');
INSERT INTO `paises` VALUES ('241', 'Vietnam', 'VND');
INSERT INTO `paises` VALUES ('242', 'Vanuatu', 'VUV');
INSERT INTO `paises` VALUES ('243', 'Wallis and Futuna', 'XPF');
INSERT INTO `paises` VALUES ('244', 'Samoa', 'WST');
INSERT INTO `paises` VALUES ('245', 'Kosovo', 'EUR');
INSERT INTO `paises` VALUES ('246', 'Yemen', 'YER');
INSERT INTO `paises` VALUES ('247', 'Mayotte', 'EUR');
INSERT INTO `paises` VALUES ('248', 'South Africa', 'ZAR');
INSERT INTO `paises` VALUES ('249', 'Zambia', 'ZMW');
INSERT INTO `paises` VALUES ('250', 'Zimbabwe', 'ZWL');

-- ----------------------------
-- Table structure for paquetes_error
-- ----------------------------
DROP TABLE IF EXISTS `paquetes_error`;
CREATE TABLE `paquetes_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime DEFAULT NULL,
  `contenido` text,
  `error` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paquetes_error
-- ----------------------------

-- ----------------------------
-- Table structure for planes
-- ----------------------------
DROP TABLE IF EXISTS `planes`;
CREATE TABLE `planes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(16) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `moneda` varchar(8) DEFAULT NULL,
  `logo_home` tinyint(1) DEFAULT NULL,
  `link_empresa` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of planes
-- ----------------------------
INSERT INTO `planes` VALUES ('1', 'Gratis', '0', 'USD', '0', '0');
INSERT INTO `planes` VALUES ('2', 'Bronce', '1120.5', 'USD', '1', '0');
INSERT INTO `planes` VALUES ('3', 'Plata', '2739', 'USD', '2', '1');
INSERT INTO `planes` VALUES ('4', 'Oro', '5602.5', 'USD', '3', '1');

-- ----------------------------
-- Table structure for plataforma
-- ----------------------------
DROP TABLE IF EXISTS `plataforma`;
CREATE TABLE `plataforma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nosotros` text,
  `correo_contacto` varchar(255) DEFAULT NULL,
  `politicas` text,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plataforma
-- ----------------------------
INSERT INTO `plataforma` VALUES ('1', 'Aqui va todo el texto de la empresa', 'correo@empresa.com', 'Aqui van las politicas ', null, null, null, null, null);

-- ----------------------------
-- Table structure for postulaciones
-- ----------------------------
DROP TABLE IF EXISTS `postulaciones`;
CREATE TABLE `postulaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_publicacion` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of postulaciones
-- ----------------------------
INSERT INTO `postulaciones` VALUES ('5', '1333', '1', '2017-01-06 16:10:05');
INSERT INTO `postulaciones` VALUES ('6', '1305', '1', '2017-01-06 17:16:10');
INSERT INTO `postulaciones` VALUES ('7', '1289', '1', '2017-01-08 15:56:27');
INSERT INTO `postulaciones` VALUES ('8', '1370', '2', '2017-01-10 12:25:56');

-- ----------------------------
-- Table structure for provincias
-- ----------------------------
DROP TABLE IF EXISTS `provincias`;
CREATE TABLE `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of provincias
-- ----------------------------

-- ----------------------------
-- Table structure for provincias_localidades
-- ----------------------------
DROP TABLE IF EXISTS `provincias_localidades`;
CREATE TABLE `provincias_localidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_provincia` int(11) DEFAULT NULL,
  `id_localidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of provincias_localidades
-- ----------------------------

-- ----------------------------
-- Table structure for publicaciones
-- ----------------------------
DROP TABLE IF EXISTS `publicaciones`;
CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `titulo` varchar(68) DEFAULT NULL,
  `descripcion` text,
  `amigable` varchar(48) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `coordenadas` varchar(255) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1392 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publicaciones
-- ----------------------------
INSERT INTO `publicaciones` VALUES ('1288', '1', 'Analista de Impuestos', '<div class=\"row text-regular\" style=\"margin-left: 10px; margin-right: 10px;\">\n<p>El Analista Fiscal estar&aacute; a cargo de preparar las respuestas a los requerimientos de los inspectores nacionales provinciales y municipales, an&aacute;lisis de cuentas y apoyo en el impuesto sobre la renta y el acuerdo multilateral. Adem&aacute;s, el analista fiscal estar&aacute; a cargo de la liquidaci&oacute;n de SICORE de impuestos nacionales IVA. Para esta funci&oacute;n, las necesidades de los candidatos necesitan un trabajo en equipo y autonom&iacute;a<br /><br /></p>\n<p>Requerimientos:</p>\n<p>&nbsp; &bull; Asistir a los &uacute;ltimos semestres, o reci&eacute;n graduado de: Econom&iacute;a, Contabilidad<br />&nbsp; &bull; Experiencia de manejo de Impuestos Nacionales y contabilidad<br />&nbsp; &bull; Ingl&eacute;s en un nivel intermedio (Intermedio / Intermedio Alto)&nbsp;<br />&nbsp; &bull;Conocimiento de procesos y sistemas relacionados con impuestos.&nbsp;(SIAP)&nbsp;<br />&nbsp; &bull; Excelentes habilidades de comunicaci&oacute;n&nbsp;<br />&nbsp; &bull; Capacidad de trabajo en equipo&nbsp;<br />&nbsp; &bull; Capacidad de an&aacute;lisis</p>\n</div>', 'analista-de-impuestos', '2016-12-07 05:47:37', '2016-12-14 08:45:59', null, null);
INSERT INTO `publicaciones` VALUES ('1289', '1', 'Analista de Atención al Cliente (Contrato por Plazo Fijo 6 meses)', '<div class=\"row text-regular\" style=\"margin-left: 10px; margin-right: 10px;\">\n<p>Desde hace m&aacute;s de 130 a&ntilde;os, en Avon nos pronunciamos a favor de la belleza, la innovaci&oacute;n, el optimismo y, por sobre todo, en favor del desarrollo y empoderamiento de LA MUJER.&nbsp;</p>\n<p>En Cosm&eacute;ticos Avon&nbsp;nos encuentramos en la b&uacute;squeda de Analistas de Atenci&oacute;n al Cliente.<br /> <br /> Ser&aacute;s parte de equipos din&aacute;micos, flexibles, donde podr&aacute;s brindar atenci&oacute;n telef&oacute;nica a diferentes consultas realizadas, en constante contacto con la fuerza de Ventas y las distintas &aacute;reas de la compa&ntilde;&iacute;a.<br /> <br /> Buscamos que:<br /> <br /> &bull; Tengas experiencia previa en posiciones similares como atenci&oacute;n telef&oacute;nica de clientes o en forma personalizada: An&aacute;lisis de situaciones / Seguimiento de reclamos / Resoluci&oacute;n de consultas.<br /> <br /> &bull; La predisposici&oacute;n al trabajo en equipo, vocaci&oacute;n de servicio, excelentes relaciones interpersonales y el compromiso con el trabajo, sean competencias en las cuales te destaques.<br /> <br /> Te ofrecemos:<br /> <br /> &bull; Proyectos altamente desafiantes, crecimiento profesional, excelente clima laboral y&nbsp;capacitaci&oacute;n.</p>\n<p>&bull; Contrataci&oacute;n directa a plazo fijo por 6 meses, remuneraci&oacute;n acorde e importantes beneficios.</p>\n</div>', 'analista-de-atencion-al-cliente-contrato-por-pla', '2016-12-04 22:35:13', '2017-03-01 21:50:57', '10.090017240548,-72.509765625', null);
INSERT INTO `publicaciones` VALUES ('1290', '1', 'Publicación 3', 'Descripción 3', 'descripcion-3', '2016-12-09 02:34:02', '2016-11-24 05:20:18', null, null);
INSERT INTO `publicaciones` VALUES ('1291', '1', 'Publicación 4', 'Descripción 4', 'descripcion-4', '2016-11-21 22:04:45', '2016-12-07 10:10:09', null, null);
INSERT INTO `publicaciones` VALUES ('1292', '1', 'Publicación 5', 'Descripción 5', 'descripcion-5', '2016-11-21 12:01:57', '2016-11-03 23:04:31', null, null);
INSERT INTO `publicaciones` VALUES ('1293', '1', 'Publicación 6', 'Descripción 6', 'descripcion-6', '2016-11-03 20:15:35', '2016-11-22 07:41:19', null, null);
INSERT INTO `publicaciones` VALUES ('1294', '1', 'Publicación 7', 'Descripción 7', 'descripcion-7', '2016-11-21 17:08:24', '2016-11-29 16:35:39', null, null);
INSERT INTO `publicaciones` VALUES ('1295', '1', 'Publicación 8', 'Descripción 8', 'descripcion-8', '2016-11-20 20:07:35', '2016-11-06 15:26:34', null, null);
INSERT INTO `publicaciones` VALUES ('1296', '1', 'Publicación 9', 'Descripción 9', 'descripcion-9', '2016-12-04 10:41:09', '2016-11-28 20:53:28', null, null);
INSERT INTO `publicaciones` VALUES ('1297', '1', 'Publicación 10', 'Descripción 10', 'descripcion-10', '2016-12-04 01:52:30', '2016-11-07 03:49:28', null, null);
INSERT INTO `publicaciones` VALUES ('1298', '1', 'Publicación 11', 'Descripción 11', 'descripcion-11', '2016-11-24 18:11:47', '2016-11-16 05:33:41', null, null);
INSERT INTO `publicaciones` VALUES ('1299', '1', 'Publicación 12', 'Descripción 12', 'descripcion-12', '2016-12-03 08:22:18', '2016-11-02 03:12:56', null, null);
INSERT INTO `publicaciones` VALUES ('1300', '1', 'Publicación 13', 'Descripción 13', 'descripcion-13', '2016-12-02 20:42:07', '2016-11-09 10:25:06', null, null);
INSERT INTO `publicaciones` VALUES ('1301', '1', 'Publicación 14', 'Descripción 14', 'descripcion-14', '2016-11-27 05:20:07', '2016-11-30 16:17:40', null, null);
INSERT INTO `publicaciones` VALUES ('1302', '1', 'Publicación 15', 'Descripción 15', 'descripcion-15', '2016-11-23 22:51:40', '2016-12-01 10:42:45', null, null);
INSERT INTO `publicaciones` VALUES ('1303', '1', 'Publicación 16', 'Descripción 16', 'descripcion-16', '2016-11-26 00:22:51', '2016-11-15 16:10:23', null, null);
INSERT INTO `publicaciones` VALUES ('1304', '1', 'Publicación 17', 'Descripción 17', 'descripcion-17', '2016-11-18 22:30:37', '2016-12-02 18:24:24', null, null);
INSERT INTO `publicaciones` VALUES ('1305', '1', 'Publicación 18', 'Descripción 18', 'descripcion-18', '2016-11-20 14:14:00', '2016-12-02 23:17:14', null, null);
INSERT INTO `publicaciones` VALUES ('1306', '1', 'Publicación 19', 'Descripción 19', 'descripcion-19', '2016-12-10 08:33:56', '2016-11-08 14:15:22', null, null);
INSERT INTO `publicaciones` VALUES ('1307', '1', 'Publicación 20', 'Descripción 20', 'descripcion-20', '2016-11-21 13:29:13', '2016-11-28 23:44:18', null, null);
INSERT INTO `publicaciones` VALUES ('1308', '1', 'Publicación 21', 'Descripción 21', 'descripcion-21', '2016-11-06 04:26:04', '2016-11-30 02:18:39', null, null);
INSERT INTO `publicaciones` VALUES ('1309', '1', 'Publicación 22', 'Descripción 22', 'descripcion-22', '2016-11-01 11:49:29', '2016-11-01 00:26:01', null, null);
INSERT INTO `publicaciones` VALUES ('1310', '1', 'Publicación 23', 'Descripción 23', 'descripcion-23', '2016-11-17 01:33:45', '2016-12-03 17:30:25', null, null);
INSERT INTO `publicaciones` VALUES ('1311', '1', 'Publicación 24', 'Descripción 24', 'descripcion-24', '2016-11-16 09:21:53', '2016-11-13 10:27:53', null, null);
INSERT INTO `publicaciones` VALUES ('1312', '1', 'Publicación 25', 'Descripción 25', 'descripcion-25', '2016-11-04 05:16:11', '2016-11-09 18:47:24', null, null);
INSERT INTO `publicaciones` VALUES ('1313', '1', 'Publicación 26', 'Descripción 26', 'descripcion-26', '2016-11-27 05:44:11', '2016-11-13 20:19:46', null, null);
INSERT INTO `publicaciones` VALUES ('1314', '1', 'Publicación 27', 'Descripción 27', 'descripcion-27', '2016-11-06 23:25:21', '2016-11-26 08:16:28', null, null);
INSERT INTO `publicaciones` VALUES ('1315', '1', 'Publicación 28', 'Descripción 28', 'descripcion-28', '2016-11-30 17:19:25', '2016-11-17 20:20:43', null, null);
INSERT INTO `publicaciones` VALUES ('1316', '1', 'Publicación 29', 'Descripción 29', 'descripcion-29', '2016-11-09 06:23:07', '2016-11-10 01:16:22', null, null);
INSERT INTO `publicaciones` VALUES ('1317', '1', 'Publicación 30', 'Descripción 30', 'descripcion-30', '2016-11-28 09:05:37', '2016-11-18 08:22:45', null, null);
INSERT INTO `publicaciones` VALUES ('1318', '1', 'Publicación 31', 'Descripción 31', 'descripcion-31', '2016-11-16 00:17:27', '2016-12-02 00:50:46', null, null);
INSERT INTO `publicaciones` VALUES ('1319', '1', 'Publicación 32', 'Descripción 32', 'descripcion-32', '2016-11-02 06:13:06', '2016-11-12 05:49:21', null, null);
INSERT INTO `publicaciones` VALUES ('1320', '1', 'Publicación 33', 'Descripción 33', 'descripcion-33', '2016-12-06 08:33:02', '2016-11-21 09:34:16', null, null);
INSERT INTO `publicaciones` VALUES ('1321', '1', 'Publicación 34', 'Descripción 34', 'descripcion-34', '2016-11-24 21:07:01', '2016-12-04 22:43:24', null, null);
INSERT INTO `publicaciones` VALUES ('1322', '1', 'Publicación 35', 'Descripción 35', 'descripcion-35', '2016-11-22 09:02:06', '2016-12-12 00:58:12', null, null);
INSERT INTO `publicaciones` VALUES ('1323', '1', 'Publicación 36', 'Descripción 36', 'descripcion-36', '2016-11-30 20:13:24', '2016-11-24 23:12:08', null, null);
INSERT INTO `publicaciones` VALUES ('1324', '1', 'Publicación 37', 'Descripción 37', 'descripcion-37', '2016-11-29 23:45:19', '2016-11-30 06:28:34', null, null);
INSERT INTO `publicaciones` VALUES ('1325', '1', 'Publicación 38', 'Descripción 38', 'descripcion-38', '2016-11-09 12:30:16', '2016-12-07 03:47:37', null, null);
INSERT INTO `publicaciones` VALUES ('1326', '1', 'Publicación 39', 'Descripción 39', 'descripcion-39', '2016-11-18 16:06:32', '2016-11-17 05:37:12', null, null);
INSERT INTO `publicaciones` VALUES ('1327', '1', 'Publicación 40', 'Descripción 40', 'descripcion-40', '2016-11-13 10:54:24', '2016-11-05 18:07:02', null, null);
INSERT INTO `publicaciones` VALUES ('1328', '1', 'Publicación 41', 'Descripción 41', 'descripcion-41', '2016-11-15 13:17:05', '2016-11-25 20:29:30', null, null);
INSERT INTO `publicaciones` VALUES ('1329', '1', 'Publicación 42', 'Descripción 42', 'descripcion-42', '2016-11-12 03:17:11', '2016-11-15 03:09:13', null, null);
INSERT INTO `publicaciones` VALUES ('1330', '1', 'Publicación 43', 'Descripción 43', 'descripcion-43', '2016-11-24 13:01:27', '2016-12-05 01:29:50', null, null);
INSERT INTO `publicaciones` VALUES ('1331', '1', 'Publicación 44', 'Descripción 44', 'descripcion-44', '2016-11-20 03:30:04', '2016-11-16 02:20:25', null, null);
INSERT INTO `publicaciones` VALUES ('1332', '1', 'Publicación 45', 'Descripción 45', 'descripcion-45', '2016-11-20 13:44:57', '2016-11-28 10:24:38', null, null);
INSERT INTO `publicaciones` VALUES ('1333', '1', 'Publicación 46', 'Descripción 46', 'descripcion-46', '2016-12-04 04:05:49', '2016-11-13 20:00:22', null, null);
INSERT INTO `publicaciones` VALUES ('1334', '1', 'Publicación 47', 'Descripción 47', 'descripcion-47', '2016-12-04 15:59:34', '2016-12-10 04:23:23', null, null);
INSERT INTO `publicaciones` VALUES ('1335', '1', 'Publicación 48', 'Descripción 48', 'descripcion-48', '2016-11-06 02:49:41', '2016-12-05 09:52:30', null, null);
INSERT INTO `publicaciones` VALUES ('1336', '1', 'Publicación 49', 'Descripción 49', 'descripcion-49', '2016-12-02 10:48:05', '2016-11-21 23:15:45', null, null);
INSERT INTO `publicaciones` VALUES ('1337', '1', 'Publicación 50', 'Descripción 50', 'descripcion-50', '2016-11-07 04:39:31', '2016-11-26 00:58:45', null, null);
INSERT INTO `publicaciones` VALUES ('1338', '1', 'Publicación 51', 'Descripción 51', 'descripcion-51', '2016-11-28 12:05:14', '2016-11-11 08:24:15', null, null);
INSERT INTO `publicaciones` VALUES ('1339', '1', 'Publicación 52', 'Descripción 52', 'descripcion-52', '2016-11-18 22:31:38', '2016-11-21 12:57:12', null, null);
INSERT INTO `publicaciones` VALUES ('1340', '1', 'Publicación 53', 'Descripción 53', 'descripcion-53', '2016-11-25 02:59:24', '2016-11-22 14:13:17', null, null);
INSERT INTO `publicaciones` VALUES ('1341', '1', 'Publicación 54', 'Descripción 54', 'descripcion-54', '2016-11-13 13:51:30', '2016-11-28 12:41:56', null, null);
INSERT INTO `publicaciones` VALUES ('1342', '1', 'Publicación 55', 'Descripción 55', 'descripcion-55', '2016-12-04 03:53:26', '2016-11-08 14:17:56', null, null);
INSERT INTO `publicaciones` VALUES ('1343', '1', 'Publicación 56', 'Descripción 56', 'descripcion-56', '2016-11-20 02:26:43', '2016-11-02 08:26:40', null, null);
INSERT INTO `publicaciones` VALUES ('1344', '1', 'Publicación 57', 'Descripción 57', 'descripcion-57', '2016-12-12 00:42:22', '2016-11-06 10:53:43', null, null);
INSERT INTO `publicaciones` VALUES ('1345', '1', 'Publicación 58', 'Descripción 58', 'descripcion-58', '2016-12-07 15:23:39', '2016-11-07 04:03:34', null, null);
INSERT INTO `publicaciones` VALUES ('1346', '1', 'Publicación 59', 'Descripción 59', 'descripcion-59', '2016-12-03 17:14:24', '2016-11-02 06:05:38', null, null);
INSERT INTO `publicaciones` VALUES ('1347', '1', 'Publicación 60', 'Descripción 60', 'descripcion-60', '2016-11-21 07:18:29', '2016-11-03 13:27:11', null, null);
INSERT INTO `publicaciones` VALUES ('1348', '1', 'Publicación 61', 'Descripción 61', 'descripcion-61', '2016-12-06 13:06:38', '2016-11-08 20:54:12', null, null);
INSERT INTO `publicaciones` VALUES ('1349', '1', 'Publicación 62', 'Descripción 62', 'descripcion-62', '2016-11-14 18:12:05', '2016-12-09 07:37:25', null, null);
INSERT INTO `publicaciones` VALUES ('1350', '1', 'Publicación 63', 'Descripción 63', 'descripcion-63', '2016-12-11 05:40:55', '2016-12-03 22:31:51', null, null);
INSERT INTO `publicaciones` VALUES ('1351', '1', 'Publicación 64', 'Descripción 64', 'descripcion-64', '2016-12-03 07:17:30', '2016-11-06 13:40:22', null, null);
INSERT INTO `publicaciones` VALUES ('1352', '1', 'Publicación 65', 'Descripción 65', 'descripcion-65', '2016-11-02 04:46:52', '2016-11-30 22:44:13', null, null);
INSERT INTO `publicaciones` VALUES ('1353', '1', 'Publicación 66', 'Descripción 66', 'descripcion-66', '2016-11-19 11:17:32', '2016-11-26 12:38:31', null, null);
INSERT INTO `publicaciones` VALUES ('1354', '1', 'Publicación 67', 'Descripción 67', 'descripcion-67', '2016-12-03 09:23:42', '2016-11-02 02:22:03', null, null);
INSERT INTO `publicaciones` VALUES ('1355', '1', 'Publicación 68', 'Descripción 68', 'descripcion-68', '2016-11-08 16:23:30', '2016-11-24 00:37:41', null, null);
INSERT INTO `publicaciones` VALUES ('1356', '1', 'Publicación 69', 'Descripción 69', 'descripcion-69', '2016-11-07 18:59:28', '2016-11-02 16:54:11', null, null);
INSERT INTO `publicaciones` VALUES ('1357', '1', 'Publicación 70', 'Descripción 70', 'descripcion-70', '2016-12-01 08:48:46', '2016-11-30 08:42:28', null, null);
INSERT INTO `publicaciones` VALUES ('1358', '1', 'Publicación 71', 'Descripción 71', 'descripcion-71', '2016-11-25 01:50:28', '2016-11-09 06:08:40', null, null);
INSERT INTO `publicaciones` VALUES ('1359', '1', 'Publicación 72', 'Descripción 72', 'descripcion-72', '2016-12-05 13:27:15', '2016-11-29 16:49:00', null, null);
INSERT INTO `publicaciones` VALUES ('1360', '1', 'Publicación 73', 'Descripción 73', 'descripcion-73', '2016-11-05 10:11:23', '2016-11-10 04:28:05', null, null);
INSERT INTO `publicaciones` VALUES ('1361', '1', 'Publicación 74', 'Descripción 74', 'descripcion-74', '2016-11-28 13:29:27', '2016-11-21 11:11:14', null, null);
INSERT INTO `publicaciones` VALUES ('1362', '1', 'Publicación 75', 'Descripción 75', 'descripcion-75', '2016-11-27 19:54:17', '2016-12-02 19:21:47', null, null);
INSERT INTO `publicaciones` VALUES ('1363', '1', 'Publicación 76', 'Descripción 76', 'descripcion-76', '2016-11-15 08:13:44', '2016-11-04 04:13:29', null, null);
INSERT INTO `publicaciones` VALUES ('1364', '1', 'Publicación 77', 'Descripción 77', 'descripcion-77', '2016-11-08 01:49:47', '2016-11-03 01:13:28', null, null);
INSERT INTO `publicaciones` VALUES ('1365', '1', 'Publicación 78', 'Descripción 78', 'descripcion-78', '2016-11-01 12:13:37', '2016-12-06 15:14:42', null, null);
INSERT INTO `publicaciones` VALUES ('1366', '1', 'Publicación 79', 'Descripción 79', 'descripcion-79', '2016-12-09 09:48:37', '2016-12-09 11:57:31', null, null);
INSERT INTO `publicaciones` VALUES ('1367', '1', 'Publicación 80', 'Descripción 80', 'descripcion-80', '2016-11-05 17:01:07', '2016-11-25 04:02:33', null, null);
INSERT INTO `publicaciones` VALUES ('1368', '1', 'Publicación 81', 'Descripción 81', 'descripcion-81', '2016-11-09 14:10:51', '2016-12-12 06:05:52', null, null);
INSERT INTO `publicaciones` VALUES ('1369', '1', 'Publicación 82', 'Descripción 82', 'descripcion-82', '2016-12-11 07:18:00', '2016-11-05 02:27:49', null, null);
INSERT INTO `publicaciones` VALUES ('1370', '1', 'Publicación 83', 'Descripción 83', 'descripcion-83', '2016-11-06 05:44:04', '2016-11-01 16:47:05', null, null);
INSERT INTO `publicaciones` VALUES ('1371', '1', 'Publicación 84', 'Descripción 84', 'descripcion-84', '2016-11-01 06:04:29', '2016-11-20 08:50:54', null, null);
INSERT INTO `publicaciones` VALUES ('1372', '1', 'Publicación 85', 'Descripción 85', 'descripcion-85', '2016-12-05 14:53:56', '2016-11-27 20:14:23', null, null);
INSERT INTO `publicaciones` VALUES ('1373', '1', 'Publicación 86', 'Descripción 86', 'descripcion-86', '2016-11-19 19:36:19', '2016-11-15 07:05:03', null, null);
INSERT INTO `publicaciones` VALUES ('1374', '1', 'Publicación 87', 'Descripción 87', 'descripcion-87', '2016-11-20 02:19:31', '2016-11-05 16:54:44', null, null);
INSERT INTO `publicaciones` VALUES ('1375', '1', 'Publicación 88', 'Descripción 88', 'descripcion-88', '2016-12-03 03:00:29', '2016-11-21 11:50:29', null, null);
INSERT INTO `publicaciones` VALUES ('1376', '1', 'Publicación 89', 'Descripción 89', 'descripcion-89', '2016-12-07 23:18:08', '2016-11-23 21:36:21', null, null);
INSERT INTO `publicaciones` VALUES ('1377', '1', 'Publicación 99', 'Descripción 90', 'descripcion-90', '2016-12-06 05:24:54', '2016-11-12 23:19:11', null, null);
INSERT INTO `publicaciones` VALUES ('1378', '1', 'Publicación 99', 'Descripción 91', 'descripcion-91', '2016-12-10 22:19:57', '2016-11-05 02:45:26', null, null);
INSERT INTO `publicaciones` VALUES ('1379', '1', 'Publicación 99', 'Descripción 92', 'descripcion-92', '2016-11-10 18:49:06', '2016-11-15 19:26:42', null, null);
INSERT INTO `publicaciones` VALUES ('1380', '1', 'Publicación 99', 'Descripción 93', 'descripcion-93', '2016-11-28 16:01:18', '2016-12-03 10:27:41', null, null);
INSERT INTO `publicaciones` VALUES ('1381', '1', 'Publicación 99', 'Descripción 94', 'descripcion-94', '2016-11-14 17:55:21', '2016-11-14 13:09:02', null, null);
INSERT INTO `publicaciones` VALUES ('1382', '1', 'Publicación 99', 'Descripción 95', 'descripcion-95', '2016-11-02 16:05:23', '2016-12-06 02:45:36', null, null);
INSERT INTO `publicaciones` VALUES ('1383', '1', 'Publicación 99', 'Descripción 96', 'descripcion-96', '2016-11-15 14:22:48', '2016-12-03 13:02:54', null, null);
INSERT INTO `publicaciones` VALUES ('1384', '1', 'Publicación 99', 'Descripción 97', 'descripcion-97', '2016-11-19 11:33:32', '2016-11-14 10:49:44', null, null);
INSERT INTO `publicaciones` VALUES ('1385', '1', 'Publicación 99', 'Descripción 98', 'descripcion-98', '2016-11-15 14:03:20', '2016-11-16 04:46:58', null, null);
INSERT INTO `publicaciones` VALUES ('1386', '1', 'Publicación 99', 'Descripción 99', 'descripcion-99', '2016-11-23 07:55:31', '2016-11-08 21:09:51', null, null);
INSERT INTO `publicaciones` VALUES ('1387', '1', 'Publicación 100', 'Descripción 100', 'descripcion-100', '2016-11-07 10:23:32', '2016-12-02 13:05:40', null, null);
INSERT INTO `publicaciones` VALUES ('1388', '1', 'mi prueba temporal', '<p>mi prueba temporal</p>', 'mi-prueba-temporal', '2016-12-14 08:39:30', '2016-12-14 08:39:30', null, null);
INSERT INTO `publicaciones` VALUES ('1389', '1', '234', '<p>342</p>', '234', '2016-12-14 08:41:18', '2016-12-14 08:41:18', null, null);
INSERT INTO `publicaciones` VALUES ('1390', '2', 'se requere persona de contabilidad para poder terminar un trabajo', '<p>trabajo seguro</p>', 'se-requere-persona-de-contabilidad', '2017-01-31 14:53:21', '2017-01-31 14:53:21', null, null);
INSERT INTO `publicaciones` VALUES ('1391', '6', 'se solicitan empleados en administracion para poder hacer algo', '<p>buena paga y beneficios</p>', 'se-solicitan-empleados-en-administracion', '2017-01-31 17:08:54', '2017-01-31 17:08:54', null, null);

-- ----------------------------
-- Table structure for publicaciones_imagenes
-- ----------------------------
DROP TABLE IF EXISTS `publicaciones_imagenes`;
CREATE TABLE `publicaciones_imagenes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_publicacion` int(11) DEFAULT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publicaciones_imagenes
-- ----------------------------

-- ----------------------------
-- Table structure for publicaciones_sectores
-- ----------------------------
DROP TABLE IF EXISTS `publicaciones_sectores`;
CREATE TABLE `publicaciones_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_publicacion` int(11) DEFAULT NULL,
  `id_sector` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1393 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publicaciones_sectores
-- ----------------------------
INSERT INTO `publicaciones_sectores` VALUES ('1285', '1290', '50');
INSERT INTO `publicaciones_sectores` VALUES ('1286', '1291', '63');
INSERT INTO `publicaciones_sectores` VALUES ('1287', '1292', '58');
INSERT INTO `publicaciones_sectores` VALUES ('1288', '1293', '39');
INSERT INTO `publicaciones_sectores` VALUES ('1289', '1294', '63');
INSERT INTO `publicaciones_sectores` VALUES ('1290', '1295', '10');
INSERT INTO `publicaciones_sectores` VALUES ('1291', '1296', '51');
INSERT INTO `publicaciones_sectores` VALUES ('1292', '1297', '1');
INSERT INTO `publicaciones_sectores` VALUES ('1293', '1298', '26');
INSERT INTO `publicaciones_sectores` VALUES ('1294', '1299', '46');
INSERT INTO `publicaciones_sectores` VALUES ('1295', '1300', '16');
INSERT INTO `publicaciones_sectores` VALUES ('1296', '1301', '63');
INSERT INTO `publicaciones_sectores` VALUES ('1297', '1302', '27');
INSERT INTO `publicaciones_sectores` VALUES ('1298', '1303', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1299', '1304', '28');
INSERT INTO `publicaciones_sectores` VALUES ('1300', '1305', '46');
INSERT INTO `publicaciones_sectores` VALUES ('1301', '1306', '59');
INSERT INTO `publicaciones_sectores` VALUES ('1302', '1307', '13');
INSERT INTO `publicaciones_sectores` VALUES ('1303', '1308', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1304', '1309', '25');
INSERT INTO `publicaciones_sectores` VALUES ('1305', '1310', '43');
INSERT INTO `publicaciones_sectores` VALUES ('1306', '1311', '3');
INSERT INTO `publicaciones_sectores` VALUES ('1307', '1312', '32');
INSERT INTO `publicaciones_sectores` VALUES ('1308', '1313', '59');
INSERT INTO `publicaciones_sectores` VALUES ('1309', '1314', '42');
INSERT INTO `publicaciones_sectores` VALUES ('1310', '1315', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1311', '1316', '54');
INSERT INTO `publicaciones_sectores` VALUES ('1312', '1317', '9');
INSERT INTO `publicaciones_sectores` VALUES ('1313', '1318', '46');
INSERT INTO `publicaciones_sectores` VALUES ('1314', '1319', '58');
INSERT INTO `publicaciones_sectores` VALUES ('1315', '1320', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1316', '1321', '59');
INSERT INTO `publicaciones_sectores` VALUES ('1317', '1322', '62');
INSERT INTO `publicaciones_sectores` VALUES ('1318', '1323', '59');
INSERT INTO `publicaciones_sectores` VALUES ('1319', '1324', '58');
INSERT INTO `publicaciones_sectores` VALUES ('1320', '1325', '63');
INSERT INTO `publicaciones_sectores` VALUES ('1321', '1326', '1');
INSERT INTO `publicaciones_sectores` VALUES ('1322', '1327', '57');
INSERT INTO `publicaciones_sectores` VALUES ('1323', '1328', '6');
INSERT INTO `publicaciones_sectores` VALUES ('1324', '1329', '44');
INSERT INTO `publicaciones_sectores` VALUES ('1325', '1330', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1326', '1331', '54');
INSERT INTO `publicaciones_sectores` VALUES ('1327', '1332', '53');
INSERT INTO `publicaciones_sectores` VALUES ('1328', '1333', '41');
INSERT INTO `publicaciones_sectores` VALUES ('1329', '1334', '28');
INSERT INTO `publicaciones_sectores` VALUES ('1330', '1335', '28');
INSERT INTO `publicaciones_sectores` VALUES ('1331', '1336', '62');
INSERT INTO `publicaciones_sectores` VALUES ('1332', '1337', '54');
INSERT INTO `publicaciones_sectores` VALUES ('1333', '1338', '29');
INSERT INTO `publicaciones_sectores` VALUES ('1334', '1339', '63');
INSERT INTO `publicaciones_sectores` VALUES ('1335', '1340', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1336', '1341', '7');
INSERT INTO `publicaciones_sectores` VALUES ('1337', '1342', '37');
INSERT INTO `publicaciones_sectores` VALUES ('1338', '1343', '57');
INSERT INTO `publicaciones_sectores` VALUES ('1339', '1344', '47');
INSERT INTO `publicaciones_sectores` VALUES ('1340', '1345', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1341', '1346', '47');
INSERT INTO `publicaciones_sectores` VALUES ('1342', '1347', '4');
INSERT INTO `publicaciones_sectores` VALUES ('1343', '1348', '2');
INSERT INTO `publicaciones_sectores` VALUES ('1344', '1349', '53');
INSERT INTO `publicaciones_sectores` VALUES ('1345', '1350', '20');
INSERT INTO `publicaciones_sectores` VALUES ('1346', '1351', '29');
INSERT INTO `publicaciones_sectores` VALUES ('1347', '1352', '57');
INSERT INTO `publicaciones_sectores` VALUES ('1348', '1353', '34');
INSERT INTO `publicaciones_sectores` VALUES ('1349', '1354', '50');
INSERT INTO `publicaciones_sectores` VALUES ('1350', '1355', '15');
INSERT INTO `publicaciones_sectores` VALUES ('1351', '1356', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1352', '1357', '17');
INSERT INTO `publicaciones_sectores` VALUES ('1353', '1358', '2');
INSERT INTO `publicaciones_sectores` VALUES ('1354', '1359', '31');
INSERT INTO `publicaciones_sectores` VALUES ('1355', '1360', '44');
INSERT INTO `publicaciones_sectores` VALUES ('1356', '1361', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1357', '1362', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1358', '1363', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1359', '1364', '4');
INSERT INTO `publicaciones_sectores` VALUES ('1360', '1365', '44');
INSERT INTO `publicaciones_sectores` VALUES ('1361', '1366', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1362', '1367', '1');
INSERT INTO `publicaciones_sectores` VALUES ('1363', '1368', '9');
INSERT INTO `publicaciones_sectores` VALUES ('1364', '1369', '60');
INSERT INTO `publicaciones_sectores` VALUES ('1365', '1370', '34');
INSERT INTO `publicaciones_sectores` VALUES ('1366', '1371', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1367', '1372', '44');
INSERT INTO `publicaciones_sectores` VALUES ('1368', '1373', '45');
INSERT INTO `publicaciones_sectores` VALUES ('1369', '1374', '1');
INSERT INTO `publicaciones_sectores` VALUES ('1370', '1375', '61');
INSERT INTO `publicaciones_sectores` VALUES ('1371', '1376', '59');
INSERT INTO `publicaciones_sectores` VALUES ('1372', '1377', '43');
INSERT INTO `publicaciones_sectores` VALUES ('1373', '1378', '39');
INSERT INTO `publicaciones_sectores` VALUES ('1374', '1379', '28');
INSERT INTO `publicaciones_sectores` VALUES ('1375', '1380', '30');
INSERT INTO `publicaciones_sectores` VALUES ('1376', '1381', '58');
INSERT INTO `publicaciones_sectores` VALUES ('1377', '1382', '57');
INSERT INTO `publicaciones_sectores` VALUES ('1378', '1383', '59');
INSERT INTO `publicaciones_sectores` VALUES ('1379', '1384', '63');
INSERT INTO `publicaciones_sectores` VALUES ('1380', '1385', '62');
INSERT INTO `publicaciones_sectores` VALUES ('1381', '1386', '37');
INSERT INTO `publicaciones_sectores` VALUES ('1382', '1387', '57');
INSERT INTO `publicaciones_sectores` VALUES ('1383', '1388', '5');
INSERT INTO `publicaciones_sectores` VALUES ('1384', '1389', '5');
INSERT INTO `publicaciones_sectores` VALUES ('1385', '1288', '19');
INSERT INTO `publicaciones_sectores` VALUES ('1387', '1390', '5');
INSERT INTO `publicaciones_sectores` VALUES ('1388', '1391', '5');
INSERT INTO `publicaciones_sectores` VALUES ('1389', '2', '5');
INSERT INTO `publicaciones_sectores` VALUES ('1390', '2', '5');
INSERT INTO `publicaciones_sectores` VALUES ('1392', '1289', '41');

-- ----------------------------
-- Table structure for publicaciones_videos
-- ----------------------------
DROP TABLE IF EXISTS `publicaciones_videos`;
CREATE TABLE `publicaciones_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_publicacion` int(11) DEFAULT NULL,
  `titulo` varchar(48) DEFAULT NULL,
  `enlace` varchar(64) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualzacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publicaciones_videos
-- ----------------------------

-- ----------------------------
-- Table structure for publicidad
-- ----------------------------
DROP TABLE IF EXISTS `publicidad`;
CREATE TABLE `publicidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `tipo_publicidad` tinyint(4) DEFAULT NULL,
  `mi_publicidad` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publicidad
-- ----------------------------
INSERT INTO `publicidad` VALUES ('2', 'publicidad', 'www.google.com', '32', '2017-02-16 02:35:15', '2017-02-16 02:35:15', '2', '0');
INSERT INTO `publicidad` VALUES ('3', 'publicidad 2', 'www.facebook.com', '33', '2017-02-16 03:19:02', '2017-02-16 03:19:02', '2', '0');
INSERT INTO `publicidad` VALUES ('4', 'publicidad 3', 'www.yahoo.com', '34', '2017-02-16 03:19:36', '2017-02-16 03:19:36', '2', '0');
INSERT INTO `publicidad` VALUES ('5', 'publicidad 4', 'www.yahoo.com', '35', '2017-02-16 03:19:50', '2017-02-16 03:19:50', '2', '0');
INSERT INTO `publicidad` VALUES ('6', '11111', '12121212', '0', '2017-02-19 00:05:13', '2017-02-19 00:05:13', '1', '0');
INSERT INTO `publicidad` VALUES ('7', 'video1', 'https://www.youtube.com/watch?v=RBumgq5yVrA', '0', '2017-02-20 19:34:21', '2017-02-20 19:34:21', '1', '1');
INSERT INTO `publicidad` VALUES ('8', 'prueba img', 'www.google.com', '36', '2017-02-20 19:38:44', '2017-02-20 19:38:44', '2', '1');

-- ----------------------------
-- Table structure for servicios
-- ----------------------------
DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `curiculos_disponibles` int(11) DEFAULT NULL,
  `filtros_personalizados` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servicios
-- ----------------------------
INSERT INTO `servicios` VALUES ('1', 'Busqueda en base x 40', '1120.5', '40', '1');
INSERT INTO `servicios` VALUES ('2', 'Busqueda en base x 100', '1743', '100', '1');
INSERT INTO `servicios` VALUES ('3', 'Busqueda en base x 150', '2739', '150', '1');
INSERT INTO `servicios` VALUES ('4', 'Gratis', '0', '15', '0');

-- ----------------------------
-- Table structure for sexos
-- ----------------------------
DROP TABLE IF EXISTS `sexos`;
CREATE TABLE `sexos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sexos
-- ----------------------------
INSERT INTO `sexos` VALUES ('1', 'Masculino');
INSERT INTO `sexos` VALUES ('2', 'Femenino');

-- ----------------------------
-- Table structure for telefonos
-- ----------------------------
DROP TABLE IF EXISTS `telefonos`;
CREATE TABLE `telefonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_area` varchar(16) DEFAULT NULL,
  `numero` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of telefonos
-- ----------------------------

-- ----------------------------
-- Table structure for tipos_documento_identificacion
-- ----------------------------
DROP TABLE IF EXISTS `tipos_documento_identificacion`;
CREATE TABLE `tipos_documento_identificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipos_documento_identificacion
-- ----------------------------
INSERT INTO `tipos_documento_identificacion` VALUES ('1', 'Cedula de Identidad');
INSERT INTO `tipos_documento_identificacion` VALUES ('2', 'L.E');
INSERT INTO `tipos_documento_identificacion` VALUES ('3', 'Pasaporte');
INSERT INTO `tipos_documento_identificacion` VALUES ('4', 'L.C');
INSERT INTO `tipos_documento_identificacion` VALUES ('5', 'DNI');

-- ----------------------------
-- Table structure for trabajadores
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores`;
CREATE TABLE `trabajadores` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  `id_sexo` int(11) DEFAULT NULL,
  `id_estado_civil` int(11) DEFAULT NULL,
  `id_tipo_documento_identificacion` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  `provincia` varchar(64) DEFAULT NULL,
  `localidad` varchar(64) DEFAULT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `id_metodo_acceso` varchar(255) DEFAULT NULL,
  `nombres` varchar(64) DEFAULT NULL,
  `apellidos` varchar(64) DEFAULT NULL,
  `numero_documento_identificacion` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(32) DEFAULT NULL,
  `telefono_alternativo` varchar(32) DEFAULT NULL,
  `usuario` varchar(32) DEFAULT NULL,
  `clave` varchar(64) DEFAULT NULL,
  `correo_electronico` varchar(48) DEFAULT NULL,
  `codigo_recuperacion` varchar(32) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `calificacion_general` double DEFAULT NULL,
  `sitio_web` varchar(128) DEFAULT NULL,
  `facebook` varchar(128) DEFAULT NULL,
  `twitter` varchar(128) DEFAULT NULL,
  `instagram` varchar(128) DEFAULT NULL,
  `snapchat` varchar(128) DEFAULT NULL,
  `publicidad` tinyint(1) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `publico` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of trabajadores
-- ----------------------------
INSERT INTO `trabajadores` VALUES ('1', '5', '27', '0', '0', '0', '0', '', '', '', '', 'prueba', 'prueba', '', null, '', '', 'prueba', 'c4ca4238a0b923820dcc509a6f75849b', 'prueba@prueba.com', null, '2016-12-14 03:48:15', '2016-12-14 03:48:15', '3.25', null, null, null, null, null, null, null, '1');
INSERT INTO `trabajadores` VALUES ('2', '6', '25', '1', '1', '1', '238', '121', '212', '12', '1', 'alz', 'aldana', '123421', '2016-12-14', '12', '', 'alz', 'c4ca4238a0b923820dcc509a6f75849b', 'alz7xj@gmail.com', '1482232331', '2016-11-29 05:54:49', '2016-12-16 04:53:11', '4.75', null, null, null, null, null, null, null, '1');
INSERT INTO `trabajadores` VALUES ('20', '7', '0', '0', '0', '0', '0', '', '', '', '', 'Mario Sanchez', '', '', null, '', '', '', '', 'us3r007@gmail.com', null, '2017-01-12 04:42:21', '2017-01-12 04:42:21', '2.5', null, null, null, null, null, null, null, '1');

-- ----------------------------
-- Table structure for trabajadores_areas_sectores
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_areas_sectores`;
CREATE TABLE `trabajadores_areas_sectores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_publicacion` int(11) DEFAULT NULL,
  `id_sector` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_areas_sectores
-- ----------------------------
INSERT INTO `trabajadores_areas_sectores` VALUES ('1', '2', '5');

-- ----------------------------
-- Table structure for trabajadores_educacion
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_educacion`;
CREATE TABLE `trabajadores_educacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) NOT NULL,
  `id_nivel_estudio` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `id_estado_estudio` int(11) NOT NULL,
  `id_area_estudio` int(11) NOT NULL,
  `nombre_institucion` varchar(255) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `mes_inicio` int(11) NOT NULL,
  `ano_inicio` int(11) NOT NULL,
  `mes_finalizacion` int(11) NOT NULL,
  `ano_finalizacion` int(11) NOT NULL,
  `materias_carrera` int(11) NOT NULL,
  `materias_aprobadas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_educacion
-- ----------------------------
INSERT INTO `trabajadores_educacion` VALUES ('1', '2', '3', 'TSU Informatica', '2', '94', 'UNIR', '238', '1', '2010', '8', '2014', '36', '36');
INSERT INTO `trabajadores_educacion` VALUES ('2', '2', '1', '121212', '2', '10', '1212', '12', '11', '1964', '12', '1988', '0', '0');

-- ----------------------------
-- Table structure for trabajadores_experiencia_laboral
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_experiencia_laboral`;
CREATE TABLE `trabajadores_experiencia_laboral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `id_actividad_empresa` int(11) NOT NULL,
  `tipo_puesto` varchar(255) NOT NULL,
  `mes_ingreso` int(11) NOT NULL,
  `ano_ingreso` int(11) NOT NULL,
  `mes_egreso` int(11) NOT NULL,
  `ano_egreso` int(11) NOT NULL,
  `descripcion_tareas` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_experiencia_laboral
-- ----------------------------
INSERT INTO `trabajadores_experiencia_laboral` VALUES ('1', '2', 'Autotrack de venezuela2', '238', '34', 'Programador2', '6', '2015', '12', '2016', 'De todo :D');

-- ----------------------------
-- Table structure for trabajadores_idiomas
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_idiomas`;
CREATE TABLE `trabajadores_idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `nivel_oral` int(11) NOT NULL,
  `nivel_escrito` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_idiomas
-- ----------------------------
INSERT INTO `trabajadores_idiomas` VALUES ('1', '2', '4', '4', '4');
INSERT INTO `trabajadores_idiomas` VALUES ('2', '2', '6', '2', '3');
INSERT INTO `trabajadores_idiomas` VALUES ('3', '2', '1', '1', '1');
INSERT INTO `trabajadores_idiomas` VALUES ('4', '2', '3', '1', '1');

-- ----------------------------
-- Table structure for trabajadores_otros_conocimientos
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_otros_conocimientos`;
CREATE TABLE `trabajadores_otros_conocimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_otros_conocimientos
-- ----------------------------
INSERT INTO `trabajadores_otros_conocimientos` VALUES ('1', '2', 'Freelancer', 'Freelancer en workana');
INSERT INTO `trabajadores_otros_conocimientos` VALUES ('2', '2', '1212', '1212');
INSERT INTO `trabajadores_otros_conocimientos` VALUES ('3', '2', '123', '123');
INSERT INTO `trabajadores_otros_conocimientos` VALUES ('4', '2', '12466', '12');
INSERT INTO `trabajadores_otros_conocimientos` VALUES ('5', '2', 'dd', 'dd');
INSERT INTO `trabajadores_otros_conocimientos` VALUES ('6', '2', 'prueba', 'prueba de conocimiento');

-- ----------------------------
-- Table structure for trabajadores_publicaciones
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_publicaciones`;
CREATE TABLE `trabajadores_publicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `amigable` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_publicaciones
-- ----------------------------
INSERT INTO `trabajadores_publicaciones` VALUES ('2', '2', 'prueba', '<p>prueba</p>', 'prueba', '2017-02-04 18:42:36', '2017-02-04 18:42:36');

-- ----------------------------
-- Table structure for trabajadores_telefonos
-- ----------------------------
DROP TABLE IF EXISTS `trabajadores_telefonos`;
CREATE TABLE `trabajadores_telefonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) DEFAULT NULL,
  `id_telefono` int(11) DEFAULT NULL,
  `principal` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trabajadores_telefonos
-- ----------------------------

-- ----------------------------
-- Table structure for uid
-- ----------------------------
DROP TABLE IF EXISTS `uid`;
CREATE TABLE `uid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of uid
-- ----------------------------
INSERT INTO `uid` VALUES ('1', '8');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) DEFAULT NULL,
  `apellido` varchar(64) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `rol` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'Alz', 'Aldana', 'alz7xj@gmail.com', '1', 'A', 'alz');
INSERT INTO `usuarios` VALUES ('2', '111', '111', '111', '1', 'N', 'prueba');
SET FOREIGN_KEY_CHECKS=1;
