<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";

	class Usuario
	{
		public $idUsuario;
		public $userName;
		public $usuarioNombre;
		public $usuarioApellido;
		public $usuarioDni;
		public $usuarioCel;
		public $usuarioEmail;
		public $usuarioRol;
		public $usuarioTema;
		public $usuarioEstado;
		public $Observaciones;
		public $salida;
		
		private $password;
		private $query1;
		private $query2;
		private $query3;
		
		###################################
		# FUNCIONES DE RETORNO DE VALORES #
		###################################

		public function getIdUsuario() {
			if(isset($this->idUsuario)){
				return $this->idUsuario;
			}
			else{
				return "No está definido el ID";
			}
		}
		
		public function getUserName(){
			if(isset($this->userName)){
				return $this->userName;
			}
			else{
				return "No está definido el nombre de usuario";
			}	
		}
		
		public function getUsuarioNombre(){
			if(isset($this->usuarioNombre)){
				return $this->usuarioNombre;
			}
			else{
				return "No está definido el nombre del usuario";
			}	
		}
		
		public function getUsuarioApellido(){
			if(isset($this->usuarioApellido)){
				return $this->usuarioApellido;
			}
			else{
				return "No está definido el apellido del usuario";
			}	
		}
		
		public function getUsuarioDni(){
			if(isset($this->usuarioDni)){
				return $this->usuarioDni;
			}
			else{
				return "No está definido el DNI del usuario";
			}	
		}
		
		public function getUsuarioCel(){
			if(isset($this->usuarioCel)){
				return $this->usuarioCel;
			}
			else{
				return "No está definido el numero de celular del usuario";
			}	
		}
		
		public function getUsuarioEmail(){
			if(isset($this->usuarioEmail)){
				return $this->usuarioEmail;
			}
			else{
				return "No está definido el email del usuario";
			}	
		}
		
		public function getUsuarioRol(){
			if(isset($this->usuarioRol)){
				return $this->usuarioRol;
			}
			else{
				return "No está definido el rol del usuario";
			}	
		}
		
		public function getUsuarioTema(){
			if(isset($this->usuarioTema)){
				return $this->usuarioTema;
			}
			else{
				return "No está definido el tema del usuario";
			}	
		}
		
		public function getFechaAlta(){
			if(isset($this->fechaAlta)){
				return $this->fechaAlta;
			}
			else{
				return "No está definida la fecha de alta del usuario.";
			}	
		}
		
		public function getUsuarioEstado(){
			if(isset($this->usuarioEstado)){
				return $this->usuarioEstado;
			}
			else{
				return "No está definido el estado del usuario.";
			}	
		}
		
		public function getObservaciones(){
			if(isset($this->Observaciones)){
				return $this->Observaciones;
			}
			else{
				return "No está definida la variable Observaciones del usuario.";
			}	
		}
		
		#################################
		# FUNCIONES DE SETEO DE VALORES #
		#################################
		
		private function setUserName($uname, $id){
			$len = strlen($uname);
			if($len < 4){
				return "El nombre de usuario debe tener 4 caracteres como mínimo.";
			}
			else if($len > 64){
				return "El nombre de usuario debe tener hasta 64 caracteres.";
			}
			else{
				if($_SESSION['rol'] == 1){
					if(!$id){
						$db = new DB();
						$dbcon = $db->connect();
						$query="SELECT * FROM usuarios WHERE userName='$uname'";
						$q = mysqli_query($dbcon, $query);
		
						if(mysqli_num_rows($q) > 0){
							return "El nombre de usuario ya está en uso.";
						}
					}
					
					$this->userName = $uname;
					return "OK";
				}
				else{
					return "Solo el administrador puede cambiar nombres de usuario.";
				}
			}
		}
		
		private function setPassword($pass1, $pass2){
			if(strcmp($pass1, $pass2) == 0){
				$this->password = hash('sha256', $pass1);
				return "OK";
			}
			else{
				return "Las contraseñas no coinciden.";
			}
		}
		
		private function setUsuarioNombre($nombre){
			$len = strlen($nombre);
			if($len < 1){
				return "El nombre del usuario debe tener 4 caracteres como mínimo.";
			}
			else if($len > 64){
				return "El nombre del usuario debe tener hasta 64 caracteres.";
			}
			else{
				$this->usuarioNombre = $nombre;
				return "OK";
			}
		}
		
		private function setUsuarioApellido($apellido){
			$len = strlen($apellido);
			if($len < 1){
				return "El apellido del usuario debe tener 4 caracteres como mínimo.";
			}
			else if($len > 128){
				return "El apellido del usuario debe tener hasta 128 caracteres.";
			}
			else{
				$this->usuarioApellido = $apellido;
				return "OK";
			}
		}
		
		private function setUsuarioDni($dni){
			$len = strlen($dni);
			if($len < 1){
				return "El DNI del usuario es requerido.";
			}
			else if($len > 16){
				return "El DNI del usuario debe tener hasta 16 caracteres y ser numérico.";
			}
			else{
				if(is_numeric($dni)){
					$this->usuarioDni = $dni;
					return "OK";
				}
				else{
					return "El DNI del usuario debe ser numérico";
				}
			}
		}
		
		private function setUsuarioCel($cel){
			$len = strlen($cel);
			if($len > 32){
				return "El número de celular del usuario debe tener hasta 32 caracteres y ser numérico.";
			}
			else if($len < 1){
				$this->usuarioCel = "";
				return "OK";
			}
			else{
				if(is_numeric($cel)){
					$this->usuarioCel = $cel;
					return "OK";
				}
				else{
					return "El número de celular del usuario debe ser numérico";
				}
			}
		}
		
		private function setUsuarioEmail($email){
			$len = strlen($email);
			if($len > 64){
				return "La dirección de correo electrónico del usuario debe tener hasta 64 caracteres.";
			}
			else if($len < 1){
				$this->usuarioEmail = "";
				return "OK";
			}
			else{
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				  return "La dirección de correo electrónico ingresada no tine un formato válido.";
				}
				else{
					$this->usuarioEmail = $email;
					return "OK";
				}
			}
		}
		
		private function setUsuarioRol($rol){
			if(!isset($_SESSION['rol'])){
				return "No está definido el rol del usuario actual";
			}
			   
			if($_SESSION['rol'] > $rol){
				return "No puede asignar a otro usuario un rol superior al suyo.";
			}
			   
			if($rol >= 1 && $rol <= 5){
				$this->usuarioRol = $rol;
				return "OK";
			}
			else{
				return "Número de rol inválido (1-5).";
			}
		}
			   
		private function setUsuarioTema($tema){
			$db = new DB();
			$enum_fields = $db->showColumns("usuarios", "usuarioTema");
			
			if($tema != ""){				
				foreach($enum_fields as $item){
					if($tema == $item){
						$this->usuarioTema = $item;
						return "OK";
					}
				}
			}
				
			$this->usuarioTema = $enum_fields[0];
			return "El tema ingresado no es válido. Usado por defecto " . $this->usuarioTema;
		}
			   
		private function setUsuarioEstado($estado){
			$db = new DB();
			$enum_fields = $db->showColumns("usuarios", "estado");
			
			if($estado != ""){				
				foreach($enum_fields as $item){
					if($estado == $item){
						$this->usuarioEstado = $item;
						return "OK";
					}
				}
			}
				
			$this->usuarioEstado = $enum_fields[0];
			return "El estado ingresado no es válido. Usado por defecto " . $this->usuarioEstado;
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
			   
		########################################
		# GUARDAR LOS VALORES EN BASE DE DATOS #
		########################################
			   
		public function guardar($args){
			#if(!id){
			#	return "Es necesario ingresar un ID de usuario para guardar los datos";
			#}
				
			$query1 = "INSERT INTO usuarios (";
			$query2 = "VALUES (";
			$query3 = " ON DUPLICATE KEY UPDATE ";
				
			if($args["id"]){
				$query1 = $query1 . "idUsuario, ";
				$query2 = $query2 . "'$args[id]', ";
			}
			
			if($args["user"]){
				$salida = $this->setUserName($args["user"], $args["id"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . "username";
				$query2 = $query2 . "'$this->userName'";
				$query3 = $query3 . "username='$this->userName'";
			}
				
			if($args["paguor1"] && $args["paguor2"]){
				$salida = $this->setPassword($args["paguor1"], $args["paguor2"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", password";
				$query2 = $query2 . ", '$this->password'";
				$query3 = $query3 . ", password='$this->password'";
			}
				
			if($args["nom"]){
				$salida = $this->setUsuarioNombre($args["nom"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioNombre";
				$query2 = $query2 . ", '$this->usuarioNombre'";
				$query3 = $query3 . ", usuarioNombre='$this->usuarioNombre'";
			}
				
			if($args["ap"]){
				$salida = $this->setUsuarioApellido($args["ap"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioApellido";
				$query2 = $query2 . ", '$this->usuarioApellido'";
				$query3 = $query3 . ", usuarioApellido='$this->usuarioApellido'";
			}
				
			if($args["dni"]){
				$salida = $this->setUsuarioDni($args["dni"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioDni";
				$query2 = $query2 . ", '$this->usuarioDni'";
				$query3 = $query3 . ", usuarioDni='$this->usuarioDni'";
			}
				
			if($args["cel"]){
				$salida = $this->setUsuarioCel($args["cel"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioCel";
				$query2 = $query2 . ", '$this->usuarioCel'";
				$query3 = $query3 . ", usuarioCel='$this->usuarioCel'";
			}
				
			if($args["email"]){
				$salida = $this->setUsuarioEmail($args["email"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioEmail";
				$query2 = $query2 . ", '$this->usuarioEmail'";
				$query3 = $query3 . ", usuarioEmail='$this->usuarioEmail'";
			}
				
			if($args["rol"]){
				$salida = $this->setUsuarioRol($args["rol"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioRol";
				$query2 = $query2 . ", '$this->usuarioRol'";
				$query3 = $query3 . ", usuarioRol='$this->usuarioRol'";
			}
				
			if($args["tema"]){
				$salida = $this->setUsuarioTema($args["tema"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", usuarioTema";
				$query2 = $query2 . ", '$this->usuarioTema'";
				$query3 = $query3 . ", usuarioTema='$this->usuarioTema'";
			}
				
			if($args["est"]){
				$salida = $this->setUsuarioEstado($args["est"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				$query1 = $query1 . ", estado";
				$query2 = $query2 . ", '$this->usuarioEstado'";
				$query3 = $query3 . ", estado='$this->usuarioEstado'";
			}
				
			if($args["obs"]){
				$salida = $this->setObservaciones($args["obs"]);
				if($salida != "OK"){
					return "Error al cargar los datos: <br>" . $salida;
				}
				
				$query1 = $query1 . ", observaciones";
				$query2 = $query2 . ", '$this->Observaciones'";
				$query3 = $query3 . ", observaciones='$this->Observaciones'";
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
			   
		public function listarUsuarios(){
			echo "<center>
				<table id='table1'>";
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
								FROM usuarios WHERE estado!='ELIMINADO'";
						$result = mysqli_query($dbcon, $query);

						echo "<tr>
								<td colspan='8' style='font-weight: bold;'>USUARIOS CARGADOS: " . mysqli_num_rows($result) . "</td>
								<td colspan='2'>
									<img id='imgEffects' title='Agregar usuario' src='imagenes/$_SESSION[tema]/boton_volver.png' onClick='acciones(\"agregar\")'>
									
									<a href='aplicaciones.php' title='Volver a Aplicaciones'>
										<img id='imgEffects' src='imagenes/$_SESSION[tema]/boton_volver.png' onClick=''>
									</a>
								</td>
							</tr>
							<tr style='font-weight: bold;'>
								<td>ID</td>
								<td>USUARIO</td>
								<td style='width: 160px;'>NOMBRE</td>
								<td style='width: 30px;'>ROL</td>
								<td>TELEFONO</td>
								<td style='width: 100px;'>EMAIL</td>
								<td>TEMA</td>
								<td style='width: 150px;'>CREADO</td>
								<td>ESTADO</td>
								<td>ACCIONES</td>
							</tr>";			

						while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							echo "<tr>
									<td>$fila[id]</td>
									<td>$fila[usuario]</td>
									<td>$fila[nombre] $fila[apellido]</td>
									<td>$fila[rol]</td>
									<td>$fila[cel]</td>
									<td>$fila[email]</td>
									<td>$fila[tema]</td>
									<td>$fila[alta]</td>
									<td>$fila[estado]</td>
									<td><input type='button' value='Editar' class='boton2' onClick='acciones(\"editar\", $fila[id])'></td>
								</tr>";
						}

				echo "</table>
			</center>";				
		}
		
		public function formulario($id){
			if($id){
				$user = $this->getUser($id);
			}
			
			echo "<center>
				<table id='table1'>
						<td colspan='2' style='font-weight: bold;'>DATOS DE USUARIO DEL SISTEMA</td>
						<td>
							<img id='imgEffects' src='imagenes/$_SESSION[tema]/boton_volver.png' onClick='acciones(\"listar\")'>
						</td>
					</tr>
					<tr>
						<td>Usuario</td>
						<td colspan='2' style='width: 200px'><input type='text' maxlength=32 id='us' placeholder='Max 32 caracteres...' value='$user[usuario]'></td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td colspan='2' style='width: 200px'><input type='text' maxlength=64 id='nom' placeholder='Cosme' value='$user[nombre]'></td>
					</tr>
					<tr>
						<td>Apellido</td>
						<td colspan='2' style='width: 200px'><input type='text' maxlength=128 id='ap' placeholder='Fulanito' value='$user[ap]'></td>
					</tr>
					<tr>
						<td>DNI</td>
						<td colspan='2' style='width: 200px'><input type=text' maxlength=128 id='dni' placeholder='11222333...' value='$user[dni]'></td>
					</tr>
					<tr>
						<td>Celular</td>
						<td colspan='2' style='width: 200px'><input type='text' maxlength=32 id='cel' placeholder='2604-999999...' value='$user[cel]'></td>
					</tr>
					<tr>
						<td>Rol</td>
						<td colspan='2' style='width: 200px'>
							<select style='width: 50px' id='rol'>";
							for($i=1;$i<=5;$i++){
								if($user["rol"] == $i){
									echo "<option value=$i Selected>$i</option>";
								}
								else{
									echo "<option value=$i>$i</option>";
								}
							}
						echo "</select>
						</td>
					</tr>
					<tr>
						<td>Tema</td>
						<td colspan='2' style='width: 200px'>
							<select style='width: 80px' id='tema'>";
						$db = new DB();
						$dbcon = $db->connect();
						$enum_fields = $db->showColumns("usuarios","usuarioTema");
			
						foreach($enum_fields as $item){
							if($item == $user["tema"]){	
								echo "<option value='$item' Selected>$item</option>";
								$selected = true;
							}
							else{
								echo "<option value='$item'>$item</option>";
							}
						}									
					echo "</select>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td colspan='2' style='width: 200px'><input type='email' id='email' placeholder='cosme@fulanito.com...'value='$user[email]'></td>
					</tr>
					<tr>
						<td>Estado</td>
						<td colspan='2' style='width: 200px'>
							<select style='width: 80px' id='estado'>";
						$db = new DB();
						$dbcon = $db->connect();
						$enum_fields = $db->showColumns("usuarios","estado");
			
						foreach($enum_fields as $item){
							if($item == $user["est"]){	
								echo "<option value='$item' Selected>$item</option>";
								$selected = true;
							}
							else{
								echo "<option value='$item'>$item</option>";
							}
						}									
					echo "</select>
						</td>
					</tr>
					<tr>
						<td rowspan='2'>Password</td>
						<td colspan='2' style='width: 200px'><input type='password' maxlength=64 id='paguor1' placeholder='Max 64 caracteres...'></td>
					</tr>
					<tr>
						<td colspan='2' style='width: 200px'><input type='password' maxlength=64 id='paguor2' placeholder='Max 64 caracteres...'></td>
					</tr>
					<tr>
						<td colspan=3><input type='button' value='Guardar' class='boton2' onClick='acciones(\"cargar\", $id)'></td>
					</tr>
				</table>
			</center>";
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