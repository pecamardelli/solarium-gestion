<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";

	class Clientes
	{
		public $idCliente;
		public $tipoCliente;
		public $nombreCliente;
		public $apellidoCliente;
		public $dniCliente;
		public $emailCliente;
		public $telCliente;
		public $idZona;
		public $ctaCte;
		public $estado;
		public $fechaAlta;
		public $idKnownBy;
		public $balance;
		public $observaciones;
		
		###################################
		# FUNCIONES DE RETORNO DE VALORES #
		###################################

		public function getIdCliente() {
			if(isset($this->idCliente)){
				return $this->idCliente;
			}
			else{
				return "No está definido el ID del cliente.";
			}
		}
		
		public function getTipoCliente(){
			if(isset($this->tipoCliente)){
				return $this->tipoCliente;
			}
			else{
				return "No está definido el tipo de cliente.";
			}	
		}
		
		public function getNombreCliente(){
			if(isset($this->nombreCliente)){
				return $this->nombreCliente;
			}
			else{
				return "No está definido el nombre del cliente.";
			}	
		}
		
		public function getApellidoCliente(){
			if(isset($this->apellidoCliente)){
				return $this->apellidoCliente;
			}
			else{
				return "No está definido el apellido del cliente.";
			}	
		}
		
		public function getDniCliente(){
			if(isset($this->dniCliente)){
				return $this->dniCliente;
			}
			else{
				return "No está definido el DNI del cliente.";
			}	
		}
		
		public function getTelCliente(){
			if(isset($this->telCliente)){
				return $this->telCliente;
			}
			else{
				return "No está definido el numero de telefono del cliente.";
			}	
		}
		
		public function getEmailCliente(){
			if(isset($this->emailCliente)){
				return $this->emailCliente;
			}
			else{
				return "No está definido el email del cliente.";
			}	
		}
		
		public function getIdZona(){
			if(isset($this->idZona)){
				return $this->idZona;
			}
			else{
				return "No está definida la zona donde vive el cliente.";
			}	
		}
		
		public function getCtaCte(){
			if(isset($this->ctaCte)){
				return $this->ctaCte;
			}
			else{
				return "No está definido el estado de la cuenta corriente del cliente.";
			}	
		}
		
		public function getFechaAlta(){
			if(isset($this->fechaAlta)){
				return $this->fechaAlta;
			}
			else{
				return "No está definida la fecha de alta del cliente.";
			}	
		}
		
		public function getEstado(){
			if(isset($this->estado)){
				return $this->estado;
			}
			else{
				return "No está definido el estado del cliente.";
			}	
		}
		
		public function getObservaciones(){
			if(isset($this->Observaciones)){
				return $this->Observaciones;
			}
			else{
				return "No está definida la variable Observaciones del cliente.";
			}	
		}
		
		public function getIdKnownBy(){
			if(isset($this->idKnownBy)){
				return $this->idKnownBy;
			}
			else{
				return "No está definido como nos conocio cliente.";
			}	
		}
		
		public function getBalance(){
			if(isset($this->balance)){
				return $this->balance;
			}
			else{
				return "No está definido el balance de la cuenta corriente del cliente.";
			}	
		}
		
		private function getThead($rows){
			if(!isset($db)){
				$db = new DB();
				$dbcon = $db->connect();
			}
			
			echo "<thead>
					<tr>
						<td colspan='10' style='font-weight: bold;'>CLIENTES CARGADOS: $rows</td>
						<td><input type='button' value='Agregar' class='boton2' onClick='acciones(\"agregar\")'></td>
					</tr>
					<tr>
						<td style='width: 50px;'></td>
						<td><input type='text' id='filtroNom' class='filtros' value='' size='15' onKeyPress='return enter(event)'></td>
						<td><input type='text' id='filtroDni' class='filtros' value='' size='10' onKeyPress='return enter(event)'></td>
						<td><input type='text' id='filtroEmail' class='filtros' value='' size='20' onKeyPress='return enter(event)'></td>
						<td><input type='text' id='filtroTel' class='filtros' value='' size='10' onKeyPress='return enter(event)'></td>
						<td id='zona'>
						<select id='filtroZona' style='width: 120px;' onchange='cambiarZona(this.value)' onKeyPress='return enter(event)'>
							<option value='' Selected></option>";

						$query="SELECT idConf, charValue FROM config WHERE descConfig = 'zona'";
						$res=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
						while($fila2 = mysqli_fetch_array($res, MYSQLI_NUM)){
							echo "<option value='$fila2[0]'>$fila2[1]</option>";
						}
					echo "</select>
					</td>

						<td>
							<select id='filtroTipo' name='filtroTipo' class='filtros'  style='width: 120px;' onKeyPress='return enter(event)'>
								<option value='' Selected></option>";
								$db = new DB();
								$enum_fields = $db->showColumns("clientes", "tipoCliente");

								foreach($enum_fields as $item){
									echo "<option value='$item'>$item</option>";	
								}
					echo "</select>
						</td>
						<td id='filtroknownBy'>
						<select id='filtroKnownBy' name='nosConocioPor' style='width: 120px;' onchange='cambiarKnownBy(this.value)' onKeyPress='return enter(event)'>
							<option value='' Selected></option>";
								$query="SELECT idConf, charValue FROM config WHERE descConfig = 'nos_conocio_por'";
								$res=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
								while($fila2 = mysqli_fetch_array($res, MYSQLI_NUM)){
										echo "<option value='$fila2[0]'>$fila2[1]</option>";
								}
					echo "</select>
					</td>
						<td>
						<select id='filtroEstado' style='width: 110px;' onKeyPress='return enter(event)'>
							<option value='' Selected></option>";
							$db = new DB();
							$enum_fields = $db->showColumns("clientes", "estado");

							foreach($enum_fields as $item){
								echo "<option value='$item'>$item</option>";	
							}
					echo "</select>
						</td>
						<td>
							<select id='filtroBalance' style='width: 50px;' onKeyPress='return enter(event)'>
								<option value='' Selected></option>
								<option value='>'>+</option>
								<option value='='>=0</option>
								<option value='<'>-</option>
							</select>
						</td>
						<td><input type='button' value='Filtrar' class='boton2' onClick='acciones(\"filtrar\")'></td>
					</tr>
					<tr style='font-weight: bold;'>
						<td style='width: 40px;'>NRO</td>
						<td>NOMBRE</td>
						<td>DNI</td>
						<td>E-MAIL</td>
						<td>TELEFONOS</td>
						<td>ZONA</td>
						<td>TIPO</td>
						<td>NOS CONOCIÓ POR</td>
						<td style='width: 55px;'>ESTADO</td>
						<td style='width: 50px;'>BALANCE</td>
						<td>ACCIONES</td>
					</tr>
				</thead>";
			
		}
		#################################
		# 			 METODOS			#
		#################################
		
		private function setTipoCliente($tipo){
			$db = new DB();
			$enum_fields = $db->showColumns("clientes", "tipoCliente");
			
			if($tipo != ""){				
				foreach($enum_fields as $item){
					if($tipo == $item){
						$this->tipoCliente = $item;
						return "OK";
					}
				}
			}
				
			$this->tipoCliente = "NORMAL";
			return "El tipo de cliente ingresado no es válido. Usado por defecto " . $this->tipoCliente;
		}
		
		private function setNombreCliente($nombre){
			$len = strlen($nombre);
			if($len < 0){
				return "El nombre del cliente no debe estar en blanco.";
			}
			else if($len > 128){
				return "El nombre del usuario debe tener hasta 128 caracteres.";
			}
			else{
				$this->nombreCliente = $nombre;
				return "OK";
			}
		}
		
		private function setApellidoCliente($apellido){
			$len = strlen($apellido);
			if($len < 0){
				return "El apellido del usuario no debe estar en blanco.";
			}
			else if($len > 128){
				return "El apellido del usuario debe tener hasta 128 caracteres.";
			}
			else{
				$this->apellidoCliente = $apellido;
				return "OK";
			}
		}
		
		private function setDniCliente($dni){
			$len = strlen($dni);
			if($len < 1){
				return "El DNI del cliente es requerido.";
			}
			else if($len > 16){
				return "El DNI del usuario debe tener hasta 16 caracteres y ser numérico.";
			}
			else{
				if(is_numeric($dni)){
					$this->dniCliente = $dni;
					return "OK";
				}
				else{
					return "El DNI del cliente debe ser numérico";
				}
			}
		}
		
		private function setTelCliente($cel){
			$len = strlen($cel);
			if($len > 32){
				return "El número de celular del usuario debe tener hasta 32 caracteres y ser numérico.";
			}
			else if($len < 1){
				$this->telCliente = "";
				return "OK";
			}
			else{
				if(is_numeric($cel)){
					$this->telCliente = $cel;
					return "OK";
				}
				else{
					return "El número de celular del usuario debe ser numérico";
				}
			}
		}
		
		private function setEmailCliente($email){
			$len = strlen($email);
			if($len > 64){
				return "La dirección de correo electrónico del cliente debe tener hasta 64 caracteres.";
			}
			else if($len < 1){
				$this->emailCliente = "";
				return "OK";
			}
			else{
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				  return "La dirección de correo electrónico ingresada no tine un formato válido.";
				}
				else{
					$this->emailCliente = $email;
					return "OK";
				}
			}
		}
		
		private function setIdZona($zona){
			if(!is_numeric($zona)){
				$db = new DB();
				$dbcon = $db->connect();
				$query = "INSERT INTO config (descConfig, charValue) VALUES ('zona', '$zona')";
				$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
				$zona = $dbcon->insert_id;
			}
			
			if($zona > 0){
				$this->idZona = $zona;
				return "OK";
			}
			else{
				return "Número de ID de la zona debe ser mayor a 1.";
			}
		}
		
		private function setIdKnownBy($knownBy){
			if(!is_numeric($knownBy)){
				$db = new DB();
				$dbcon = $db->connect();
				$query = "INSERT INTO config (descConfig, charValue) VALUES ('idKnownBy', '$knownBy')";
				$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
				$knownBy = $dbcon->insert_id;
			}
			
			if($knownBy > 0){
				$this->idKnownBy = $knownBy;
				return "OK";
			}
			else{
				return "Número de ID de 'Nos conocio por' debe ser mayor a 1.";
			}
		}
			   
		private function setCtaCte($CtaCte){
			$db = new DB();
			$enum_fields = $db->showColumns("clientes", "ctaCte");
			
			if($tema != ""){				
				foreach($enum_fields as $item){
					if($tema == $item){
						$this->ctaCte = $item;
						return "OK";
					}
				}
			}
				
			$this->ctaCte = $enum_fields[0];
			return "OK";
		}
			   
		private function setEstado($estado){
			$db = new DB();
			$enum_fields = $db->showColumns("clientes", "estado");
			
			if($estado != ""){				
				foreach($enum_fields as $item){
					if($estado == $item){
						$this->estado = $item;
						return "OK";
					}
				}
			}
				
			$this->estado = $enum_fields[0];
			return "El estado del cliente no es válido. Usado por defecto " . $this->estado;
		}
			   
		private function setObservaciones($obs){
			$len = strlen($obs);
			if($len > 256){
				$this->Observaciones = $obs;				
				return "Las observaciones deben tener un máximo de 256 caracteres. Se truncó el string ingresado.";
			}
			else{
				$this->Observaciones = $obs;
				return "OK";
			}
		}
		
		private function setBalance($bal){
			$this->balance = $bal;
			return "OK";
		}
			   
		########################################
		# GUARDAR LOS VALORES EN BASE DE DATOS #
		########################################
			   
		public function guardarCliente($args){
				
			$query1 = "INSERT INTO clientes (";
			$query2 = "VALUES (";
			$query3 = " ON DUPLICATE KEY UPDATE ";
				
			if(isset($args["id"])){
				$query1 = $query1 . "idCliente, ";
				$query2 = $query2 . "'$args[id]', ";
			}
			
			if(isset($args["tipo"])){
				$salida = $this->setTipoCliente($args["tipo"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . "tipoCliente";
				$query2 = $query2 . "'$this->tipoCliente'";
				$query3 = $query3 . "tipoCliente='$this->tipoCliente'";
				$coma = ",";
			}
				
			if(isset($args["nom"])){
				$salida = $this->setNombreCliente($args["nom"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", nombreCliente";
				$query2 = $query2 . ", '$this->nombreCliente'";
				$query3 = $query3 . "$coma nombreCliente='$this->nombreCliente'";
				$coma = ",";
			}
				
			if(isset($args["ap"])){
				$salida = $this->setApellidoCliente($args["ap"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", apellidoCliente";
				$query2 = $query2 . ", '$this->apellidoCliente'";
				$query3 = $query3 . "$coma apellidoCliente='$this->apellidoCliente'";
				$coma = ",";
			}
				
			if(isset($args["dni"])){
				$salida = $this->setDniCliente($args["dni"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", dniCliente";
				$query2 = $query2 . ", '$this->dniCliente'";
				$query3 = $query3 . "$coma dniCliente='$this->dniCliente'";
				$coma = ",";
			}
				
			if(isset($args["email"])){
				$salida = $this->setEmailCliente($args["email"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", emailCliente";
				$query2 = $query2 . ", '$this->emailCliente'";
				$query3 = $query3 . "$coma emailCliente='$this->emailCliente'";
				$coma = ",";
			}
				
			if(isset($args["cel"])){
				$salida = $this->setTelCliente($args["cel"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", telCliente";
				$query2 = $query2 . ", '$this->telCliente'";
				$query3 = $query3 . "$coma telCliente='$this->telCliente'";
				$coma = ",";
			}
				
			if(isset($args["zona"])){
				$salida = $this->setIdZona($args["zona"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", idZona";
				$query2 = $query2 . ", '$this->idZona'";
				$query3 = $query3 . "$coma idZona='$this->idZona'";
				$coma = ",";
			}
				
			if(isset($args["ctaCte"])){
				$salida = $this->setCtaCte($args["ctaCte"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", ctaCte";
				$query2 = $query2 . ", '$this->ctaCte'";
				$query3 = $query3 . "$coma ctaCte='$this->ctaCte'";
				$coma = ",";
			}
				
			if(isset($args["fechaAlta"])){
				$salida = $this->setFechaAlta($args["fechaAlta"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", fechaAlta";
				$query2 = $query2 . ", '$this->fechaAlta'";
				$query3 = $query3 . "$coma fechaAlta='$this->fechaAlta'";
				$coma = ",";
			}
				
			if(isset($args["knownby"])){
				$salida = $this->setIdKnownBy($args["knownby"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", idKnownBy";
				$query2 = $query2 . ", '$this->idKnownBy'";
				$query3 = $query3 . "$coma idKnownBy='$this->idKnownBy'";
				$coma = ",";
			}
			
			if(isset($args["est"])){
				$salida = $this->setEstado($args["est"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", estado";
				$query2 = $query2 . ", '$this->estado'";
				$query3 = $query3 . "$coma estado='$this->estado'";
				$coma = ",";
			}
			
			if(isset($args["balance"])){
				$salida = $this->setBalance($args["balance"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", balance";
				$query2 = $query2 . ", '$this->balance'";
				$query3 = $query3 . "$coma balance='$this->balance'";
				$coma = ",";
			}
				
			if(isset($args["obs"])){
				$salida = $this->setObservaciones($args["obs"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				
				$query1 = $query1 . ", observaciones";
				$query2 = $query2 . ", '$this->Observaciones'";
				$query3 = $query3 . "$coma Observaciones='$this->Observaciones'";
				$coma = ",";
			}
			
			$query1 .= ") ";
			$query2 .= ") ";
			$query = $query1 . $query2 . $query3;
				
			#return $query;
			$db = new DB();
			$dbcon = $db->connect();
				
			$result = mysqli_query($dbcon, $query);

			if(!$result){
				die('Consulta no válida: ' . mysqli_error($dbcon) . "\nConsulta: $query");
			}
			else{
				echo "OK";
			}
		}
			   
		public function listarClientes(){
			$db = new DB();
			$dbcon = $db->connect();
			$query="SELECT  idCliente AS id,
							tipoCliente AS tipo,
							nombreCliente AS nom,
							apellidoCliente AS ap,
							dniCliente AS dni,
							emailCliente AS email,
							telCliente AS tel1,
							telCliente2 AS tel2,
							idZona AS zona,
							idKnownBy AS known,
							estado AS estado,
							fechaAlta AS alta,
							balance AS bal
					FROM clientes
					WHERE estado='ACTIVO' OR estado='SUSPENDIDO'
					ORDER BY idCliente DESC
					LIMIT 50";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

			echo "<center>
					<table id='table1'>";
			echo $this->getThead(mysqli_num_rows($result)) . "<tbody>";
						
						while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							$zona = $db->getConfig("charValue", "idConf = '$fila[zona]'");							
							$known = $db->getConfig("charValue", "idConf = '$fila[known]'");
							
							if($fila["bal"] < 0){
								$fondo = "background-color: #FF623B; font-weight: bold";
							}
							else if($fila["bal"] > 0){
								$fondo = "background-color: #19BAFF; font-weight: bold";
							}
							else{
								$fondo = "";
							}
							
							echo "<tr class='clientes'>
									<td style='width: 40px;'>$fila[id]</td>
									<td style='width: 150px;'>$fila[nom] $fila[ap]</td>
									<td style='width: 70px;'>$fila[dni]</td>
									<td style='width: 200px;'>$fila[email]</td>
									<td>$fila[tel1] $fila[tel2]</td>
									<td style='width: 100px;'>$zona</td>
									<td style='width: 100px;'>$fila[tipo]</td>
									<td style='width: 150px;'>$known</td>
									<td style='width: 70px;'>$fila[estado]</td>
									<td style='width: 55px;'>$$fila[bal]</td>
									<td><input type='button' value='Editar' class='boton2' onClick='acciones(\"editar\", $fila[id])'></td>
								</tr>";
						}
					echo "</tbody>
				</table>
			</center>";	
		}
		
		public function formulario($id){
			$db = new DB();
			$dbcon = $db->connect();
			
			if(isset($id)){
				$fila = $this->getCliente($id);
			}

			echo "<center>
					<table cellpadding='3px' id='table1'>
						<tr>
							<td colspan='2' style='font-weight: bold;'>AGREGAR CLIENTE - 
								<input type='button' class='boton2' value='Ver Todos' onClick='acciones(\"listar\")'>
								<input type='hidden' name='opcion' id='opCli' value='$option'>
								<input type='hidden' name='id' id='idCli' value='$id'>
							</td>
						</tr>
						<tr>
							<td>Nombre</td>
							<td style='width: 260px;'><input type='text' id='nomCli' name='nombre' size='28' maxLength='64' value='$fila[nom]'></td>
						</tr>
						<tr>
							<td>Apellido</td>
							<td><input type='text' id='apCli' name='apellido' size='28' maxLength='64' value='$fila[ap]'></td>
						</tr>
						<tr>
							<td>DNI</td>
							<td><input type='text' id='dniCli' name='dni' size='28' maxLength='16' value='$fila[dni]'></td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td><input type='text' id='emailCli' name='email' size='28' maxLength='128' value='$fila[email]'></td>
						</tr>
						<tr>
							<td>Telefono Celular</td>
							<td><input type='text' id='celCli' name='celular' size='28' maxLength='32' value='$fila[tel1]'></td>
						</tr>
						<tr>
							<td>Tipo de cliente</td>
							<td>
								<select id='tipoCli' name='tipoCli' style='width: 140px;'>";
									$enum_fields = $db->showColumns("clientes", "tipoCliente");
					
									foreach($enum_fields as $item){
										echo "<option value='$item'";
										if($item == $fila['tipo']){
											echo " Selected";
										}

										echo ">$item</option>";	
									}
						echo "</select>
							</td>
						</tr>
						<tr>
							<td>Estado</td>
							<td>
								<select id='estadoCli' name='estadoCli' style='width: 140px;'>";
									$enum_fields = $db->showColumns("clientes", "estado");
					
									foreach($enum_fields as $item){
										echo "<option value='$item'";
										if($item == $fila["est"]){
											echo " Selected";
										}

										echo ">$item</option>";	
									}
							echo "</select>
							</td>
						</tr>
						<tr>
							<td>Cuenta corriente</td>
							<td>
								<select id='ctaCte' name='cuentaCte' style='width: 140px;'";

								if($_SESSION['rol'] > 2){
									echo " disabled='disabled'";
								}
								echo ">";
					
								$enum_fields = $db->showColumns("clientes", "ctaCte");
					
								foreach($enum_fields as $item){
									echo "<option value='$item'";

									if($item == "HABILITADA"){
										echo " Selected";
									}

									echo ">$item</option>";	
								}
							echo "</select>
							</td>
						</tr>
						<tr>
							<td>Zona</td>
							<td id='zona'>
								<select id='selectZona' name='zonaCli' style='width: 140px;' onchange='cambiarZona(this.value)'>";
								$query="SELECT idConf, charValue FROM config WHERE descConfig = 'zona'";
								$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
								while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
									if($fila2[0] == "$fila[zona]"){
										echo "<option value='$fila2[0]' Selected>$fila2[1]</option>";
									}
									else{
										echo "<option value='$fila2[0]'>$fila2[1]</option>";
									}
								}
							echo "<option value='otro'>Otro...</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Nos conoció por:</td>
							<td id='knownBy'>
								<select id='selectKnownBy' name='nosConocioPor' style='width: 140px;' onchange='cambiarKnownBy(this.value)'>";
					
								$query="SELECT idConf, charValue FROM config WHERE descConfig = 'nos_conocio_por'";
								$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
								while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
									if($fila2[0] == "$fila[knownBy]"){
										echo "<option value='$fila2[0]' Selected>$fila2[1]</option>";
									}
									else{
										echo "<option value='$fila2[0]'>$fila2[1]</option>";
									}
								}

							if(!$fila[bal]){
								$fila[bal] = 0;
							}
					
							echo "<option value='otro'>Otro...</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Balance cta. cte.</td>
							<td><input type='number' name='balance' id='balance' max='99999' size='2' value='$fila[bal]' onchange=''></td>
						</tr>
						<tr>
							<td colspan='2'>
								<input type='button' value='Guardar' class='boton2' onClick='acciones(\"guardar\", $fila[id])'>
							</td>
						</tr>
				</table>
			</center>";
		}
		
		public function filtrarClientes($args){
			$filtros = false;
			$search = "";
			
			if($args["nom"] != ""){
				$search = "(nombreCliente LIKE '%$args[nom]%' OR apellidoCliente LIKE '%$args[nom]%')";
				$filtros=true;
			}

			if($args["dni"] != ""){
				if($filtros){
					$search = $search . " AND dniCliente LIKE '%$args[dni]%'";
				}
				else{
					$search = $search . "dniCliente LIKE '%$args[dni]%'";
				}
				$filtros=true;
			}

			if($args["email"] != ""){
				if($filtros){
					$search = $search . " AND emailCliente LIKE '%$args[email]%'";
				}
				else{
					$search = $search . "emailCliente LIKE '%$args[email]%'";
				}
				$filtros=true;
			}

			if($args["tel"] != ""){
				if($filtros){
					$search = $search . " AND (telCliente LIKE '%$args[tel]%')";
				}
				else{
					$search = $search . "telCliente LIKE '%$args[tel]%'";
				}
				$filtros=true;
			}


			if($args["zona"] != ""){
				if($filtros){
					$search = $search . " AND idZona='$args[zona]'";
				}
				else{
					$search = $search . "idZona='$args[zona]'";
				}
				$filtros=true;
			}


			if($args["tipo"] != ""){
				if($filtros){
					$search = $search . " AND tipoCliente LIKE '%$args[tipo]%'";
				}
				else{
					$search = $search . "tipoCliente LIKE '%$args[tipo]%'";
				}
				$filtros=true;
			}


			if($args["knownby"] != ""){
				if($filtros){
					$search = $search . " AND idKnownBy='$args[knownby]'";
				}
				else{
					$search = $search . "idKnownBy='$args[knownby]'";
				}
				$filtros=true;
			}


			if($args["est"] != ""){
				if($filtros){
					$search = $search . " AND estado LIKE '%$args[est]%'";
				}
				else{
					$search = $search . "estado LIKE '%$args[est]%'";
				}
				$filtros=true;
			}
			
			if($args["balance"] != ""){
				if($filtros){
					$search = $search . " AND balance $args[balance] 0";
				}
				else{
					$search = $search . "balance $args[balance] 0";
				}
				$filtros=true;
			}

			if(!$filtros){
				$search = 1;
			}

			$db = new DB();
			$dbcon = $db->connect();
			$query="SELECT  clientes.idCliente AS id,
							clientes.tipoCliente AS tipo,
							clientes.nombreCliente AS nom,
							clientes.apellidoCliente AS ap,
							clientes.dniCliente AS dni,
							clientes.emailCliente AS email,
							clientes.telCliente AS tel1,
							clientes.telCliente2 AS tel2,
							clientes.idZona AS zona,
							clientes.idKnownBy AS known,
							clientes.estado AS estado,
							clientes.fechaAlta AS alta,
							clientes.balance AS bal,
							(SELECT charValue FROM config WHERE idConf=clientes.idKnownBy) AS known,
							(SELECT charValue FROM config WHERE idConf=clientes.idZona) AS zona
					FROM clientes
					WHERE $search  AND (estado='ACTIVO' OR estado='SUSPENDIDO')
					ORDER BY idCliente DESC
					LIMIT 50";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			
			echo "<center>
				<table id='table1'>";
			echo $this->getThead(mysqli_num_rows($result)) . "<tbody>";
			
			if(mysqli_num_rows($result)){
				while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				  echo "<tr class='clientes'>
							<td style='width: 40px;'>$fila[id]</td>
							<td style='width: 150px;'>$fila[nom] $fila[ap]</td>
							<td style='width: 70px;'>$fila[dni]</td>
							<td style='width: 200px;'>$fila[email]</td>
							<td>$fila[tel1]</td>
							<td style='width: 100px;'>$fila[zona]</td>
							<td style='width: 100px;'>$fila[tipo]</td>
							<td style='width: 150px;'>$fila[known]</td>
							<td style='width: 70px;'>$fila[estado]</td>
							<td style='width: 55px;'>$$fila[bal]</td>
							<td><input type='button' value='Editar' class='boton2' onClick='acciones(\"editar\", $fila[id])'></td>
						</tr>";
				}
			}
			
			echo "</tbody>
				</table>
			</center>";
		}
		
		public function getCliente($id){
			if($id){
				$db = new DB();
				$dbcon = $db->connect();
				$query="SELECT 	idCliente AS id,
								tipoCliente AS tipo,
								nombreCliente AS nom,
								apellidoCliente AS ap,
								dniCliente AS dni,
								emailCliente AS email,
								telCliente AS tel1,
								estado AS est,
								idZona AS zona,
								idKnownBy AS knownBy,
								balance AS bal
								FROM clientes WHERE idCliente='$id'";
				$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
				
				if(mysqli_num_rows($result) > 0){
					return mysqli_fetch_array($result, MYSQLI_ASSOC);					
				}
				else{
					return "NO SE ENCONTRO UN CLIENTE CON ID: $id";
				}
			}
			else{
				return "INGRESAR ID PARA BUSCAR UN CLIENTE";
			}			
		}
		
		public function comprasCliente($idCliente){
			$db = new DB();
			$dbcon = $db->connect();

			$query="SELECT detalleVentas.idDetalle,
						detalleVentas.idServicio,
						detalleVentas.idOpcion,
						servicios.descServ,
						opciones.descOp
						FROM detalleVentas
						INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
						INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
						WHERE idCliente='$idCliente' AND (estadoVenta='NO TOMADO' OR estadoVenta='CANCELADO')";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

			echo "<hr><table cellpadding='3px' id='table1'>";

			if(mysqli_num_rows($result)){
				echo "<tr><td colspan='4' style='font-weight: bold;'>SERVICIOS SIN TOMAR: " . mysqli_num_rows($result) . "</td></tr>";

				while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
					$query="SELECT idMaq, marcaMaq, modeloMaq FROM maquinas WHERE idServicio='$fila[1]' AND estado='VIGENTE'";
					$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

					echo "<tr>
							<td id='$fila[0]-servicio' style='width: 150px;'>$fila[3]</td>
							<td id='$fila[0]-opcion' style='width: 150px;'>$fila[4]</td>
							<td id='$fila[0]-maquina' style='width: 150px;'>
								<select name='maq' id='$fila[0]-maqList'>";
					while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
							echo "<option name='$fila2[0]'>$fila2[1] $fila2[2]</option>";
					}

					echo "		</select>
							</td>
							<td style='width: 150px;'><input type='button' onclick='agendar($fila[0])' value='Agendar' class='boton2'></td>
						</tr>";
				}
			}
			else{
				echo "<tr><td style='width: 400px;'>No hay compras pendientes de este cliente.</td></tr>";
			}
			echo "</table>";			
		}
		
		public function buscarCliente($nombre, $dni){
			if(isset($dni) && $dni != ""){
				$search = "dniCliente LIKE '%$dni%' AND estado='ACTIVO'";
				$no_result = "DNI: $dni";
				if($nombre != ""){
					$search = $search . " AND (nombreCliente LIKE '%$nombre%' or apellidoCliente LIKE '%$nombre%') AND estado='ACTIVO'";
					$no_result = $no_result . " y nombre: $nombre";
				}
			}
			elseif(isset($nombre) && $nombre != ""){
				$search = "estado='ACTIVO' AND (nombreCliente LIKE '%$nombre%' or apellidoCliente LIKE '%$nombre%')";
				$no_result = "nombre: $nombre";
			}
			
			$db = new DB();
			$dbcon = $db->connect();

			$query="SELECT  idCliente AS id,
							nombreCliente AS nom,
							apellidoCliente AS ap,
							dniCliente AS dni,
							ctaCte AS cta,
							balance AS bal
							FROM clientes WHERE $search";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

			if(mysqli_num_rows($result)){
				while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo "<label id='$fila[id]' class='clienteSeleccionado'>$fila[nom] $fila[ap] - DNI: $fila[dni] - <strong>Balance de cuenta: $$fila[bal]</strong>";
					if(mysqli_num_rows($result) > 1){
						echo "- </label><a href=# onclick='acciones(\"buscar\", $fila[dni])'>SELECCIONAR</a><br>
							<input type='hidden' id='ctacte' value='$fila[cta]'><input type='hidden' id='balance' value='$fila[bal]'>";
					}
					else{
						echo "</label><br>
							<input type='hidden' id='ctacte' value='$fila[cta]'><input type='hidden' id='balance' value='$fila[bal]'>";
					}
				}
			}
			else{
				echo "No se encontro cliente con $no_result";
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