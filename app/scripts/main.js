'use strict';
$(document).ready(function(){
	var datatable=$('#datatable').DataTable({
		'processing':true,
		'serverSide':true,
		'ajax':'php/main.php',
		'language': {
               'sProcessing': 'Procesando...',
               'sLengthMenu': 'Mostrar _MENU_ registros',
               'sZeroRecords': 'No se encontraron resultados',
               'sEmptyTable': 'Ningún dato disponible en esta tabla',
               'sInfo': 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
               'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros',
               'sInfoFiltered': '(filtrado de un total de _MAX_ registros)',
               'sInfoPostFix': '',
               'sSearch': 'Buscar:',
               'sUrl': '',
               'sInfoThousands': ',',
               'sLoadingRecords': 'Cargando...',
               'oPaginate': {
                   'sFirst': 'Primero',
                   'sLast': 'Último',
                   'sNext': 'Siguiente',
                   'sPrevious': 'Anterior'
               },
               'oAria': {
                   'sSortAscending': ': Activar para ordenar la columna de manera ascendente',
                   'sSortDescending': ': Activar para ordenar la columna de manera descendente'
               }
           },
           'columns':[
           		{'data' : 'nombreDoctor'},
           		{'data' : 'numColegiado'},
           		{
           			'data' : 'clinicas',
           			'render' : function(data){
           				return '<ul><li>'+data+'</li></ul>';
           			}
           		},
           		{	
           			'data' : 'idDoctor',
           			'render':function(data){
           				return '<a class="btn btn-info editarbtn" href="#">Editar</a>';
           			}
           		},
           		{
           			'data' : 'idDoctor',
           			'render' : function(data){
           				return '<a class="btn btn-warning borrarbtn" href="#">Borrar</a>';
           			}
           		}
           ]
	});


//BORRAR
	$('#datatable').on('click' , '.borrarbtn' , function(e){
			e.preventDefault();
			var nRow = $(this).parents('tr')[0];
			var aData = datatable.row(nRow).data();
			var id_doctor = aData.idDoctor;
			
			$('#modalBorrar').modal('show');

//!!!!!se acumulan los eventos:  http://www.parallaxinfotech.com/blog/preventing-duplicate-jquery-click-events
			$('#modalBorrar').off('click' , '.confirmarBorrar').on('click','.confirmarBorrar', function(){

						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: 'php/borrar.php',
							data:{
								iddoctor : id_doctor
							},
							error: function(xhr,status,error){
								alert('Ha entrado en error en ajax');
								$.growl.error({message: "Error en la llamada ajax"});
							},
							success: function(data){							    					
								datatable.draw();
								$('#modalBorrar').modal('hide');
								var mensaje=data[0].mensaje;
								$.growl.notice({message: mensaje});
							}
						});
			});
	});

//EDITAR
	$('#datatable').on('click','.editarbtn', function(e){
				e.preventDefault();

				var nRow = $(this).parents('tr')[0];
				var aData = datatable.row(nRow).data();
				var id_doctor = aData.idDoctor;
				


				var nombre=aData.nombreDoctor;
				var colegiado=aData.numColegiado;
				var clinic = aData.clinicas.split(',');
				$('#editarNombre').val(nombre);
				$('#numColegiado').val(colegiado);

				$('#selectEditar').load('php/cargar_clinicas.php');				

				/*clinic.forEach(function(entry){
					console.log('clinica de aData:');
					console.log(entry);					
					$('#selectEditar').find('option').each(function(){
						var cli = $(this);
						console.log('Clinicas del formulario:');
						console.log(cli);
						if(entry==cli.text()){
							$(this).prop('selected',true);
						}
					});
				});*/

				/*clinic.forEach(function(entry){
					var seleccionada = entry;
					console.log('clinica de aData:');
					console.log(seleccionada);
					$('#selectEditar option').filter(function(){
						return this.text.toLowerCase() === seleccionada.toLowerCase();
						console.log('clinica de formulario:');
					console.log(this.text());
					}).attr('selected' , true);
				});*/

				clinic.forEach(function(entry){
					console.log('clinica de aData:');
					console.log(entry);					
					$('#selectEditar option').each(function(){
						var cli = $(this).text();
						console.log('Clinicas del formulario:');
						console.log(cli);
						if(entry==cli){
							$(this).prop('selected',true);
						}
					});
				});

				$('#modalEditar').modal('show');
				
				$('#modalEditar').off('click' , '.confirmarEditarbtn').on('click','.confirmarEditarbtn', function(){
						var nom = $('#editarNombre').val();
						var cole = $('#numColegiado').val();
						var clinicas = $('#selectEditar').val();

						$.ajax({
							type: 'POST',
							dataType: 'json',
							url: 'php/editar.php',
							data: {
								id_doctor : id_doctor,
								nombre : nom,
								colegiado : cole,
								clinicas : clinicas
							},
							error: function(xhr,status,error){
								alert('Ha entrado en error en ajax');
								$.growl.error({message: "Error en la llamada ajax"});
							},
							success: function(data){							    					
								datatable.draw();
								$('#modalEditar').modal('hide');
								var mensaje=data[0].mensaje;
								$.growl.notice({message: mensaje});
							}
						});
				});
				
	});

});