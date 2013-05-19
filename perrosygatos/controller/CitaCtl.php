<?php
//controlador requiere tener acceso al modelo
include_once('model/CitaBSS.php');
include_once('ModeloCtl.php');
class CitaCtl extends ModeloCtl{
		public $modelo;
		
		//cuando se crea el contrador crea el modelo Cita
		function __construct(){
			$this->modelo = new CitaBSS();
		}

		function ejecutar(){
			//si no tengo parametros se regresa al menu principal
			session_start();
			$hacer=$_REQUEST['hacer'];
			$idCita=$this->EsId($_REQUEST['idCita']);
			$fecha=$this->EsFecha($_REQUEST['fecha']);
			$detalles=$_REQUEST['detalles'];
			$hora_reserva=$this->EsHora($_REQUEST['hora_reserva']);
			$hora_termino=$this->EsHora($_REQUEST['hora_termino']);
			$idUsuario=$this->EsId($_REQUEST['idUsuario']);
            $estado=$_REQUEST['estado'];
			$descripcion=$_REQUEST['descripcion'];
			
			
				if(!isset($_SESSION['usuario'])){
					include_once('view/Index.html');
				
			} else if(!isset($hacer)){
				$file = file_get_contents('view/RegistroCita.html'); //cargo el archivo
				$file = str_ireplace('{Username}',$_SESSION['usuario'] , $file); //tomo {titulo} y lo reemplazo por lo que quiera
				echo $file;
				
			}else  
			switch($hacer){
				case 'agregarCita':
					if((!$idUsuario||!$fecha||!$hora_reserva))
						include_once('view/Index.html');
						else{
					$Cita=$this->modelo->agregarCita($idUsuario, $fecha ,$detalles, $hora_reserva) ;
					include('view/agregarCitaView.php');}
					break;
					
				case 'buscarCita':
					if(!$idCita)
						include_once('view/Index.html');
						else{
					$Cita=$this->modelo->buscarCita($idCita);
					include('view/buscarCitaView.php');}
					break;
				case 'eliminarCita':
					if(!$idCita)
						include_once('view/Index.html');
					else{
							$Cita=$this->modelo->eliminarCita($idCita);
							include('eliminarview/CitaView.php');}
					break;
				case 'listar':
						$Cita=$this->modelo->listar() ;
						include('view/listarCitaView.php');
					break;
				case 'servicioCita':
						if(!$idCita)
								include_once('index.php');
						else{
			               $Cita=$this->modelo->servicioCita($idCita) ;
							include('view/serviciosCitaView.php');}
					break;
		        case 'ActualizarCita':
					if(!$idCita||!$hora_termino||!$estado)
						include_once('view/Index.html');
						else{
			               $Cita=$this->modelo->ActualizarCita($idCita, $hora_termino ,$estado) ;
							include('view/ActulizarCitaView.php');}
					break;

				case 'filtrarCita':
					$Cita=$this->modelo->filtrarCita($descripcion) ;
					include('view/filtrarCitaView.php');
					break;
				
			}
			
		}

	}




?>
