<?php
//controlador requiere tener acceso al modelo
include_once('model/UsuarioBSS.php');
include_once('ModeloCtl.php');
	class LogCtl extends ModeloCtl{
		public $modelo;
		//cuando se crea el contrador crea el modelo usuario
		function __construct(){
			$this->modelo = new UsuarioBSS();
		}

		function ejecutar(){
		//cargando sesion

				$hacer=$_REQUEST['hacer'];
				session_start();
			
				switch ($hacer){
					case 'in':
						if(!isset($_SESSION['usuario'])){
								$id=$_REQUEST['usuario'];
								$pass=$_REQUEST['pass'];
								if(isset($_REQUEST['usuario']))
								$usuario=$this->modelo->login($id,$pass);
								else
								$usuario=false;
								
								if(is_object($usuario)){
							//si existe
									$_SESSION['usuario']=$usuario->id;
									$_SESSION['nombre']=$usuario->nombre;
									$_SESSION['privilegio']=$usuario->tipo;				
							
									include('view/LogInView.php');
								}else
										
										include('view/LogErrorView.php');
						}else
							include('view/LogErrorView.php');
							
						
								
						break;
					case 'out':
						if(isset($_SESSION['usuario'])){
						//limpiar session
						session_unset();
						//destruye sesion
						session_destroy();
						setcookie(session_name(),'',time()-1);
						var_dump ($_SESSION);
						}
						include('view/View.php');
						break;
					default:
						include('view/LogErrorView.php');
				}	// fin del switch

		}// fin de la funcion

	}// fin de la clase



?>