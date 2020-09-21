<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";

	class Servicio
	{
		public $idServ;
		public $nombreServ;
		public $descServ;
		public $tipoServ;
		public $cantServ;
		public $eventColor;
		public $estado;
		public $servObs;
		
		#################
		# FUNCIONES GET #
		#################

		public function getIdServ() {
			if(isset($this->idServ)){
				return $this->idServ;
			}
			else{
				return "No está definido el ID del servicio.";
			}
		}
		
		public function getNombreServ(){
			if(isset($this->nombreServ)){
				return $this->nombreServ;
			}
			else{
				return "No está definido el nombre del servicio.";
			}	
		}
		
		public function getDescServ(){
			if(isset($this->descServ)){
				return $this->descServ;
			}
			else{
				return "No está definida la descripcion del servicio.";
			}	
		}
		
		public function getTipoServ(){
			if(isset($this->tipoServ)){
				return $this->tipoServ;
			}
			else{
				return "No está definido el tipo del servicio.";
			}	
		}
		
		public function getCantServ(){
			if(isset($this->cantServ)){
				return $this->cantServ;
			}
			else{
				return "No está definida la cantidad de máquinas asociadas.";
			}	
		}
		
		public function getEventColor(){
			if(isset($this->eventColor)){
				return $this->eventColor;
			}
			else{
				return "No está definido el color de la agenda.";
			}	
		}
		
		public function getEstado(){
			if(isset($this->estado)){
				return $this->estado;
			}
			else{
				return "No está definido el estado del servicio.";
			}	
		}
		
		public function getServObs(){
			if(isset($this->servObs)){
				return $this->servObs;
			}
			else{
				return "No está definida la variable observaciones.";
			}	
		}
		
		#################
		# FUNCIONES SET #
		#################
		
		private function setNombreServ($nom){
			$len = strlen($nom);
			if($len < 1){
				return "El nombre del servicio no puede estar en blanco.";
			}
			else if($len > 64){
				return "El nombre del servicio debe tener hasta 64 caracteres.";
			}
			else{
				$this->nombreServ = $nom;
				return "OK";
			}
		}
		
		private function setDescServ($desc){
			$len = strlen($desc);
			if($len > 256){
				return "La descripción del servicio debe tener hasta 64 caracteres.";
			}
			else{
				$this->descServ = $desc;
				return "OK";
			}
		}
		
		private function setTipoServ($tipo){
			$db = new DB();
			$enum_fields = $db->showColumns("servicios", "tipoServ");
			
			if($tipo != ""){				
				foreach($enum_fields as $item){
					if($tipo == $item){
						$this->tipoServ = $item;
						return "OK";
					}
				}
			}
				
			$this->tipoServ = $enum_fields[0];
			return "OK";
		}
		
		private function setCantServ($cant){
			if($cant >= 0){
				$this->cantServ = $cant;
				return "OK";
			}
			else{
				return "El numero de máquinas asociadas no es válido.";
			}
		}
		
		private function setEventColor($color){
			$len = strlen($color);
			if($len > 8){
				return "El color del servicio no debe exceder los 8 caracteres.";
			}
			else{
				$this->eventColor = $color;
				return "OK";
			}
		}
			   
		private function setEstado($estado){
			$db = new DB();
			$enum_fields = $db->showColumns("servicios", "estado");
			
			if($estado != ""){				
				foreach($enum_fields as $item){
					if($estado == $item){
						$this->estado = $item;
						return "OK";
					}
				}
			}
				
			$this->estado = $enum_fields[0];
			return "OK";
		}
			   
		private function setServObs($obs){
			$len = strlen($obs);
			if($len > 256){
				$this->servObs = $obs;				
				return "Las observaciones deben tener un máximo de 256 caracteres. Se truncó el string ingresado.";
			}
			else{
				$this->servObs = $obs;
				return "OK";
			}
		}
			   
		########################################
		# GUARDAR LOS VALORES EN BASE DE DATOS #
		########################################
			   
		public function guardar($args){
			#if(!id){
			#	return "Es necesario ingresar un ID de usuario para guardar los datos";
			#}
				
			$query1 = "INSERT INTO servicios (";
			$query2 = "VALUES (";
			$query3 = " ON DUPLICATE KEY UPDATE ";
				
			if(isset($args["idServ"])){
				$query1 = $query1 . "idServ, ";
				$query2 = $query2 . "'$args[idServ]', ";
			}
			
			if(isset($args["nombreServ"])){
				#$salida = $this->setNombreServ($args["nombreServ"], $args["idServ"]);
				$salida = $this->setNombreServ($args["nombreServ"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . "nombreServ";
				$query2 = $query2 . "'$this->nombreServ'";
				$query3 = $query3 . "nombreServ='$this->nombreServ'";
			}
				
			if(isset($args["descServ"])){
				$salida = $this->setDescServ($args["descServ"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", descServ";
				$query2 = $query2 . ", '$this->descServ'";
				$query3 = $query3 . ", descServ='$this->descServ'";
			}
				
			if(isset($args["tipoServ"])){
				$salida = $this->setTipoServ($args["tipoServ"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", tipoServ";
				$query2 = $query2 . ", '$this->tipoServ'";
				$query3 = $query3 . ", tipoServ='$this->tipoServ'";
			}
				
			if(isset($args["cantServ"])){
				$salida = $this->setCantServ($args["cantServ"]);
				if($salida != "OK"){
					return "Error al cargar los datos: " . $salida;
				}
				$query1 = $query1 . ", cantServ";
				$query2 = $query2 . ", '$this->cantServ'";
				$query3 = $query3 . ", cantServ='$this->cantServ'";
			}
				
			if(isset($args["eventColor"])){
				$salida = $this->setEventColor($args["eventColor"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", eventColor";
				$query2 = $query2 . ", '$this->eventColor'";
				$query3 = $query3 . ", eventColor='$this->eventColor'";
			}
				
			if(isset($args["estado"])){
				$salida = $this->setEstado($args["estado"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", estado";
				$query2 = $query2 . ", '$this->estado'";
				$query3 = $query3 . ", estado='$this->estado'";
			}
				
			if(isset($args["servObs"])){
				$salida = $this->setObservaciones($args["servObs"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				
				$query1 = $query1 . ", servObs";
				$query2 = $query2 . ", '$this->servObs'";
				$query3 = $query3 . ", servObs='$this->servObs'";
			}
			
			$query1 .= ") ";
			$query2 .= ") ";
			$query = $query1 . $query2 . $query3;
				
			#return $query;
			$db = new DB();
			$dbcon = $db->connect();
				
			$result = mysqli_query($dbcon, $query);

			if(!$result){
				die('Consulta no válida: ' . mysqli_error($dbcon));
			}
			else{
				echo "OK";
			}
		}
			   
		public function listarServicios(){
			echo "<table id='table1'>";
			
			$db = new DB();
			$dbcon = $db->connect();
			$query="SELECT * FROM servicios WHERE estado='VIGENTE'";
			$result=mysqli_query($dbcon, $query);

			echo "<tr>
					<td colspan='8' style='font-weight: bold;'>SERVICIOS CARGADOS: " . mysqli_num_rows($result) . "</td>
				</tr>
				<tr style='font-weight: bold;'>
					<td style='width: 50px;'>ID</td>
					<td>NOMBRE</td>
					<td style='width: 250px;'>DESCRIPCION</td>
					<td style='width: 190px;'>TIPO</td>
					<td>Maquinas Asociadas</td>
					<td>COLOR</td>
					<td colspan='2'>ACCIONES</td>
				</tr>";

			while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
				$query="SELECT COUNT(*) FROM maquinas WHERE idServicio='$fila[0]'";
				$res=mysqli_query($dbcon, $query);
				$maq = mysqli_fetch_array($res, MYSQLI_NUM);
				echo "<tr>
						<td>$fila[0]</td>
						<td id='$fila[0]-servName'>$fila[1]</td>
						<td id='$fila[0]-servDesc'>$fila[2]</td>
						<td id='$fila[0]-servTipo'>$fila[3]</td>
						<td id='$fila[0]-servCant'>$maq[0]</td>
						<td style='background-color: #$fila[5]'>$fila[5]</td>
						<td><a href='modulos/servicios/editarServicio.php?id=$fila[0]'><button class='boton2'>Editar</button></a></td>
						<td><button onclick='del($fila[0])' class='boton2'>Eliminar</button></td>
					</tr>";
			}
			echo "</table>";				
		}
		
		public function formulario(){
			echo "<table id='table1'>
					<tr>
						<td colspan='6' style='font-weight: bold;'>AGREGAR SERVICIO</td>
					</tr>
					<tr>
						<td>Servicio</td>
						<td>Descripcion</td>
						<td>Tipo</td>
						<td>Servicios simultáneos</td>
						<td>Color</td>
						<td rowspan='2'>
							<input type='button' value='Agregar' class='boton2' onClick='opcionesDeServicio(\"agregar\", null)'>
						</td>
					</tr>
					<tr>
						<td style='width: 120px;'><input type='text' id='nombreServ' maxLength='40' size='10'></td>
						
						<td style='width: 120px;'><input type='text' id='descServ' size='10'></td>
						
						<td style='width: 190px;'>
							<select id='tipoServ' style='width: 150px;'>
								<option value='none' Selected> - Elegir Tipo - </option>";
								
								$db = new DB();
								$dbcon = $db->connect();
								$enum_fields = $db->showColumns("servicios", "tipoServ");

								foreach($enum_fields as $item){
									echo "<option value='$item'>$item</option>";	
								}
								
					echo "</select>
						</td>
						<td><input type='number' id='cantServ' min='1' max='99' value='1'></td>
						<td><input type='text' class='color' id='eventColor' size='6'></td>
					</tr>
				</table>
			</form>";
		}
		
		public function getUser($id){
			if($id){
				$db = new DB();
				$dbcon = $db->connect();
				$query = "SELECT  idUsuario AS id,
								userName AS usuario,
								usuarioNombre AS nombre,
								usuarioApellido AS ap,
								usuarioDni AS dni,
								usuarioCel AS cel,
								usuarioEmail AS email,
								usuarioRol AS rol,
								usuarioTema AS tema,
								fechaAlta AS alta,
								estado AS estado,
								observaciones AS obs
						FROM usuarios WHERE idUsuario='$id'";
				
				$result = mysqli_query($dbcon, $query);
				
				if(mysqli_num_rows($result) > 0){
					return mysqli_fetch_array($result, MYSQLI_ASSOC);					
				}
				else{
					return "NO SE ENCONTRO UN USUARIO CON ID: $id";
				}
			}
			else{
				return "INGRESAR ID PARA BUSCAR USUARIO";
			}			
		}
			   
		function __construct() {
				;
		}
			   
		function __destruct() {
				;
		}
	}
?>