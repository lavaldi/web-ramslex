<?php
	require_once("db_conf.php");
	require_once('recaptcha/recaptchalib.php');
	$band 			= 	false;
	$success 		= 	true;
	$envio 			= 	array();

	$publickey 		= 	"6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey 	= 	"6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error 			= 	null;

	$formulario		= 	$_REQUEST['formulario'];
	$datos			= 	array();

	parse_str($formulario,$datos);

	$codigoreserva	=	$datos['codigoreserva']; 
	$numope			= 	$datos['ope'];
	$fecha			=	$datos['fecha'];
	$hora			=	$datos['hora'];
	$pago 			= 	$datos['pagoSelect'];

	if ($datos["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $datos["recaptcha_challenge_field"],
            $datos["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $band = true;
        } else {
                $band = false;
        }
	}

	if ($band) {

		$conexion = mysqli_connect ($server, $user, $password) or die ("No se puede conectar con el servidor"); 
		mysqli_select_db ($conexion,$dbname) or die ("No se puede seleccionar la base de datos"); 
		
		mysqli_autocommit($conexion,FALSE);

		$instruccion = "SELECT * FROM reservas WHERE codigoreserva='".$codigoreserva."' AND monto='".$pago."'";
		$consulta = mysqli_query($conexion,$instruccion);

		if (!$consulta) {
			$success = false;
	    	$envio =  array('band'=>false,'cod'=>$codigoreserva, 'msj'=>'El código o monto ingresado no son correctos, vuelva a intentar.');
		}
		else{
			$consulta = mysqli_fetch_array($consulta);
			$fecha1 = date_create_from_format('d-m-Y',$fecha);
			$fecha2 = $fecha1 -> format('Y-m-d');
			$fecha_act = date('Y-m-d');
			$instruccion1 = "INSERT into conf_pago (num_operacion, fecha_pago, hora, monto, idreservas, fecha_conf) VALUES ('".$numope."','".$fecha2."', '".$hora."', '".$pago."', ".$consulta['idreservas'].", '".$fecha_act."')";
		        $consulta1 = mysqli_query($conexion,$instruccion1);

		    if(!$consulta1){
		    	$success = false;
		    	$envio =  array('band'=>false,'cod'=>$codigoreserva, 'msj'=>'Usted ya confirmó su pago. 1');
		    }
	   		else{
				$msg		=	'
		    	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				    <head>
				    	<!-- NAME: 1 COLUMN -->
				        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				        <meta name="viewport" content="width=device-width, initial-scale=1.0">
				        <title>*|MC:SUBJECT|*</title>
				        
				        <!--[if gte mso 6]>
				        <style>
				            table.mcnFollowContent {width:100% !important;}
				            table.mcnShareContent {width:100% !important;}
				        </style>
				        <![endif]-->
				    <style type="text/css">
						body,#bodyTable,#bodyCell{
							height:100% !important;
							margin:0;
							padding:0;
							width:100% !important;
						}
						table{
							border-collapse:collapse;
						}
						img,a img{
							border:0;
							outline:none;
							text-decoration:none;
						}
						h1,h2,h3,h4,h5,h6{
							margin:0;
							padding:0;
						}
						p{
							margin:1em 0;
							padding:0;
						}
						a{
							word-wrap:break-word;
						}
						.ReadMsgBody{
							width:100%;
						}
						.ExternalClass{
							width:100%;
						}
						.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
							line-height:100%;
						}
						table,td{
							mso-table-lspace:0pt;
							mso-table-rspace:0pt;
						}
						#outlook a{
							padding:0;
						}
						img{
							-ms-interpolation-mode:bicubic;
						}
						body,table,td,p,a,li,blockquote{
							-ms-text-size-adjust:100%;
							-webkit-text-size-adjust:100%;
						}
						#bodyCell{
							padding:20px;
						}
						.mcnImage{
							vertical-align:bottom;
						}
						.mcnTextContent img{
							height:auto !important;
						}
						body,#bodyTable{
							background-color:#F2F2F2;
						}
						#bodyCell{
							border-top:0;
						}
						#templateContainer{
							border:0;
						}
						h1{
							color:#606060 !important;
							display:block;
							font-family:Helvetica;
							font-size:40px;
							font-style:normal;
							font-weight:bold;
							line-height:125%;
							letter-spacing:-1px;
							margin:0;
							text-align:left;
						}
						h2{
							color:#404040 !important;
							display:block;
							font-family:Helvetica;
							font-size:26px;
							font-style:normal;
							font-weight:bold;
							line-height:125%;
							letter-spacing:-.75px;
							margin:0;
							text-align:left;
						}
						h3{
							color:#606060 !important;
							display:block;
							font-family:Helvetica;
							font-size:18px;
							font-style:normal;
							font-weight:bold;
							line-height:125%;
							letter-spacing:-.5px;
							margin:0;
							text-align:left;
						}
						h4{
							color:#808080 !important;
							display:block;
							font-family:Helvetica;
							font-size:16px;
							font-style:normal;
							font-weight:bold;
							line-height:125%;
							letter-spacing:normal;
							margin:0;
							text-align:left;
						}
						#templatePreheader{
							background-color:#FFFFFF;
							border-top:0;
							border-bottom:0;
						}
						.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
							color:#606060;
							font-family:Helvetica;
							font-size:11px;
							line-height:125%;
							text-align:left;
						}
						.preheaderContainer .mcnTextContent a{
							color:#606060;
							font-weight:normal;
							text-decoration:underline;
						}
						#templateHeader{
							background-color:#FFFFFF;
							border-top:0;
							border-bottom:0;
						}
						.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
							color:#606060;
							font-family:Helvetica;
							font-size:15px;
							line-height:150%;
							text-align:left;
						}
						.headerContainer .mcnTextContent a{
							color:#6DC6DD;
							font-weight:normal;
							text-decoration:underline;
						}
						#templateBody{
							background-color:#FFFFFF;
							border-top:0;
							border-bottom:0;
						}
						.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
							color:#606060;
							font-family:Helvetica;
							font-size:15px;
							line-height:150%;
							text-align:left;
						}
						.bodyContainer .mcnTextContent a{
							color:#6DC6DD;
							font-weight:normal;
							text-decoration:underline;
						}
						#templateFooter{
							background-color:#FFFFFF;
							border-top:0;
							border-bottom:0;
						}
						.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
							color:#606060;
							font-family:Helvetica;
							font-size:11px;
							line-height:125%;
							text-align:left;
						}
						.footerContainer .mcnTextContent a{
							color:#606060;
							font-weight:normal;
							text-decoration:underline;
						}
					@media only screen and (max-width: 480px){
						body,table,td,p,a,li,blockquote{
							-webkit-text-size-adjust:none !important;
						}

				}	@media only screen and (max-width: 480px){
						body{
							width:100% !important;
							min-width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[id=bodyCell]{
							padding:10px !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnTextContentContainer]{
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnBoxedTextContentContainer]{
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcpreview-image-uploader]{
							width:100% !important;
							display:none !important;
						}

				}	@media only screen and (max-width: 480px){
						img[class=mcnImage]{
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnImageGroupContentContainer]{
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageGroupContent]{
							padding:9px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageGroupBlockInner]{
							padding-bottom:0 !important;
							padding-top:0 !important;
						}

				}	@media only screen and (max-width: 480px){
						tbody[class=mcnImageGroupBlockOuter]{
							padding-bottom:9px !important;
							padding-top:9px !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
							padding-right:18px !important;
							padding-left:18px !important;
							padding-bottom:0 !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageCardBottomImageContent]{
							padding-bottom:9px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageCardTopImageContent]{
							padding-top:18px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
							padding-right:18px !important;
							padding-left:18px !important;
							padding-bottom:0 !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageCardBottomImageContent]{
							padding-bottom:9px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnImageCardTopImageContent]{
							padding-top:18px !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
							padding-top:9px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
							padding-top:18px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnBoxedTextContentColumn]{
							padding-left:18px !important;
							padding-right:18px !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=mcnTextContent]{
							padding-right:18px !important;
							padding-left:18px !important;
						}

				}	@media only screen and (max-width: 480px){
						table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
							max-width:600px !important;
							width:100% !important;
						}

				}	@media only screen and (max-width: 480px){
						h1{
							font-size:24px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						h2{
							font-size:20px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						h3{
							font-size:18px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						h4{
							font-size:16px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
							font-size:18px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						table[id=templatePreheader]{
							display:block !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
							font-size:14px !important;
							line-height:115% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
							font-size:18px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
							font-size:18px !important;
							line-height:125% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
							font-size:14px !important;
							line-height:115% !important;
						}

				}	@media only screen and (max-width: 480px){
						td[class=footerContainer] a[class=utilityLink]{
							display:block !important;
						}

				}</style></head>
				    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F2F2F2;height: 100% !important;width: 100% !important;">
				        <center>
				            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #F2F2F2;height: 100% !important;width: 100% !important;">
				                <tr>
				                    <td align="center" valign="top" id="bodyCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 20px;border-top: 0;height: 100% !important;width: 100% !important;">
				                        <!-- BEGIN TEMPLATE // -->
				                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;">
				                            <tr>
				                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                                    <!-- BEGIN PREHEADER // -->
				                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
				                                        <tr>
				                                        	<td valign="top" class="preheaderContainer" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				    <tbody class="mcnTextBlockOuter">
				        <tr>
				            <td valign="top" class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                
				                <table align="left" border="0" cellpadding="0" cellspacing="0" width="366" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                    <tbody><tr>
				                        
				                        <td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-left: 18px;padding-bottom: 9px;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;">
				                        
				                            Mensaje Datos de Pago por Validar - Promoción Cubot
				                        </td>
				                    </tr>
				                </tbody></table>
				                
				                <table align="right" border="0" cellpadding="0" cellspacing="0" width="197" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                    <tbody><tr>
				                        
				                        <td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;">
				                        </td>
				                    </tr>
				                </tbody></table>
				                
				            </td>
				        </tr>
				    </tbody>
				</table></td>
				                                        </tr>
				                                    </table>
				                                    <!-- // END PREHEADER -->
				                                </td>
				                            </tr>
				                            <tr>
				                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                                    <!-- BEGIN HEADER // -->
				                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
				                                        <tr>
				                                            <td valign="top" class="headerContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				    <tbody class="mcnImageBlockOuter">
				            <tr>
				                <td valign="top" style="padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
				                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                        <tbody><tr>
				                            <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                                
				                                    
				                                        <img align="center" alt="" src="https://gallery.mailchimp.com/a8a9d65aaa25fda05571239e7/images/logoramslex.1.png" width="319" style="max-width: 319px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">
				                                    
				                                
				                            </td>
				                        </tr>
				                    </tbody></table>
				                </td>
				            </tr>
				    </tbody>
				</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				    <tbody class="mcnDividerBlockOuter">
				        <tr>
				            <td class="mcnDividerBlockInner" style="padding: 0px 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width: 5px;border-top-style: solid;border-top-color: #004A90;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                    <tbody><tr>
				                        <td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                            <span></span>
				                        </td>
				                    </tr>
				                </tbody></table>
				            </td>
				        </tr>
				    </tbody>
				</table></td>
				                                        </tr>
				                                    </table>
				                                    <!-- // END HEADER -->
				                                </td>
				                            </tr>
				                            <tr>
				                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                                    <!-- BEGIN BODY // -->
				                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
				                                        <tr>
				                                            <td valign="top" class="bodyContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				    <tbody class="mcnTextBlockOuter">
				        <tr>
				            <td valign="top" class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                
				                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                    <tbody><tr>
				                        
				                        <td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">
				                        
				                            <h1 style="margin: 0;padding: 0;display: block;font-family: Helvetica;font-size: 40px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: -1px;text-align: left;color: #606060 !important;"><span style="font-size: 13px; line-height: 1.6em;">Estimad@ '.$consulta['nombres'].'</span></h1>

				<p style="margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">
				Sus datos han sido ingresados correctamente y son los siguientes:<br>
				<strong>Código de Reserva: </strong> '.$codigoreserva.'<br>
				<strong>Número de Operación: </strong> '.$numope.'<br>
				<strong>Fecha de Op.: </strong> '.$fecha.'<br>
				<strong>Hora de Op.: </strong> '.$hora.'<br>
				<hr>
				<strong>Equipo reservado: </strong> '.$consulta['equipo'].'<br>
				<strong>Memoria MicroSD 16GB Kingston: </strong> '.$consulta['kingston'].'<br>
				<strong>Total a PAGAR: </strong> '.$pago.'<br>
				<strong>Nombre completo:</strong> '.$consulta['nombres'].' '.$consulta['apellidos'].'<br>
				<strong>DNI: </strong> '.$consulta['dni'].'<br>
				<strong>Sexo: </strong> '.$consulta['sexo'].'<br>
				<strong>N° de Teléfono o Celular: </strong> '.$consulta['telefono'].'<br>
				<strong>Correo: </strong> '.$consulta['correo'].'<br></p>
<p style="margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">En breve validaremos los datos ingresados, luego de confirmar la veracidad de su pago. Verificado su pago le enviaremos un correo de validación de pago. Gracias por su preferencia.</p>
				                        </td>
				                    </tr>
				                </tbody></table>
				                
				            </td>
				        </tr>
				    </tbody>
				</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				    <tbody class="mcnDividerBlockOuter">
				        <tr>
				            <td class="mcnDividerBlockInner" style="padding: 0px 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width: 5px;border-top-style: solid;border-top-color: #004A90;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                    <tbody><tr>
				                        <td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                            <span></span>
				                        </td>
				                    </tr>
				                </tbody></table>
				            </td>
				        </tr>
				    </tbody>
				</table></td>
				                                        </tr>
				                                    </table>
				                                    <!-- // END BODY -->
				                                </td>
				                            </tr>
				                            <tr>
				                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                                    <!-- BEGIN FOOTER // -->
				                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
				                                        <tr>
				                                            <td valign="top" class="footerContainer" style="padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				    <tbody class="mcnTextBlockOuter">
				        <tr>
				            <td valign="top" class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                
				                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
				                    <tbody><tr>
				                        
				                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;">
				                        	<strong>NO RESPONDER ESTE MENSAJE</strong><br>
				                            <em>Copyright © RAMSLEX ENGINEERING SOLUTIONS, All rights reserved.</em><br>
				<br>
				<strong>Nuestra Dirección es:</strong><br>
				Calle Francisco Lazo # 180 – Urbanización Santo Dominguito<br>
				Trujillo - Perú<br>
				                        </td>
				                    </tr>
				                </tbody></table>
				                
				            </td>
				        </tr>
				    </tbody>
				</table></td>
				                                        </tr>
				                                    </table>
				                                    <!-- // END FOOTER -->
				                                </td>
				                            </tr>
				                        </table>
				                        <!-- // END TEMPLATE -->
				                    </td>
				                </tr>
				            </table>
				        </center>
				    </body>
				</html>';
				$to = $consulta['correo'];
				$subject = "Datos de Pago por Validar Promosmart CUBOT";
				$mainheaders	=	"Content-type: text/html; charset=utf-8\r\n";
				$mainheaders 	.= "From: RAMSLEX ENGINEERING TECHNOLOGIES";

				$resultado = mail ($to, $subject, $msg, $mainheaders);

				$msg1 = "Datos validados del cliente ".$consulta['nombres'].": \n".
						"========================================================== \n".
						"Código de Reserva: ".$codigoreserva."\n".
						"Número de Operación: ".$numope."\n".
						"Fecha: ".$fecha."\n".
						"Hora: ".$hora."\n".
						"------------------------------------------------------------------------ \n".
						"Equipo a separar".$consulta['equipo']."\n".
						"Memoria kingston: ".$consulta['kingston']."\n".
						"Total a PAGAR: ".$pago."\n".
						"Nombre completo: ".$consulta['nombres']." ".$consulta['apellidos']."\n".
						"DNI: ".$consulta['dni']."\n".
						"Sexo: ".$consulta['sexo']."\n".
						"N° de Teléfono o Celular: ".$consulta['telefono']."\n".
						"Correo: ".$consulta['correo']."\n"; 
				$to1 = "confirmacionpago.cubot@ramslex.com";
				$subject1 = "Confimación de Pago: ".$codigoreserva;
				$mainheaders1 = "From: ".$consulta['correo'];

				$resultado1 = mail ($to1, $subject1, $msg1);

				$msg3 = 	"Estimad@ ".$consulta['nombres']."<br>".
						"========================================================== <br>".
						"Código de Reserva: ".$codigoreserva."<br>".
						"Número de Operación: ".$numope."<br>".
						"Fecha de Operación: ".$fecha."<br>".
						"Hora de Operación: ".$hora."<br>".
						"------------------------------------------------------------------------ <br>".
						"Equipo separado".$consulta['equipo']."<br>".
						"Memoria kingston: ".$consulta['kingston']."<br>".
						"Total PAGADO: ".$pago."<br>".
						"Nombre completo: ".$consulta['nombres']." ".$consulta['apellidos']."<br>".
						"DNI: ".$consulta['dni']."<br>".
						"Sexo: ".$consulta['sexo']."<br>".
						"N° de Teléfono o Celular: ".$consulta['telefono']."<br>".
						"Correo: ".$consulta['correo']."<br>".
						"En breve validaremos los datos ingresados, luego de confirmar la veracidad de su pago. Verificado su pago le enviaremos un correo de validación de pago. Gracias por su preferencia.<br>";

				$envio =  array('band'=>$band,'cod'=>$codigoreserva, 'msj'=>$msg3);

				if(!$resultado){
					$success = false;
					$envio =  array('band'=>false,'cod'=>$codigoreserva, 'msj'=>'Algo salió mal, intente nuevamente 2');
				}
			}
		}
		if(!$success) {
			mysqli_rollback($conexion);
		} else {
			mysqli_commit($conexion);
		}
		mysqli_close($conexion);
	}
	else{
		$envio =  array('band'=>$band,'cod'=>null,'msj'=>'Captcha incorrecto');
	}
	echo json_encode($envio);
?>