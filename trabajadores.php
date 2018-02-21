<?php
session_start();
if(!isset($_SESSION["ctc"])) {
    header("Location: ./");
} else {
    if (isset($_SESSION["ctc"]["empresa"])) {
        if ($_SESSION["ctc"]["plan"]["id_plan"] == 1) {
            header("Location: ./");
        }
    } else {
        header("Location: ./");
    }
}
require_once('classes/DatabasePDOInstance.function.php');
require_once('slug.function.php');
include('includes/filtros_trabajadores.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>JOBBERS - Trabajadores</title>
    <?php require_once('includes/libs-css.php'); ?>
    <link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
    <style>
        .tra {
            min-height: 150px;
            margin-bottom: 30px;
        }
        .tra-f {
            min-height: 110px;
        }
        .tra, .tra-f {
            background-color: #f8f8f8 !important;
            -webkit-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        .tra:hover, .tra-f:hover {
            background-color: #DADADA !important;
        }
        .tra:hover *, .tra-f:hover * {
            /*color: #fff !important;*/
        }
    </style>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-1968505410020323",
        enable_page_level_ads: true
      });
    </script>
</head>
<body class="large-sidebar fixed-sidebar fixed-header skin-5">
    <!-- <div class="wrapper"> -->
        <!-- Preloader -->
			<div class="content-loader">
				<div class="preloader"></div>
			</div>
        <!-- Sidebar second -->
        <?php require_once('includes/sidebar-second.php'); ?>

        <!-- Header -->
        <?php require_once('includes/header.php'); ?>
        <div class="site-content" style="margin-left: 0px;">

            <!-- Content -->
            <div class="container-fluid">

            <!--Menu Filters-->

            <?php include('includes/barra_filtros_trabajador.php');?>
 
<div class="col-sm-9" style="padding: 0px;" id="contenedor_publicaciones">
 
    
</div>
    

</div>
<div class="bg-white">
<?php require_once('includes/footer.php'); ?>
</div>
</div>

</div>

<?php require_once('includes/libs-js.php'); ?>

<script>
var select_local="";
function filtro(par,v1,v2)
    {
       // $( "#contenedor_publicaciones" ).empty();
        a=v1;
        b=10;
        
        var f1=$("#area_estudio").val();
        var f2=$("#edad").val();
        var f3=$("#genero").val();
        var f4=$("#idioma").val();
        var f5=select_local;
        var f6=$("#provincia").val();
        var f7=$("#remuneracion").val();
        var f8=$("#experiecia_laboral").val();                

        $.ajax({
          method: "POST", 
          url: "ajax/filtrar.php",
          dataType:"json",
          data: { op: "filtro",estudio:f1,edad:f2,genero:f3,idioma:f4,localidad:f5,provincia:f6,remuneracion:f7,experiencia:f8,p1:a,p2:b}
        })
          .done(function( datos ) {
            //console.log(datos);
            info="";
           contador=0;
           $.each( datos, function( key, value ) { 
            pago="A consultar";
            if(datos[key]['remuneracion_pret']!=null)
            {
                pago=datos[key]['remuneracion_pret'];
            }
            contador++;
            trabajador=datos[key]['nombre']+"-"+datos[key]['id'];
            imagen=datos[key]['id_imagen']+"."+datos[key]['extension'];
            la_imagen="img/avatars/user.png";
            if(datos[key]['imagen']!=null)
            {
                la_imagen="img/profile/"+datos[key]['imagen'];
            } 
             info=info+"<div class='col-md-6 col-xs-12' style='word-break: break-all;word-wrap: break-word;'><div class='col-xs-12' style='height: 200px;background-color: #fff;padding-top: 10px;padding-bottom: 10px; margin-top: 10px;'><div class='col-xs-3 text-center'><img class='img-circle' src='"+la_imagen+"' style='width: 50px; height: 50px'></div><div class='col-xs-9'><span style='font-size:12px;'><a target='_brank' href='trabajador-detalle.php?t="+trabajador+"'><strong>"+datos[key]['nombre']+"</strong></a></span></br><span>"+datos[key]['pais']+"</span> </div><div class='col-xs-12' style='padding: 0px;padding-top: 15px;border-top: 1px dashed #d1d1d1;margin-top: 15px;'><p style='font-size: 16px;'><img src='img/coins.png' style='width: 20px;height: 20px;margin-right: 5px;'><strong>$ "+pago+"</strong></p><p style='font-size: 12px;'> "+jQuery.trim(datos[key]['sobre_mi']).substring(0, 100)+"</p><p class='text-center'><a target='_blank' href='trabajador-detalle.php?t="+trabajador+"'> Ver perfil</a></p></div></div></div>"
                
            
            }); 
           $( "#contenedor_publicaciones" ).html(info+'<div class="col-xs-12 text-center " style="padding-top:20px; padding-bottom: 20px;"><button class="btn btn-xs btn-primary" onClick="filtro(0,'+(v1-10)+',0)"><i class="fa fa-arrow-left"></i> Anterior</button><button class="btn btn-xs btn-primary" onClick="filtro(0,'+(v1+10)+',0)">Siguiente <i class="fa fa-arrow-right"></i></button></div> ');

          });
    } 
$( document ).ready(function() {    
        filtro(1,0,0); 
        select_local="";
    });

 function limpiar()
 {
     $(".control_filtro").val("");
     localidad(0);
     filtro(1,0,0);
 }
    function localidad(par)
        { 
            valor="";
            if(par=="")
            {
                valor=0;
            }else
            {
                valor=par;
            }
            $(".select_localidad").hide();         
            $("#localidad_"+valor).show(); 
            select_local=""; 
            filtro(1,0,0);           
        }
    $(".select_localidad").change(function() {
                if($("#"+$(this).attr('id')).val()==0)
                {
                    select_local="";
                }                   
                    select_local=$("#"+$(this).attr('id')).val(); 
                    filtro(1,0,0);
                }); 
</script>
</body>
</html>