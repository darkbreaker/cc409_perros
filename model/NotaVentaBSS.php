<?php
  class NotaVentaBSS{
		public $total;
		public $fecha;
		public $id;		
		
		function listar(){
			$conexion= new Conexion ('localhost', 'root', 'root','maskota');
			if($conexion->conecta()==false){
				$conexion->cerrar();
				die('error al conectar');
				}
		
			//ejecutar el query
			$resultado = $conexion->consulta('select * from NotaVenta');	
			if($resultado==FALSE){
				die('error de resultado');
				$conexion->cerrar();
				return FALSE;
				}
			$conexion-> cerrar();
			return $resultado;
		}

	}
?>
