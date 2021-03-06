<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<html lang="es_MX">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/bootstrap-3.3.1/dist/css/bootstrap.min.css">
		
</head>
<body>

<?php date_default_timezone_set('America/Mexico_City');  ?>
<div class="container">
	<div>
		<div>
			
			<table style="width: 100%; border: 2px solid #222222;">
				<thead>
					<tr>
						<td colspan="<?php echo (($this->session->userdata('id_perfil')==1) ? 6 : 5); ?>" style="border-top: 1px solid #222222; ">
							<span><b>Fecha y hora: </b> <?php echo date( 'd-m-Y h:i:s A',  strtotime ( gmt_to_local( 'UM1', time(), TRUE)  ) );  ?></span>
							<p><b >Top 10</b></p>
						</td>
						<td colspan="2" style="border-top: 1px solid #222222; ">
						  	
							<?php echo '<img src="'.base_url().'img/unnamed.png" width="93px" height="48px"/>'; ?>
						</td>

					</tr>	

					<tr><th> </th></tr>
					<tr>

						<th width="<?php echo (($this->session->userdata('id_perfil')==1) ? 13 : 20); ?>%">Referencia</th>
						<th width="25%">Descripción</th>
						
						<th width="15%">Metros Vendidos</th>
						
						
						<!-- <th width="12%">Imagen</th> -->
						<th width="7%">Color</th>
						

						<th width="18%">Composición</th>
						<th width="9%">Calidad</th>
						<?php if ($this->session->userdata('id_perfil')==1) { ?>
							<th width="7%">Precio</th>
						<?php } ?>	
						<th width="6%">Almacén</th>	








					</tr>
				</thead>
				<tbody>
				<?php if ( isset($movimientos) && !empty($movimientos) ): ?>
					<?php foreach( $movimientos as $movimiento ): ?>
						<tr>
							<td width="<?php echo (($this->session->userdata('id_perfil')==1) ? 13 : 20); ?>%" style="border-top: 1px solid #222222;"><?php echo $movimiento->referencia; ?></td>								
							<td width="25%" style="border-top: 1px solid #222222;"><?php echo $movimiento->descripcion.'<br/><b style="color:red;">Cód: </b>'.$movimiento->codigo_contable; ?></td>
							
							<td width="15%" style="border-top: 1px solid #222222;"><?php echo $movimiento->suma; ?></td>
							
							<!--
							<td width="12%" style="border-top: 1px solid #222222;"><?php echo '<img src="'.base_url().'uploads/productos/thumbnail/300X300/'.substr($movimiento->imagen,0,-4).'_thumb'.substr($movimiento->imagen,-4).'" border="0" width="75" height="75">'; ?></td>
							-->
							<td width="7%" style="border-top: 1px solid #222222;"><?php echo $movimiento->nombre_color.                                      
                                        '<div style="background-color:#'.$movimiento->hexadecimal_color.';display:block;width:15px;height:15px;margin:0 auto;"></div>'; ?></td>
							
							
							<td width="18%" style="border-top: 1px solid #222222;"><?php echo $movimiento->composicion;  ?></td>
							<td width="9%" style="border-top: 1px solid #222222;"><?php echo $movimiento->calidad; ?></td>
							<?php if ($this->session->userdata('id_perfil')==1) { ?>
								<td width="7%" style="border-top: 1px solid #222222;"><?php echo $movimiento->precio; ?></td>
							<?php } ?>	
							<td width="6%" style="border-top: 1px solid #222222;"><?php echo $movimiento->almacen; ?></td>

    
                                   

						</tr>
					<?php endforeach; ?>
				<?php else : ?>
						<tr class="noproducto">
							<td colspan="9">No se han agregado producto</td>
						</tr>
				<?php endif; ?>	
				</tbody>	


		
					
			</table>
		</div>
	</div>
</div>

	
</body>
</html>			