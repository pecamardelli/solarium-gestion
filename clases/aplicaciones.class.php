<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";

	class Aplicaciones
	{
		public $ventilacion;
		public $iluminacion;
		public $espera;
		public $puertosArduino;
		public $agStart;
		public $agEnd;
		public $agView;
		
		###################################
		# FUNCIONES DE RETORNO DE VALORES #
		###################################

		public function getVentilacion(){
			if(isset($this->ventilacion)){
				return $this->ventilacion;
			}
			else{
				return 4;
			}
		}
		
		public function getIluminacion(){
			if(isset($this->iluminacion)){
				return $this->iluminacion;
			}
			else{
				return 20;
			}	
		}
		
		public function getEspera(){
			if(isset($this->espera)){
				return $this->espera;
			}
			else{
				return 5;
			}	
		}
		
		public function getPuertosArduino(){
			if(isset($this->puertosArduino)){
				return $this->puertosArduino;
			}
			else{
				return 3;
			}	
		}
		
		public function getAgStart(){
			if(isset($this->agStart)){
				return $this->agStart;
			}
			else{
				return 10;
			}	
		}
		
		public function getAgEnd(){
			if(isset($this->agEnd)){
				return $this->agEnd;
			}
			else{
				return 23;
			}	
		}
		
		public function getAgView(){
			if(isset($this->agView)){
				return $this->agView;
			}
			else{
				return "agendaDay";
			}	
		}
		
		
		#################################
		# FUNCIONES DE SETEO DE VALORES #
		#################################
		
		private function setVentilacion($ventilacion){
			if($ventilacion < 1){
				return "El tiempo de ventilación debe ser mayor a 1 minuto. ($ventilacion)";
			}
			else if($ventilacion > 60){
				return "El tiempo de ventilación debe ser menor a 60 minutos.";
			}
			else{		
				$this->ventilacion = $ventilacion;
				return "OK";
			}
		}
		
		private function setIluminacion($iluminacion){
			if($iluminacion < 1){
				return "El tiempo de iluminación debe ser mayor a 10 segundos.";
			}
			else if($iluminacion > 300){
				return "El tiempo de iluminación debe ser menor a 300 segundos.";
			}
			else{		
				$this->iluminacion = $iluminacion;
				return "OK";
			}
		}
		
		private function setEspera($espera){
			if($espera < 1){
				return "El tiempo de espera debe ser mayor a 1 minutos.";
			}
			else if($espera > 20){
				return "El tiempo de espera debe ser menor a 20 minutos.";
			}
			else{		
				$this->espera = $espera;
				return "OK";
			}
		}
		
		private function setPuertosArduino($puertosArduino){
			if($puertosArduino < 0){
				return "La cantidad de puertos de Arduino no puede ser negativa.";
			}
			else if($puertosArduino > 99){
				return "No creo que haya más de 99 puertos de Arduino.";
			}
			else{		
				$this->puertosArduino = $puertosArduino;
				return "OK";
			}
		}
		
		private function setAgStart($start){
			$db = new DB();
			$end = $db->getConfig("intValue", "hora_fin_agenda");
			
			if($start < 0){
				return "La hora de inicio de la agenda no puede ser negativa.";
			}
			else if($start > $end){
				return "La hora de inicio de la agenda no puede ser superior a la hora del final. $agStart - $agEnd";
			}
			else{		
				$this->agStart = $start;
				return "OK";
			}
		}
		
		private function setAgEnd($end){
			$db = new DB();
			$start = $db->getConfig("intValue", "hora_inicio_agenda");
			if($end < $start){
				return "La hora del final de la agenda no puede ser menor a la hora de inicio. $agStart - $agEnd";
			}
			else if($end > 24){
				return "La hora de final de la agenda no puede ser superior a las 24 horas.";
			}
			else{		
				$this->agEnd = $end;
				return "OK";
			}
		}
		
		private function setAgView($agView){			
			if($agView != "agendaDay" && $agView != "agendaWeek" && $agView != "month"){
				return "Vista de la agenda inválida.";
			}
			else{		
				$this->agView = $agView;
				return "OK";
			}
		}
			   
		########################################
		# GUARDAR LOS VALORES EN BASE DE DATOS #
		########################################
			   
		public function guardarConfig($args){
			$db = new DB();
				
			if($args["vent"]){
				$salida = $this->setVentilacion($args["vent"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("intValue", $this->getVentilacion(), "tiempo_ventilacion");
			}
			
			if($args["ilum"]){
				$salida = $this->setIluminacion($args["ilum"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("intValue", $this->getIluminacion(), "tiempo_iluminacion");
			}
				
			if($args["wait"]){
				$salida = $this->setEspera($args["wait"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("intValue", $this->getEspera(), "espera_turno");
			}
				
			if($args["ports"]){
				$salida = $this->setPuertosArduino($args["ports"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("intValue", $this->getPuertosArduino(), "puertos_arduino");
			}
				
			if($args["agStart"]){
				$salida = $this->setAgStart($args["agStart"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("intValue", $this->getAgStart(), "hora_inicio_agenda");
			}
				
			if($args["agEnd"]){
				$salida = $this->setAgEnd($args["agEnd"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("intValue", $this->getAgEnd(), "hora_fin_agenda");
			}
				
			if($args["agView"]){
				$salida = $this->setAgView($args["agView"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$db->setConfig("charValue", $this->getAgView(), "vista_agenda");
			}
			
			echo "OK";
		}
			   
		public function mostrarConfig(){
			echo "<center>
				<table id='table1'>
					<tr>
						<td style='font-weight: bold;'>OPCIONES DE CONTROLADOR</td>
						<td>
							<a href='aplicaciones.php'>
								<img id='imgEffects' src='imagenes/$_SESSION[tema]/boton_volver.png'>
							</a>
						</td>
					</tr>
					<tr>
						<td style='width: 300px'>Tiempo de ventilacion en minutos: </td>";
			$db = new DB();
			$dbcon = $db->connect();
			$query="SELECT intValue FROM config WHERE descConfig = 'tiempo_ventilacion'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$value = mysqli_fetch_array($result, MYSQLI_NUM);
		
			$query="SELECT intValue FROM config WHERE descConfig = 'tiempo_iluminacion'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$value2 = mysqli_fetch_array($result, MYSQLI_NUM);
		
			$query="SELECT intValue FROM config WHERE descConfig = 'espera_turno'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$value3 = mysqli_fetch_array($result, MYSQLI_NUM);
		
			$query="SELECT intValue FROM config WHERE descConfig = 'puertos_arduino'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$value4 = mysqli_fetch_array($result, MYSQLI_NUM);
		
			$query="SELECT intValue FROM config WHERE descConfig = 'hora_inicio_agenda'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$start = mysqli_fetch_array($result, MYSQLI_NUM);

			$query="SELECT intValue FROM config WHERE descConfig = 'hora_fin_agenda'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$end = mysqli_fetch_array($result, MYSQLI_NUM);
		
			$query="SELECT charValue FROM config WHERE descConfig = 'vista_agenda'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$view = mysqli_fetch_array($result, MYSQLI_NUM);
		
			echo "<td style='width: 100px'><input type='number' name='ventilacion' id='vent' min='1' max='10' size='3' value='$value[0]'></td>
				</tr>
				<tr>
					<td style='width: 300px'>Tiempo de iluminacion en segundos: </td>
					<td style='width: 100px'><input type='number' name='iluminacion' id='ilum' min='10' max='99' size='3' value='$value2[0]'></td>
				</tr>
				<tr>
					<td style='width: 300px'>Minutos de espera antes de empezar turno: </td>
					<td style='width: 100px'><input type='number' name='espera' id='wait' min='1' max='10' size='3' value='$value3[0]'></td>
				</tr>
				<tr>
					<td style='width: 300px'>Cantidad de puertos del Arduino: </td>
					<td style='width: 100px'><input type='number' name='puertos' id='ports' min='1' max='10' size='3' value='$value4[0]'></td>
				</tr>
				<tr>
					<td colspan='2' style='font-weight: bold;'>OPCIONES DE LA AGENDA</td>
				</tr>
				<tr>
					<td style='width: 300px'>Hora de inicio: </td>
					<td style='width: 100px'><input type='number' name='puertos' id='agStart' min='0' max='24' size='3' value='$start[0]'></td>
				</tr>
				<tr>
					<td style='width: 300px'>Hora del final: </td>
					<td style='width: 100px'><input type='number' name='puertos' id='agEnd' min='0' max='24' size='3' value='$end[0]'></td>
				</tr>
				<tr>
					<td style='width: 300px'>Vista por defecto: </td>
					<td style='width: 100px'>
						<select style='width: 80px' id='agView'>";
						
			if($view[0] == "agendaDay"){
				echo "<option value='agendaDay' selected>Diario</option>";
			}
			else{
				echo "<option value='agendaDay'>Diario</option>";
			}

			if($view[0] == "agendaWeek"){
				echo "<option value='agendaWeek' selected>Semanal</option>";
			}
			else{
				echo "<option value='agendaWeek'>Semanal</option>";
			}

			if($view[0] == "month"){
				echo "<option value='month' selected>Mensual</option>";
			}
			else{
				echo "<option value='month'>Mensual</option>";
			}
			echo "</select>
							</td>
					</tr>
					<tr>
						<td colspan=2><input type='button' id='imgEffects' onclick='guardarConfiguraciones()' class='boton2' value='Guardar'></td>
					</tr>
				</table>
			</center>";
		}
			   
		function __construct() {
				;
		}
			   
		function __destruct() {
				;
		}
	}
?>