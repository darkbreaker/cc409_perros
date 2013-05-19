<?php

include_once('Conexion.php');
include_once('Articulo.php');
  class ArticuloBSS{
		public $id;
		public $nombre;
		public $descripcion;
		public $precio_venta;
		
         function agregarArticulo($nombre, $descripcion, $precio_venta){
			$con= new Conexion ( );
			if(!$con->conecta())
				die('error conexion');
				
			$this->nombre		=$con->escapar($nombre);
			$this->descripcion	=$con->escapar($descripcion);
			$this->precio_venta	=$con->escapar($precio_venta);
		
			$sql="INSERT INTO articulo(nombre,descripcion,precio) VALUES ('$this->nombre','$this->descripcion','$this->precio_venta') ";
			$resultado=$con->consulta($sql);
			if($resultado==false){
				die('error insercion');
				$con->cerrar();
				return FALSE;
				}
			$this -> id =$resultado;
			$con->cerrar();
			return $this->id;
        }
		
        function  buscarArticulo($idArticulo){
			$con= new Conexion ( );
			if($con->conecta()==false)
				die('error de conexion');
			$sql='SELECT * FROM articulo WHERE idarticulo= '.$id;
			//ejecutar el query
			$fila = $con->consulta($sql);	
			if($fila==false){
				die('error al consultar');
				$con->cerrar();
				return FALSE;
			}
				
			if($fila[0][idarticulo]==$id){
			$con->cerrar();
			$clase= new Usuario ($fila[0][idarticulo],$fila[0][nombre],$fila[0][descripcion],$fila[0][precio]);

			return $clase;
			}	
         }
		 
         function eliminarArticulo($idArticulo){
			$con= new Conexion ( );
			if($con->conecta()==false)
				die('error de conexion');
			$sql='DELETE FROM servicio WHERE idarticulo= '.$id;
			//ejecutar el query
			$fila = $con->consulta($sql);	
			if($fila==false){
				die('error al consultar');
				$con->cerrar();
				return FALSE;
				}
				
			$con->cerrar();
			return TRUE;
		 
         }
		 
        function  ReservarArticulo($idArticulo, $idUsuario){
		
			$con= new Conexion ( );
			if(!$con->conecta())
				die('error conexion');
			$sql="INSERT INTO pedido(idArticulo,idUSuario,fechaReservacion,estado) VALUES ('$idArticulo','$idUsuario',CURDATE(),'pendiente') ";
			$resultado=$con->consulta($sql);
			if($resultado==false){
				die('error insercion');
				$con->cerrar();
				return FALSE;
				}
			$con->cerrar();
			return $this->id;
		 
         }
	
	function filtrarArticulo($descripcion){
		$con= new Conexion ( );
		if($con->conecta()==false)
			die('error de conexion');
		$sql="SELECT  id,nombre,precio_venta,descripcion FROM usuario WHERE CONCAT(nombre,descripcion,precio_venta) LIKE '%".$descripcion."%'";
		//ejecutar el query
		$fila = $con->consulta($sql);	
		if($fila==false){
			die('error al consultar');
			$con->cerrar();
			return FALSE;
			}
		$con->cerrar();
		$fila = $fila->fetch_array();
		return $fila;
	}
	
    function  listar(){
			$conexion= new Conexion ( );
			if($conexion->conecta()==false){
				$conexion->cerrar();
				die('error al conectar');
				}
		
			$resultado = $conexion->consulta('select id,nombre,precio_venta,descripcion from articulo');	
		
			if($resultado==FALSE){
				die('error de resultado');
				$conexion->cerrar();
				
				return false;
				}
				
		while($row = $resultado->fetch_array(MYSQLI_ASSOC))
		{
		$obj[] = $row;
		}		
			//$resultado=$resultado->fetch_array();
			
			return $obj;
         }
         
	}
?>