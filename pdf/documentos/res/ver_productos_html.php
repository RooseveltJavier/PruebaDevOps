<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	/*background:#2c3e50;
	border: 1px solid black;*/
	border-bottom: 1px solid black;
	padding: 4px 4px 4px;
	color:black;
	font-weight:bold;
	font-size:10px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="0mm" style="font-size: 9pt; font-family: arial">

	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
			<td style="width:50%;"><br>
				<span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?>- PRODUCTOS</span> 
			<br><br>
				<!--<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
					<tr>
						<td><img style="width: 20px" src="../../img/ruc.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','codigo_postal', 'id_perfil', 1);?></td>
					</tr>
					<tr>
						<td><img style="width: 20px" src="../../img/phone.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','telefono', 'id_perfil', 1);?></td>
					</tr>
					<tr>
						<td><img style="width: 20px" src="../../img/email.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','email', 'id_perfil', 1);?></td>
					</tr>
					<tr>
						<td><img style="width: 20px" src="../../img/direccion.png" alt="telefono"></td>
						<td><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)?></td><!--." ".get_row('perfil','estado', 'id_perfil', 1);--><!--
					</tr>
				</table>-->
			</td>
		</tr>
	</table>
<br><br>

		    <table cellspacing="0" style="width: 90%; text-align: left; font-size: 10pt;">
		        <tr>
		        	<th style="width: 15%;text-align:center" class='midnight-blue'>CODIGO</th>
		            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
		            <th style="width: 10%;text-align: right" class='midnight-blue'>PRECIO IVA</th>
		            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
		            <th style="width: 5%;text-align:center" class='midnight-blue'>CANT R.</th>
		            <!--<th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>-->
		            
		        </tr>

		<?php
		$nums=1;
		$sumador_total=0;$sumador_sinIVA=0;
		$sql=mysqli_query($con, "select * from products");

		while ($row=mysqli_fetch_array($sql))
			{
			$id_producto=$row["id_producto"];
			$codigo_producto=$row['codigo_producto'];
			$cantidad=$row['cantidad_producto'];
			$nombre_producto=$row['nombre_producto'];
			$iva_producto=$row['status_producto'];
			
			$precio_venta=$row['precio_producto'];
			$precio_venta_f=number_format($precio_venta,2);//Formateo variables
			$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas

			$precio_total=$row['precio_iva_producto'];
			$precio_total_f=number_format($precio_total,2);//Precio total formateado
			$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas

			if ($nums%2==0){
				$clase="clouds";
			} else {
				$clase="silver";
			}
			?>

		        <tr>
		            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center"><?php echo $codigo_producto; ?></td>
		            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php if($iva_producto!=1){ echo $nombre_producto;}else{echo "* ".$nombre_producto;}?></td>
		            <td class='<?php echo $clase;?>' style="width: 10%; text-align: right"><?php echo $simbolo_moneda;?><?php echo $precio_total_r;?></td>
		            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
		            <td class='<?php echo $clase;?>' style="width: 5%; text-align: center"></td>
		            <!--<td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $simbolo_moneda;?><?php echo $precio_venta_f;?></td>-->
		            
		            
		        </tr>

			<?php 

			
			$nums++;
			}

		?>

		    </table>


</page>