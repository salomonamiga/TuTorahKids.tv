<?php
require_once __DIR__.'/config.php';

date_default_timezone_set('America/Mexico_City');


global $encabezado;
global $pie;


//define('PATH_IMPORTADOS', '/var/www/archivos/');
define('PATH_LIBRERIAS', 'libs/');
define('URL_PLATAFORMA', 'https://tutorah.tv/');
define('URL_PLATAFORMA_KIDS', 'https://tutorahkids.tv/');
define('URL_PORTADAS', 'https://adc.tutorah.tv/img/categorias/portadas/');
define('URL_BACKGROUND', 'https://adc.tutorah.tv/img/categorias/fondos/');
define('URL_ADC', 'https://adc.tutorah.tv/');
//define('URL_THUMBNAILS', 'https://tutorah_pics.streamgates.net/tutorah_pics/');
define('URL_THUMBNAILS', 'https://s3apics.streamgates.net/TutorahTV_Thumbs/');
//define('URL_AUDIO', 'https://tutorah.streamgates.net/tutorah_vod/Audio/');
define('URL_AUDIO', 'https://tvod.streamgates.net/TutorahVOD/mp3/');

//define('URL_VIDEO', 'https://tutorah.streamgates.net/tutorah_vod/');

/****CONEXION BASE DE DATOS****/
function conecta(){
	include_once(PATH_LIBRERIAS.'adodb5/adodb.inc.php');
	include_once(PATH_LIBRERIAS.'adodb5/adodb-errorhandler.inc.php');
	define('ADODB_ERROR_LOG_TYPE', 3);
	define('ADODB_ERROR_LOG_DEST', 'adodb_errors.log');
	$db = NewADOConnection('mysqli');
	$datos = Array(DB_HOST, TUTORAH_DB_USERNAME, TUTORAH_DB_PASSWORD, TUTORAH_DB_NAME);
	$db->connect($datos[0], $datos[1], $datos[2], $datos[3]) or die('<h2>Error al conectarse a la base de datos</h2>');
	return($db);
}
//devuelve el numero de elementos de un arreglo
function cuenta($arr){return count($arr);}

function codificahtml($str){return htmlentities($str,ENT_XHTML,'ISO-8859-1');}//funcion para convertir caracteres especiales en caracteres html

function limpia_numero($numero) {
    $numero=filterXSS($numero);
    if ($numero == "")
        $numero = 0;
    $numero = str_replace('$', '', $numero);
    $numero = str_replace(',', '', $numero);
    $numero = str_replace(" ", "", $numero);
    $numero = floatval($numero);
    return $numero;
}
function filterXSS($val) {
	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
	// straight replacements, the user should never need these since they're normal characters
	// this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>	

	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for ($i = 0; $i < strlen($search); $i++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
		// &#x0040 @ search for the hex values
		$val = preg_replace('/(&#[x|X]0{0,8}' . dechex (ord($search [$i])) . ';?)/i', $search[$i], $val); // with a ;
		// &#00064 @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
	}
	
	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta ', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 
				'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 
				'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 
				'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 
				'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 
				'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 
				'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 
				'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

	$ra = array_merge($ra1, $ra2);
	
	$found = true; // keep replacing as long as the previous round replaced something
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
					$pattern .= '|(&#0{0,8}([9][10][13]);?)?';
					$pattern .= ')?';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra [$i], 0, 2) . '<x>' . substr($ra [$i], 2); // add in <> to nerf the tag
			$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}
	return $val;
}

function prepara_texto_busqueda($busqueda) {
    $busqueda = str_replace("?", '%', $busqueda);
    $busqueda = str_replace("'", '%', $busqueda);
    return $busqueda;
}

function filtro_or($valores, $campo, $not = 0) {
    if (sizeof($valores)==0 || $campo == "") return "(1=1)";
    if ($not==1) $comple = "NOT";
    $cadena = "( ";
    for ($i = 0; $i < sizeof($valores); $i++) {
        $valores[$i] = str_replace("?", "", $valores[$i]);
        if ($i > 0)
            $cadena .= " OR ";
        $cadena .= $campo . " $comple LIKE '%" . $valores[$i] . "%'";
    }
    $cadena .= " )";
    return $cadena;
}

function correopruebas(){
	date_default_timezone_set('America/Mexico_City');
	$mail=new PHPMailer();
	$mail->IsSMTP();
	//$mail->SMTPDebug  = 2;// activa la información debug SMTP (para pruebas)1 = errores y mensages ó 2 = mensages solamente
	$mail->SMTPAuth =true; // activa la autenticación SMTP 
	$mail->SMTPSecure = "ssl"; // establece el prefijo al servidor
	$mail->Host="smtp.gmail.com"; // establece a GMAIL como el servidor SMTP
	$mail->Port=465; // estabece el purto SMTP para el servidor GMAIL
	$mail->IsHTML(true);
	$mail->Username="gismodelta79@gmail.com";  // usuario de GMAIL 
	$mail->Password="07desarrollo"; // password de GMAIL
	$mail->SetFrom('gismodelta79@gmail.com', 'Web TutorahKids');
	return $mail;
}

function muestra_errores() {
    ini_set('display_errors', 1);
}

/**
 * $seccion =>
 *      1.- General
 *      2.- Infantil
 *      3.- Femenina
**/

function select_edades($seleccionado='', $elige=1){
	global $db;
	$r = $db->getAll("SELECT DISTINCT
	v.idVideoteca,
	v.nombre 
FROM
	grabacionesVideotecas gv
	LEFT JOIN grabaciones g ON g.idGrabacion = gv.idGrabacion
	LEFT JOIN videotecas v ON v.idVideoteca = gv.IdVideoteca 
WHERE
	estatusWF = 6 
	AND idMultix <> '' 
	AND g.baja = 0 
	AND gv.idVideoteca IN ( SELECT idVideoteca FROM `videotecas` WHERE seccion = 2 );");
	$cadena = '<label>Edades: </label>';
	$cadena .= '<select id="edades" name="edades" class="form-control">';
	if ($elige == 1){
		$cadena .= '<option value="0" selected>Todas las edades</option>';
	}else{
		$cadena .= '<option value="0">Todas las edades</option>';
	}
	
	foreach ($r as $row) {
        $cadena .= '<option value="'.$row[0].'"';
		if($row[0]==$seleccionado)
			$cadena .= 'selected="selected"';
        $cadena .= ">$row[1]</option>";
        
    }
    $cadena .= '</select>';
    return $cadena;
	//echo $cadena;
}

function select_categorias($seleccionado='',$elige=1){
	global $db;
	$r = $db->getAll("SELECT idCategoria,nombre FROM categorias WHERE idCategoria IN ( SELECT idCategoria FROM grabaciones WHERE idGrabacion IN ( SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = (SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' AND portadaInfantil<>'' ) AND baja = 0 ) AND estatusWF = 6 AND idMultix <> '' AND videoteca = 1 AND now() > fechaDisponibilidad AND baja = 0)AND baja = 0 AND visibilidadInfantil = 1");
	
	$cadena = '<label>Categorias:</label>';
	$cadena .= '<select id="categoria" name="categoria" class="form-control">';
	if ($elige == 1){
		$cadena .= '<option value="0" selected>Todas las categorias</option>';
	}else{
		$cadena .= '<option value="0">Todas las categorias</option>';
	}
	
	foreach ($r as $row) {
        $cadena .= '<option value="'.$row[0].'"';
			if($row[0]==$seleccionado)
				$cadena .= 'selected="selected"';
        $cadena .= ">$row[1]</option>";
        
    }
    $cadena .= '</select>';
    return $cadena;
}

function titulo_normalizado($titulo, $categoria = "") {
    if ($categoria=="Palabras de Torah") 
        if (strpos($titulo, '-') !== FALSE) {
            $partes = explode(' - ', $titulo);
            $nombreRabino = $partes[0];
            $tituloMaterial = '';
            for ($k=1; $k < sizeof($partes); $k++)
                $tituloMaterial .= $partes[$k] . " - ";
            $titulo = $tituloMaterial . $nombreRabino;
        }

    return $titulo;    
}

function titulo_lineas($titulo, $duracion, $categoria) {
    $clase = (mb_strlen($titulo)<=30)?"one-line":"more-line";
    $titulo = titulo_normalizado($titulo, $categoria);
    $titulo = (mb_strlen($titulo)>90)?mb_substr($titulo, 0, 85)."...":$titulo;
    return '<p class="' . $clase . '">' . $titulo . '<span>' . formato_tiempo_youtube($duracion) . '</span></p>';
}

function formato_tiempo_youtube($tiempo) {
    $tiempo = explode(":", $tiempo);
    
    $horas = ($tiempo[0]=="00")?"":intval($tiempo[0]).":";
    $minutos = ($horas=="")?intval($tiempo[1]):$tiempo[1];
    $temp = explode(".", $tiempo[2]);
    $segundos = $temp[0];
    
    return $horas.$minutos.":".$segundos;
}

function limpia_string($value, $xss=1) {
    if ($xss==1) $value=filterXSS($value);
    /*if (get_magic_quotes_gpc())
        $value = $value;
    else*/
        $value = addslashes($value);
    return $value;
}

function correo(){
	date_default_timezone_set('America/Mexico_City');
	$mail=new PHPMailer();
	$mail->IsSMTP();
	//$mail->SMTPDebug  = 2;// activa la información debug SMTP (para pruebas)1 = errores y mensages ó 2 = mensages solamente
	$mail->SMTPAuth =true; // activa la autenticación SMTP
	$mail->SMTPSecure = true; 
	$mail->SMTPSecure = "ssl"; // establece el prefijo al servidor
	$mail->Host="usm4.siteground.biz"; // establece a GMAIL como el servidor SMTP
	$mail->Port=465; // estabece el purto SMTP para el servidor GMAIL
	$mail->IsHTML(true);
	$mail->Username = "no-reply@tutorahtv.com";
	$mail->Password = "*qazwsxzse#_1";
	$mail->SetFrom('no-reply@tutorahtv.com', 'Web TuTorahKids.TV');
	return $mail;
}

function cuerpomail($nombre,$email,$mensaje){
	$cuerpo='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    
    <title></title>
    <style type="text/css">
        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }
        a {
            color: inherit; /* blue colors for links too */
            text-decoration: inherit; /* no underline */
        }
        
        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        span.preheader {
            display: none;
            font-size: 1px;
        }
        
        html {
            width: 100%;
        }
        
        table {
            font-size: 14px;
            border: 0;
        }
        /* ----------- responsivity ----------- */
        
        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
            /*----- main image -------*/
            .main-image img {
                width: 440px !important;
                height: auto !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 320px !important;
                height: auto !important;
            }
            .team-img img {
                width: 100% !important;
                height: auto !important;
            }
        }
        
        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;
            }
            .main-section-header {
                font-size: 26px !important;
            }
            /* ====== divider ====== */
            .divider img {
                width: 280px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 280px !important;
            }
            .container590 {
                width: 280px !important;
            }
            .container580 {
                width: 260px !important;
            }
            /*-------- secions ----------*/
            .section-img img {
                width: 280px !important;
                height: auto !important;
            }
        }
    </style>
    <!-- [if gte mso 9]><style type=”text/css”>
        body {
        font-family: arial, sans-serif!important;
        }
        </style>
    <![endif]-->
</head>
<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <!-- pre-header -->
    <table style="display:none!important;">
        <tr>
            <td>
                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                    <strong>Nuevo mensaje recibido desde la pagina Web</strong><br />
                </div>
            </td>
        </tr>
    </table>
    <!-- pre-header end -->
    <!-- header -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="center" height="70" style="height:70px;">
                                        <a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="img/logokids.png" alt="" /></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--<tr>
                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                    </tr>-->
                </table>
            </td>
        </tr>
    </table>
    <!-- end header -->

    <!-- big image section -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <!--<tr>
                        <td align="center" class="section-img">
                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="https://mdbootstrap.com/img/Mockups/Lightbox/Original/img (67).jpg" style="display: block; width: 590px;" width="590" border="0" alt="" /></a>
                        </td>
                    </tr>-->
                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">
                            <div style="line-height: 35px">
                                Correo enviado desde <span style="color: #5caad2;"><a href="http://tutorahkids.tv/" >TuTorahKids.Tv</a></span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="color: #888888; font-size: 14px; font-family: "Work Sans", Calibri, sans-serif; line-height: 23px;" class="text_color">
                            <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">
                                Nombre: <br/> 
                                <a style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">'.$nombre.'</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                            <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">
                                Email: <br/> 
                                <a style="color: #888888; font-size: 14px; font-family: \'Hind Siliguri\', Calibri, Sans-serif; font-weight: 400;">'.$email.'</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="color: #888888; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 23px;" class="text_color">
                            <div style="color: #333333; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">
                                Mensaje: <br/> 
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" width="400" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="center" style="color: #888888; font-size: 16px; font-family: \'Work Sans\', Calibri, sans-serif; line-height: 24px;">
                                        <div style="line-height: 24px">'.$mensaje.'</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">
        <tr>
            <td align="center" style="color: #aaaaaa; font-size: 14px; font-family: \'Work Sans\', Calibri, sans-serif;">
                <span style="color: #333333;">No responder a este E-mail.</span>
            </td>
        </tr>
    </table>
</body>
</html>';
	return $cuerpo;
}

function nombre_url($nombre) {
    return str_replace(' ', '-', strtolower($nombre));
}

$ordenMaterialPaginaInstruccion = array();
$ordenMaterialPaginaInstruccion[0] = "titulo ASC";
$ordenMaterialPaginaInstruccion[1] = "titulo DESC";
$ordenMaterialPaginaInstruccion[2] = "duracionMultix ASC, titulo ASC";
$ordenMaterialPaginaInstruccion[3] = "duracionMultix DESC, titulo ASC";
$ordenMaterialPaginaInstruccion[4] = "fechaPublicacionMultix ASC, titulo ASC";
$ordenMaterialPaginaInstruccion[5] = "fechaPublicacionMultix DESC, titulo ASC";
$ordenMaterialPaginaInstruccion[6] = "rand()";

$temporadas = array();
$temporadas[1] = "Temporada 1";
$temporadas[2] = "Temporada 2";
$temporadas[3] = "Temporada 3";
$temporadas[4] = "Temporada 4";
$temporadas[5] = "Temporada 5";

$temporadas[6] = "Bereshit";
$temporadas[7] = "Shemot";
$temporadas[8] = "Vaikra";
$temporadas[9] = "Bamidbar";
$temporadas[10] = "Debarim";

$temporadas[11] = "Pesaj";
$temporadas[12] = "Lag Baomer";
$temporadas[13] = "Shabuot";
$temporadas[14] = "Rosh Hashana";
$temporadas[15] = "Kipur";
$temporadas[16] = "Sucot";
$temporadas[17] = "Simjat Torah";
$temporadas[18] = "Januca";
$temporadas[19] = "Tu Bishvat";
$temporadas[20] = "Purim";
$temporadas[21] = "Ayunos";

$temporadas[22] = "Bereshit - Español";
$temporadas[23] = "Bereshit - Hebreo";
$temporadas[24] = "Bereshit - Ingles";

$temporadas[25] = "Shemot - Español";
$temporadas[26] = "Shemot - Hebreo";
$temporadas[27] = "Shemot - Ingles";

$temporadas[28] = "Vaikra - Español";
$temporadas[29] = "Vaikra - Hebreo";
$temporadas[30] = "Vaikra - Ingles";

$temporadas[31] = "Bamidbar - Español";
$temporadas[32] = "Bamidbar - Hebreo";
$temporadas[33] = "Bamidbar - Ingles";

$temporadas[34] = "Debarim - Español";
$temporadas[35] = "Debarim - Hebreo";
$temporadas[36] = "Debarim - Ingles";

$temporadas[37] = "Jaguim - Español";
$temporadas[38] = "Jaguim - Hebreo";
$temporadas[39] = "Jaguim - Ingles";

$temporadas[40] = "Jaguim";

?> 