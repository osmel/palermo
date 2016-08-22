<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Salidas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_pedido', 'modelo_pedido');
		$this->load->model('catalogo', 'catalogo');  
		$this->load->model('model_salida', 'modelo_salida');  
		$this->load->model('modelo', 'modelo'); 
		$this->load->library(array('email')); 
		$this->load->library('Jquery_pagination');//-->la estrella del equipo	
	}

	public function id_proveedor(){
		$data['id_cliente'] ='';
		 if ($this->input->post('id_cliente')) {
		 			/*
		 	 	     $data['descripcion'] = $this->input->post('id_cliente');
		 	 	     $data['idproveedor'] = "2";

					$data['id_cliente'] =  $this->catalogo->checar_existente_proveedor($data);
						*/

					$data['id_cliente'] =  (string) $this->catalogo->check_existente_proveedor_entrada($this->input->post('id_cliente'));
					if (!($data['id_cliente'])){
						$data['id_cliente'] ='';
					}
		  } else {
		  	$data['id_cliente'] ='';
		  }	
 	   echo ($data['id_cliente']);	  
	}	

	public function proveedor_id($idcliente){
		$data['id_cliente'] ='';
		 if ($this->input->post('id_cliente')) {

		 	 	     $data['descripcion'] = $idcliente;
		 	 	     $data['idproveedor'] = "2";

					$data['id_cliente'] =  $this->catalogo->checar_existente_proveedor($data);


					//$data['id_cliente'] =  (string) $this->catalogo->check_existente_proveedor_entrada($idcliente);
					if (!($data['id_cliente'])){
						$data['id_cliente'] ='';
					}
		  } else {
		  	$data['id_cliente'] ='';
		  }	
 	   return ($data['id_cliente']);	  
	}	

	public function refe_producto(){

	    $data['val_prod']       	  = $this->input->post('val_prod');
	    $data['val_color']  	      = $this->input->post('val_color');
	    $data['val_comp'] 	          = $this->input->post('val_comp');
	    $data['val_calida']           = $this->input->post('val_calida');
	    $data['val_calida']           = $this->input->post('val_calida');
	    $data['id_cliente']           = $this->input->post('id_cliente');
	    
		
		$dato['cliente_id'] = self::proveedor_id($data['id_cliente']);
		$dato['ref_prod'] =  $this->catalogo->refe_producto($data);		
		echo json_encode($dato);

	}
	

//***********************Todos los catalogos**********************************//
	public function listado_salidas(){



		 if($this->session->userdata('session') === TRUE ){
		      $id_perfil=$this->session->userdata('id_perfil');

		      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
		      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
		            $coleccion_id_operaciones = array();
		       }   
		       
		       //no. movimiento
		       $data['consecutivo']  = $this->catalogo->listado_consecutivo(2);
		       //valor del cliente, cargador, factura, 
		       $data['val_proveedor']  = $this->modelo_salida->valores_movimientos_temporal();
		       //print_r($data['val_proveedor']);
		       //die;
		       $data['productos'] = $this->catalogo->listado_productos_unico();
		       $data['colores'] = $this->catalogo->listado_colores_unico();
		       $data['destinos'] = $this->catalogo->lista_destino();
		       $data['almacenes']   = $this->modelo->coger_catalogo_almacenes(2);


     		   $data['facturas']   = $this->catalogo->listado_tipos_facturas(-1,-1,'1');
		       $data['pedidos']   = $this->catalogo->listado_tipos_pedidos(-1,-1,'1');

		       

		      switch ($id_perfil) {    
		        case 1:          
		                    $this->load->view( 'salidas/salida',$data );
		          break;
		        case 2:
		        case 3:
		              if  (in_array(2, $coleccion_id_operaciones))  {                 
		                        $this->load->view( 'salidas/salida',$data );
		             }   
		          break;


		        default:  
		          redirect('');
		          break;
		      }
		    }
		    else{ 
		      redirect('');
		    }  		
		
		
	}



	public function procesando_servidor(){
		
		$data=$_POST;
		$data['id_cliente']=0;
  	    if ($this->input->post('id_cliente')) {

		 	 	     $data['descripcion'] = $this->input->post('id_cliente');
		 	 	     $data['idproveedor'] = "2";

					$data['id_cliente'] =  $this->catalogo->checar_existente_proveedor($data);

			 //$data['id_cliente'] =  $this->catalogo->check_existente_proveedor_entrada($this->input->post('id_cliente'));
		}	 

		if (!($data['id_cliente'])) {
			$data['id_cliente'] =0;
		}

		$busqueda = $this->modelo_salida->buscador_entrada($data);
		echo $busqueda;
	}

	public function procesando_servidor_salida(){
		$data=$_GET;
		$busqueda = $this->modelo_salida->buscador_salida($data);
		echo $busqueda;
	}
	

	function agregar_prod_salida(){

	    if ($this->session->userdata('session') !== TRUE) {
	      redirect('');
	    } else {



			 if ($this->input->post('id_cliente')) {

		 	 	     $data['descripcion'] = $this->input->post('id_cliente');
		 	 	     $data['idproveedor'] = "2";

					$data['id_cliente'] =  $this->catalogo->checar_existente_proveedor($data);


						//$data['id_cliente'] =  $this->catalogo->check_existente_proveedor_entrada($this->input->post('id_cliente'));
						if (!($data['id_cliente'])){
							print "El cliente no existe";
						}
			  } else {
			  	$data['id_cliente']=null;
			  	print "Campo <b>cliente</b> obligatorio. ";
			  }
			     	

			 if ($this->input->post('id_cargador')) {
						$data['id_cargador'] =  $this->catalogo->check_existente_cargador_entrada($this->input->post('id_cargador'));
						if (!($data['id_cargador'])){
							print "El cargador no existe";
						}
			 } else {
			  	$data['id_cargador']=null;
			  	print "Campo <b>cargador</b> obligatorio. ";

			  }


		      $this->form_validation->set_rules( 'factura', 'Factura', 'trim|required|min_length[2]|max_lenght[180]|xss_clean');


	 		if ( ($this->form_validation->run() === TRUE) and ($data['id_cliente']) and ($data['id_cargador']) ) {

				 		$data['id'] = $this->input->post('identificador');
				 		$data['factura'] = $this->input->post('factura');
				 		$data['id_movimiento'] = $this->input->post('movimiento');
				 		$data['id_destino'] = $this->input->post('id_destino');
				 		$data['id_almacen'] = $this->input->post('id_almacen');

				 		$data['id_tipo_factura'] = $this->input->post('id_tipo_factura');
				 		$data['id_tipo_pedido'] = $this->input->post('id_tipo_pedido');
				 		

				 		
						$existe=$this->modelo_salida->checar_prod_salida($data);

						if ($existe==false) {
							$this->modelo_salida->enviar_prod_salida($data);	
						}	
						
									 //die;
						$actualizar = $this->modelo_salida->quitar_prod_entrada($data );

						$actualizar = true;
						if ( $actualizar !== FALSE ){
							echo TRUE;
						} else {
							echo '<span class="error">No se ha podido añadir el producto</span>';
						}
	
			} else {      
				
       			 echo validation_errors('<span class="error">','</span>');

      		}			





		}	
   }


	//quitar_prod_salida
	function quitar_prod_salida(){

	    if ($this->session->userdata('session') !== TRUE) {
	      redirect('');
	    } else {
	 		
	 		$data['id'] = $this->input->post('identificador');
			$data['id_tipo_factura'] = $this->input->post('id_tipo_factura');
			$data['id_tipo_pedido'] = $this->input->post('id_tipo_pedido');
			

				$this->modelo_salida->enviar_prod_entrada( $data );
					  
			$actualizar = $this->modelo_salida->quitar_prod_salidas($data );
			$dato['total'] = $this->modelo_salida->total_registros_salida();
		
				 		

		
			if ( $actualizar !== FALSE ){
				$dato['exito']  = true;
				echo json_encode($dato);
				
			} else {
				$dato['exito']  = false;
				$dato['error'] = '<span class="error">No se ha podido actualizar el producto</span>';
				echo json_encode($dato);
			}
		}	
   }



//////////////////////////eliminar pedido detalle//////////////////////////////

/*
  hay productos apartados que no fueron agregados a la salida, SI para continuar y descartar productos apartados que no fueron agregados, 
  No para continuar agregando productos a la salida.
  SI NO

  Desea procesar la salida. Este proceso descontara irreversiblemente los productos del inventario.
    SI   NO

*/

  

	public function confirmar_salida_sino(){


			 if($this->session->userdata('session') === TRUE ){
			      $id_perfil=$this->session->userdata('id_perfil');

			      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
			      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
			            $coleccion_id_operaciones = array();
			       }  

			      $existe = $this->modelo_salida->existencia_temporales();

			      $errores='';

				 if ($this->input->post('id_cliente')) {
		
				 	 	     $data['descripcion'] = $this->input->post('id_cliente');
				 	 	     $data['idproveedor'] = "2";

							$data['id_cliente'] =  $this->catalogo->checar_existente_proveedor($data);


							//$data['id_cliente'] =  $this->catalogo->check_existente_proveedor_entrada($this->input->post('id_cliente'));
							if (!($data['id_cliente'])){
								$errores= "El cliente no existe";
							}
				  } else {
				  	$data['id_cliente']=null;
				  	$errores= "Campo <b>cliente</b> obligatorio. ";
				  }
				
				 if ($this->input->post('id_cargador')) {
							$data['id_cargador'] =  $this->catalogo->check_existente_cargador_entrada($this->input->post('id_cargador'));
							if (!($data['id_cargador'])){
								$errores= "El cargador no existe";
							}
				 } else {
				  	$data['id_cargador']=null;
				  	$errores= "Campo <b>cargador</b> obligatorio. ";

				  }


			      $this->form_validation->set_rules( 'factura', 'Factura', 'trim|required|min_length[2]|max_lenght[180]|xss_clean');

			      
				if ($this->form_validation->run() === TRUE) {			      
					 if  (!($existe)) {
					 	$errores= "Debe agregar al menos un producto";
					 } else {  //si estan agregados los productos entonces checar si tienen el peso real
					 		
					 		//actualizar peso real
					 		$data['pesos'] =  json_decode(json_encode( $this->input->post('arreglo_peso') ),true  );
					 		$this->modelo_salida->actualizar_peso_real($data);

					 		//verificar si hay pesos reales en cero	
					 		$existe = $this->modelo_salida->existencia_temporales_peso_real();
					 		if  (!($existe)) {
					 			$errores= "Existen productos sin especificar Peso real";
					 		}	

					 }
					 
				}	 
				
					$data['id_almacen'] = $this->input->post('id_almacen');

					$data['id_tipo_pedido'] = $this->input->post('id_tipo_pedido');
					$data['id_tipo_factura'] = $this->input->post('id_tipo_factura');
			 		if (($existe) and ($this->form_validation->run() === TRUE) and ($data['id_cliente']) and ($data['id_cargador']) ) {
			 					//verificar si los apartados estan siendo totales o parciales
			 				  $dato['valor'] = $this->modelo_salida->cantidad_apartados($data);
			 				  $dato['id_cliente'] = $data['id_cliente'];
					      	  $dato['exito'] = true;
					      	  echo json_encode($dato);
			 		}	else {
		 					  $dato['exito']  = false;
							  $dato['errores'] =$errores;
							  $dato['error'] = validation_errors('<span class="error">','</span>');
							  echo json_encode($dato);
			 		}   
		

		} else { //fin de session
		 	redirect('');
		} 	
		
	}


	public function pro_salida($valor,$id_cliente,$id_almacen,$id_tipo_pedido,$id_tipo_factura){

		  if ( $this->session->userdata('session') !== TRUE ) {
		      redirect('');
		    } else {
		      $id_perfil=$this->session->userdata('id_perfil');

		      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
		      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
		            $coleccion_id_operaciones = array();
		       }   
		       $data['valor'] 				= base64_decode($valor);
		       $data['id_cliente'] 			= $id_cliente;
		       $data['id_almacen'] 				= base64_decode($id_almacen);

		       $data['id_tipo_pedido'] 				= base64_decode($id_tipo_pedido);
		       $data['id_tipo_factura'] 				= base64_decode($id_tipo_factura);

		      switch ($id_perfil) {    
		        case 1:
		        
		                $this->load->view( 'salidas/salida_modal', $data );
		          break;
		        case 2:
		        case 3:
		             if  (in_array(2, $coleccion_id_operaciones))  { 
		                 $this->load->view( 'salidas/salida_modal', $data );
		              }  else  {
		                redirect('');
		              } 
		          break;
		        default:  
		          redirect('');
		          break;
		      }
		   }   		
	}



public function validar_confirmar_salida_sino(){

		  if ( $this->session->userdata('session') !== TRUE ) {
		      redirect('');
		    } else {
		      $id_perfil=$this->session->userdata('id_perfil');

		      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
		      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
		            $coleccion_id_operaciones = array();
		       }   
		       
		       $data['id_cliente'] 			= $this->input->post('id_cliente');
		       $data['id_destino'] 			= $this->input->post('id_destino');
		       $data['valor'] 				= $this->input->post('valor');
		       $data['id_operacion'] 		= 2;
  				$data['encabezado'] 		= $this->modelo_salida->procesando_operacion_salida($data); //871
		        $data['movimientos']  		= $this->modelo_salida->listado_movimientos_registros($data); //1013
		        $data['id_almacen'] 		= $this->input->post('id_almacen');

				$data['id_tipo_pedido'] = $this->input->post('id_tipo_pedido');
				$data['id_tipo_factura'] = $this->input->post('id_tipo_factura');		        

		       if (($data['valor']==1) || ($data['valor']==2) ) {
		       		$this->modelo_salida->traspaso_quitar_apartados($data);
					$this->modelo_salida->quitar_apartados($data);		       		
		       }
		       //$this->db->join($this->catalogo_destinos.' As de' , 'de.id = m.id_destino','LEFT'); $this->db->select('m.id_destino,de.nombre destino');
			  $data['etiq_mov'] ="de Salida";
		      switch ($id_perfil) {    
		        case 1:		               
		                  $this->load->view( 'pdfs/salidas/pdfs_view',$data );

			        break;
		        case 2:
		        case 3:
		             if  (in_array(2, $coleccion_id_operaciones))  { 
		                  $this->load->view( 'pdfs/salidas/pdfs_view',$data );
		              }  else  {
		                redirect('');
		              } 
		          break;
		        default:  
		          redirect('');
		          break;
		      }
		   }   	


}	



	public function detalle_salidas($id_movimiento=-1,$cliente=-1,$cargador=-1){

		 if($this->session->userdata('session') === TRUE ){
		      $id_perfil=$this->session->userdata('id_perfil');

		      $id_movimiento= base64_decode($id_movimiento);

		      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
		      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
		            $coleccion_id_operaciones = array();
		       }  

		      $existe = $this->modelo_salida->existencia_temporales();
		      if (($existe) or ($id_movimiento!=-1) ) {

		      		if (($id_movimiento)==-1)	{ //OJO no funciona ya se cambio para "procesar_salidas"
					    $data['id_operacion'] = 2;
		  				$data['encabezado'] = $this->modelo_salida->procesando_operacion_salida($data);
		      		} else { //cuando se llama desde reportes(notas)
		      			$data['encabezado']['num_movimiento']  = $id_movimiento;
		      			$data['encabezado']['cliente']  	   = base64_decode($cliente);
		      			$data['encabezado']['cargador'] 	   = base64_decode($cargador);
		      			

		      			//if ($data['encabezado']['cargador']==" ") { //home
		      			if (substr($data['encabezado']['cargador'], -1)==" ") {	
		      				$data['retorno'] ="";	
							$data['encabezado']['cargador'] = substr($data['encabezado']['cargador'], 0, -1); 		      				
		      			} elseif (substr($data['encabezado']['cargador'], -2)=="r*") {
		      				$data['encabezado']['cargador'] = substr($data['encabezado']['cargador'], 0, -2); 
		      				$data['retorno'] ="reportes";	 //HOME DE REPORTES
		      			} else {
		      					$data['retorno'] ="listado_salidas";	 //DETALLES DE REPORTE
		      			}

					

		      		}

		      		$data['etiq_mov'] ="de Salida";

			      switch ($id_perfil) {    //$this->db->select('m.id_usuario_apartado');
			        case 1:          
						       $data['movimientos']  = $this->modelo_salida->listado_movimientos_registros($data);
			                   $this->load->view( 'pdfs/salidas/pdfs_view',$data );
			          break;
			        case 2:
			        case 3:
			              if  (in_array(9, $coleccion_id_operaciones))  {   //los q tienen accesos a reportes
						       $data['movimientos']  = $this->modelo_salida->listado_movimientos_registros($data);
			                   $this->load->view( 'pdfs/salidas/pdfs_view',$data );
			              } else {
			          		 redirect('');    	
			              }  

			          break;


			        default:  
			          redirect('');
			          break;
			      }
			  } else { 
		          redirect('salidas');
			  }  

			      
		    }
		    else{ 
		      redirect('');
		    }  
	}







/////////////////validaciones/////////////////////////////////////////	


	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido','<b class="requerido">*</b> La información introducida en <b>%s</b> no es válida.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', '<b class="requerido">*</b> El <b>%s</b> no tiene un formato válido.' );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', '<b class="requerido">*</b> Es necesario que selecciones una <b>%s</b>.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_date( $str ){

		$arr = explode('-', $str);
		if ( count($arr) == 3 ){
			$d = $arr[0];
			$m = $arr[1];
			$y = $arr[2];
			if ( is_numeric( $m ) && is_numeric( $d ) && is_numeric( $y ) ){
				return checkdate($m, $d, $y);
			} else {
				$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
			return FALSE;
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}	


}

/* End of file nucleo.php */
/* Location: ./app/controllers/nucleo.php */