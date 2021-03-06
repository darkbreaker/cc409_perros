<?php
//controlador requiere tener acceso al modelo
require('model/ArticuloBSS.php');
require('ModeloCtl.php');
require('pdfCtl.php');
require('excelCtl.php');
	class ArticuloCtl extends ModeloCtl{
		public $modelo;
		
		//cuando se crea el contrador crea el modelo Articulo
		function __construct(){
			$this->modelo = new ArticuloBSS();
		}

		function ejecutar(){ 
			if(@session_start() == false){session_destroy();session_start();}
		     if(!isset($_REQUEST['hacer']) ){
				if(isset($_SESSION['privilegio'])){
					if($_SESSION['privilegio']>0){
						$this->mostrar(file_get_contents('view/RegistroProducto.html'));
					}else
						$this->mostrar(file_get_contents('view/BuscarProducto.html'));
				
				}
				else
				$this->mostrar(file_get_contents('view/Producto.html'));
				
			} else switch($_REQUEST['hacer']){
				case 'agregar':
					if(isset($_SESSION['privilegio']))
						if($_SESSION['privilegio']>0)
							$Articulo=$this->modelo->agregarArticulo($_REQUEST['nombre'], $_REQUEST['descripcion'], $_REQUEST['precio_venta']) ;

				$this->mostrar(file_get_contents('view/BuscarProducto.html'));

					break;
				case 'consultar':
					$id=$this->EsId($_REQUEST['id']);
					if(!$id){
						$this->mostrar(file_get_contents('view/Index.html'));
						}else{
					$Articulo=$this->modelo->consultarArticulo($id);
					echo $Articulo;}
					break;
				case 'eliminar':

					$idUsuario=$this->EsId($_REQUEST['idUsuario']);
					if(!$idUsuario){
						$this->mostrar(file_get_contents('view/Index.html'));
						}else{
					$Articulo=$this->modelo->eliminarArticulo($idUsuario);
					$this->mostrar(file_get_contents('view/BuscarProducto.html'));
					}
					break;
				case 'modificar':
						$nombre=$this->EsNombre($_REQUEST['nombre']);
						$precio_venta=$this->EsNo($_REQUEST['precio_venta']);
					if(!$nombre||!$precio_venta){
						$this->mostrar(file_get_contents('view/Index.html'));
						}else{
						$Articulo=$this->modelo->modificarArticulo($nombre, $descripcion, $precio_venta) ;
						$this->mostrar(file_get_contents('view/BuscarProducto.html'));
					}
					break;
				case 'filtrar':
					
					if(!isset($_REQUEST['descripcion'])){
						$Articulo=$this->modelo->listar();
						echo json_encode($Articulo);
						}
						else{
							$Articulo=$this->modelo->filtrarArticulo($_REQUEST['descripcion']);
							echo json_encode($Articulo);
						}
					break;
					
				case 'pdf':
					@$pdf= new PDF();
					@$Articulo=$this->modelo->listar();
					@$pdf->run($Articulo);
					
			$mi_pdf = 'catalogo.pdf';
				/*	header('Content-type: application/pdf'); 
					header('Content-Disposition: attachment; filename="'.$mi_pdf.'"'); 
					readfile($mi_pdf);*/
					
					break;
				case 'excel':
					$excel= new Excel();
					$Articulo=$this->modelo->listar();
					$excel->run($Articulo);
					break;
				case 'alta':
					if(isset($_SESSION['nombre']))
						@$this->mostrar(file_get_contents('view/RegistroProducto.html'));
					else
						@$this->mostrar(file_get_contents('view/BuscarProducto.html'));
						
						break;
				Default:
					$this->mostrar(file_get_contents('view/Login.html'));
				}
				
		}
			
	}
?>