<?php
//controlador requiere tener acceso al modelo
include_once('model/CitaBss.php');
	class StdCtl{
		public $modelo;
		
		//cuando se crea el contrador crea el modelo Cita
		function __construct(){
			$this->modelo = new CitaBss();
		}

		function ejecutar(){
			//si no tengo parametros se listan los Citas
			if(!isset($_REQUEST['accion']) ){
				$Cita = $this->modelo-> listar();
				//vista del resultado
				include('view/CitaView.php');
			} else switch($_REQUEST['accion']){
				case 'agregarCita':
					$Cita=$this->modelo->agregarCita() ;
					include('view/CitaView.php');
					break;
				case 'buscarCita':
					$Cita=$this->modelo->buscarCita($_REQUEST['idCita']);
					include('view/CitaView.php');
					break;
				case 'eliminarCita':
				$Cita=$this->modelo->eliminarCita($_REQUEST['idcita']);
					include('view/CitaView.php');
					break;
				case 'listar':
					$Cita=$this->modelo->listar() ;
					include('view/CitaView.php');
					break;
				
			}
			
		}

	}




?>