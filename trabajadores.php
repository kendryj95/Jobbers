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
        <!-- Sidebar -->
        <?php if ($_SESSION['ctc']['type'] == 1):
			require_once ('includes/sidebar.php');
			?>
			<style>
				.site-content{
					margin-left:220px !important;
				}
				@media(max-width: 1024px){
					.site-content{
						margin-left: 0px !important;
					}
				}
			</style>
			<?php endif ?>

        <!-- Sidebar second -->
        <?php require_once('includes/sidebar-second.php'); ?>

        <!-- Header -->
        <?php require_once('includes/header.php'); ?>
        <div class="site-content bg-white" style="margin-left: 0px;">
            <!-- Content -->
            <div class="content-area p-y-1">

                <div class="container-fluid">
                   
                </div>

                <div class="container-fluid"> 
        </div>
 
<div class="col-md-9" style="padding: 0px;" id="contenedor_publicaciones">
 
    
  
  
   

</div>
    
    <!--Menu right-->

   <?php include('includes/barra_filtros_trabajador.php');?>

</div>

</div>
<?php require_once('includes/footer.php'); ?>
</div>
</div>

<?php require_once('includes/libs-js.php'); ?>

<script>

function filtro(par,v1,v2)
    {
       // $( "#contenedor_publicaciones" ).empty();
        a=v1;
        b=10;
        
        var f1=$("#area_estudio").val();
        var f2=$("#edad").val();
        var f3=$("#genero").val();
        var f4=$("#idioma").val();
        var f5=$("#localidad").val();
        var f6=$("#provincia").val();
        var f7=$("#remuneracion").val();          

        $.ajax({
          method: "POST", 
          url: "ajax/filtrar.php",
          dataType:"json",
          data: { op: "filtro",estudio:f1,edad:f2,genero:f3,idioma:f4,localidad:f5,provincia:f6,remuneracion:f7,p1:a,p2:b}
        })
          .done(function( datos ) {
            //alert(datos);
            info="";
           contador=0;
           $.each( datos, function( key, value ) { 

         contador++;
            trabajador=datos[key]['nombre']+"-"+datos[key]['id'];
            imagen=datos[key]['id_imagen']+"."+datos[key]['extension'];
          
             info=info+"<div class='col-sm-6' style='word-break: break-all;word-wrap: break-word;margin-top: 10px;'><div class='col-xs-12' style='height: 200px;background-color: #fff;padding-top: 10px;padding-bottom: 10px;'><div class='col-xs-3 text-center'><img class='img-circle' src='img/profile/"+datos[key]['imagen']+"' style='width: 50px;'></div><div class='col-xs-9'><span style='font-size:12px;'><a target='_brank' href='trabajador-detalle.php?t="+trabajador+"'><strong>"+datos[key]['nombre']+"</strong></a></span></br><span>"+datos[key]['pais']+"</span> </div><div class='col-xs-12' style='padding: 0px;padding-top: 15px;border-top: 1px dashed #d1d1d1;margin-top: 15px;'><p style='font-size: 16px;'><img src='img/coins.png' style='width: 20px;height: 20px;margin-right: 5px;'><strong>$ "+datos[key]['remuneracion_pret']+"</strong></p><p style='font-size: 12px;'> "+jQuery.trim(datos[key]['sobre_mi']).substring(0, 100)+"</p><p class='text-center'><a target='_blank' href='trabajador-detalle.php?t="+trabajador+"'> Ver perfil</a></p></div></div></div>"
                
            
            }); 
           $( "#contenedor_publicaciones" ).html(info+'<div class="col-xs-12 text-center " style="padding-top:20px;"><button class="btn btn-xs btn-primary" onClick="filtro(0,'+(v1-10)+',0)">Anterior</button><button class="btn btn-xs btn-primary" onClick="filtro(0,'+(v1+10)+',0)">Siguiente</button></div> ');

          });
    } 
$( document ).ready(function() {    
 filtro(1,0,0);
});


/*
    var limit_ini = 0;

    $(document).ready(function() {

        $('.complete').hide();

        $('.more').on('click',function(){
            console.log('boton');
            var btnMore = $(this).find("a").text();

            if (btnMore == 'Leer más...') {
                $(this).find("a").text('Retraer...');
            } else {
                $(this).find("a").text('Leer más...');
            }

                //$(this).parent().siblings('summary').find('pspan.complete').toggle('slow');
                    //$(this).closest('span.complete').toggle();
                    //$('.more').text('Leer más...');
                //});
            $(this).parent().find('.complete').toggle('slow');
        });

        $('.pagination-next').on('click',function(){

            limit_ini += 15;

            $.ajax({
                url: 'ajax/trabajadores.php',
                type: 'POST',
                dataType: 'json',
                data: {op: 1, limit_ini: limit_ini},
                success: function(response){

                    var html = "";

                    var json_length = Object.keys(response.trabajador).length;

                    if (json_length > 0) {
                        response.trabajador.forEach(function(e){
                            html += e;
                        });
                    } else {
                        $('.pagination-next').remove();
                    }



                    $('#box-trab').append(html);
                },
                error: function(error){
                    console.log('Error en el ajax: '+error);
                }
            });


        });

    });
*/
</script>
</body>
</html>