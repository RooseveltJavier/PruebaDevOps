		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_proformas.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la factura")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_proformas.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		function imprimir_proforma(id_proforma){
			VentanaCentrada('./pdf/documentos/ver_proforma.php?id_proforma='+id_proforma,'Proforma','','1024','768','true');
		}


		function prof_to_fact(id)
	    {
	    var mensaje;
	    var opcion = confirm("Convertir la proforma "+id+" a Factura");
	    if (opcion == true) {

		$.ajax({
	        type: "GET",
	        url: "./ajax/agregar_prof_to_fact.php",
	        data: "id="+id,"q":q,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
	        success: function(datos){
			$("#resultados").html(datos);
			load(1);
			}
		});
	        
		}
		/*document.getElementById("ejemplo").innerHTML = mensaje;*/
	}

