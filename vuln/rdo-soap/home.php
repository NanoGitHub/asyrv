<div class="thumbnail">
    <!--
        <img class="img-responsive" src="http://placehold.it/800x300" alt="">
    -->
    <div class="caption-full">
        <h3><a href="#">Referecia Directa A Objetos - SOAP</a></h3>
        
        <p align="justify">
         Esta vulnerabilidad ocurre cuando la aplicaci�n expone objetos directos a un recurso interno, como archivos, directorio, claves, etc. Tales mecanismos podr�an llevar a un atacante a predecir objetos que tambi�n se referir�an a recursos no autorizados..
�������� <br> </ p> <p> Inicie sesi�n en la aplicaci�n antes de explorar esta vulnerabilidad. </p>
         <pre> Para dar m�s valor a este ejemplo, se agreg� m�s de una forma de explotaci�n.</pre><br>
        <p>Leer m�s de Referecia Directa A Objetos:<br><br>
        <a target="_blank" href="https://www.owasp.org/index.php/Top_10_2007-Referencia_Insegura_y_Directa_a_Objetos">https://www.owasp.org/index.php/Top_10_2007-Referencia_Insegura_y_Directa_a_Objetos</a></p>
	<a target="_blank" href="https://www.securityartwork.es/2010/03/30/owasp-top-10-iv-referencia-directa-a-objetos-insegura/">https://www.securityartwork.es/2010/03/30/owasp-top-10-iv-referencia-directa-a-objetos-insegura/ </a></p>
        <a target="_blank" href="https://www.owasp.org/index.php/Testing_for_Insecure_Direct_Object_References_(OTG-AUTHZ-004)">https://www.owasp.org/index.php/Testing_for_Insecure_Direct_Object_References_(OTG-AUTHZ-004)</a></p>
      
    </div>
    </div>

    <div class="well">
        <div class="col-lg-6"> 
            <p><h4>Ver Empleados a mi Cargo:</h4> </br></br> 
                <div id='detalle'></div>
                <?php
                $current_user = isset($_SESSION['user']) ? $_SESSION['user'] : '' ;
                include('../../config.php');
                if($current_user){
			$sql = "select * from empleados limit 3";
			$stmt = $conn1->prepare($sql);
			$stmt->execute();
		        $rows = array();
			while($ro = $stmt->fetch(PDO::FETCH_ASSOC)){
                         echo "<button type='button' class='btn btn-success btn-block' id='".base64_encode($ro['id'])."' onclick='Obtener_Datos_Empleado(this.id)'>".$ro['nombre']."</button>";
			}
           
                }else{
                    echo "<b> Necesitas iniciar sesion para ver los datos del personal a tu cargo... </b>";
                }
                ?>
            </p>
        </div>
        
        <hr>
        
    </div>



<?php include_once('../../about.html'); ?>


<script>
function Obtener_Datos_Empleado(empleado){  
 var soapMessage =
  '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:MyServicewsdl">'+
   '<soapenv:Header/>'+
   '<soapenv:Body>'+
      '<urn:ObtenerEmpleados>'+
        '<id>'+empleado+'</id>'+
      '</urn:ObtenerEmpleados>'+
   '</soapenv:Body>'+
 '</soapenv:Envelope>';

 $.ajax({
    url: "http://<?php echo $_SERVER['SERVER_NAME']; ?>/asyrv/vuln/rdo-soap/metodo.php",
    type: "POST",
    dataType: "xml",
    contentType: "text/xml; charset=\"utf-8\"",
    SOAPAction: "urn:MyServicewsdl#empleados",
    data: soapMessage,
    success: function(req){
        objeto = $(req).find('return').text();
        var obj = JSON.parse(objeto );
        tabla = "";
	tabla += "<table class='table'>";
	tabla += "<tr>";
        tabla += "<td rowspan='3'><img src='"+obj.foto+"' ></td><td>Nombre:</td><td>"+obj.nombre+"</td>";
        tabla += "</tr>";
        tabla += "<tr>";
        tabla += "<td>Edad:</td><td>"+obj.edad+"</td>";
        tabla += "</tr>";
        tabla += "<tr>";
        tabla += "<td>Salario:</td><td>"+obj.salario+"</td>";
        tabla += "</tr>";
        tabla += "</table>";
        

        $('#detalle').html(tabla);
    }
 });

}
</script>
