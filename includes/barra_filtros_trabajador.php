<div class="col-sm-3" style="background-color: #fff;padding: 10px;margin-top: 10px;">
    <div class="text-center" style="border-bottom: 1px dashed #adadad;padding-bottom: 15px;">
        <img src="img/filter.png"></br>
        <span><strong>Encuentra tu Jobber</strong></span></br>

    </div>
    <br/>
     <label><strong>Experiencia laboral</strong></label></br>
        <select  onChange="filtro(1,0,0)" id="experiecia_laboral" class="form-control  control_filtro">
            <option value="">Seleccionar</option> 
            <?php foreach ($experiencia_laboral as $key) {
                if($key['nombre']!="")
                {
                    echo'<option value="'.$key["id_actividad_empresa"].'">'.$key["nombre"]." ".' </option>';
                }
            }?>
        </select> 
    <label><strong>Area de estudio</strong></label></br>
        <select id="area_estudio" class="form-control control_filtro" onChange="filtro(1,0,0)">
            <option value="">Seleccionar</option>
            <?php foreach ($datos_area_estudio as $key) {
                if($key['nombre']!="")
                {
                    echo'<option value="'.$key["id_area_estudio"].'">'.$key["nombre"]." ".' </option>';
                }
            }?> 
        </select> 

    <label><strong>Nivel de estudio</strong></label></br>
        <select id="nivel_estudio" class="form-control control_filtro" onchange="filtro(1,0,0,this)">
            <option value="">Seleccionar</option>
            <?php foreach ($datos_nivel_estudio as $key) {
                if($key['nombre']!="")
                {
                    echo'<option value="'.$key["id"].'">'.$key["nombre"]." ".' </option>';
                }
            }?> 
        </select>

        <label><strong>Años de graduados</strong></label></br>
        <select id="anio_graduados" class="form-control control_filtro" onchange="filtro(1,0,0)" disabled>
            <option value="">Seleccionar</option>
            <option value="0">Recien graduado</option>
             <option value="1-3">1 a 3 años</option>
             <option value="4-6">4 a 6 años</option> 
             <option value="7">7+ años</option> 
        </select>  
        <label><strong>Edad</strong></label></br>
        <select onChange="filtro(1,0,0)" id="edad" class="form-control  control_filtro">
            <option value="">Seleccionar</option>
            <?php
            $dieciocho=0;
            $vente_tres=0;
            $trenta_uno=0;
            $trenta_seis=0;
                foreach ($datos_edad as $key) {
                    if($key['edad']>17 && $key['edad']<24)
                    {
                        $dieciocho=$dieciocho+$key['cantidad'];                        
                    }
                    if($key['edad']>23 && $key['edad']<31)
                    {
                        $vente_tres=$vente_tres+$key['cantidad'];                        
                    }
                    if($key['edad']>31 && $key['edad']<37)
                    {
                        $trenta_uno=$trenta_uno+$key['cantidad'];                        
                    }
                    if($key['edad']>36 )
                    {
                        $trenta_seis=$trenta_seis+$key['cantidad'];                        
                    }
                }
              
                echo '<option value="1823">De 18 a 23 años  </option>';
                echo '<option value="2430">De 24 a 30 años  </option>';
                echo '<option value="3136">De 31 a 36 años  </option>';
                echo '<option value="M37">Mayor de 37 años  </option>';
            ?>
        </select>
      <!--
        <label><strong>Etapa</strong></label></br>
        <select class="form-control">
            <option value="">Seleccionar</option>
        </select> 
      -->
        <label><strong>Genero</strong></label></br>
        <select  onChange="filtro(1,0,0)" id="genero" class="form-control  control_filtro">
            <option value="">Seleccionar</option>
            <?php echo"<option value='1'>Masculino  </option>"?>
            <?php echo"<option value='2'>Femenino  </option>"?>
        </select>
          <label><strong>Idioma</strong></label></br>
        <select  onChange="filtro(1,0,0)" id="idioma" class="form-control  control_filtro">
            <option value="">Seleccionar</option>
            <?php foreach ($datos_idiomas as $key) {
                echo'<option value="'.$key["id_idioma"].'">'.$key["nombre"]." ".' </option>';
            }?>
        </select> 
         <label><strong>Provincias</strong></label></br>
        <select  onChange="filtro(1,0,0),localidad(this.value)" id="provincia" class="form-control  control_filtro">
            <option value="">Seleccionar</option> 
            <?php foreach ($datos_provincia as $key) {
                if($key['nombre']!="")
                {
                    echo'<option value="'.$key["provincia"].'">'.$key["nombre"]." ".' </option>';
                }
            }?>
        </select> 

        
        <label><strong>Localidades</strong></label></br>
        <?php  include('select_localidades.php');?>
       <!-- <select onChange="filtro(1,0,0)" id="localidad" class="form-control  control_filtro">
            <option value="">Seleccionar</option>
             
        </select>-->
         
        <label><strong>Remuneraciones</strong></label></br>
        <select  onChange="filtro(1,0,0)" id="remuneracion" class="form-control  control_filtro">

            <option value="">Seleccionar</option>
            <?php 
            $v1=0;
            $v2=0;
            $v3=0;
            $v4=0;
            $v5=0;
            $v6=0;
            foreach ($datos_area_remuneracion as $key) {
                 if($key['nombre']>-1 && $key['nombre']<2001){$v1=$v1+1;}
                 if($key['nombre']>2000 && $key['nombre']<5001){$v2=$v2+1;}
                 if($key['nombre']>5000 && $key['nombre']<10001){$v3=$v3+1;}

                 if($key['nombre']>10000 && $key['nombre']<15001){$v4=$v4+1;}
                 if($key['nombre']>15000 && $key['nombre']<20001){$v5=$v5+1;}
                 if($key['nombre']>20000){$v6=$v6+1;}
            }?>
            <option value="02000">$0 - $2000  </option>
            <option value="20015000">$2001 - $5000  </option>
            <option value="500110000">$5001 - $10000  </option>

            <option value="1000115000">$10001 - $15000  </option>
            <option value="1500120000">$15001 - $20000  </option>
            <option value="M20001">$20001 o más  </option>
        </select>    
    <button class="btn btn-outline btn-primary" id="filterButton" style="height: 38px;margin-bottom: 10px; margin-top: 10px; width: 100%" onclick="limpiar()"><i class="fa fa-filter fa-lg filters"></i> <i class="fa fa-eraser fa-lg clear-filters" style="display:none;">
    	</i> Limpiar Filtros
    </button>
    <a class="btn btn-outline btn-primary" style="height: 38px;margin-bottom: 10px; margin-top: 10px; width: 100%" href="empresa/publicaciones.php"><i class="fa fa-reply"></i> Volver</a>
   
</div>