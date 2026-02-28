//funcion listar
function listar(){
	var FechaInicio;
	var FechaFin;
	FechaInicio = $('#FechaInicio').val();
	FechaFin = $('#FechaFin').val();

	if (FechaInicio == '' || FechaFin =='')
	{
		alert("ELIJA EL RANGO DE FECHAS");
	}
	else
	{
		//alert(FechaInicio + " " + FechaFin);
		tabla=$('#tbllistado2').dataTable({

			footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

 
            // Total over all pages
            total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(6, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(6).footer()).html('Q.' + pageTotal.toFixed(2) + ' ( Q.' + total.toFixed(2) + ' total)');
        },

			"aProcessing": true,//activamos el procedimiento del datatable
			"aServerSide": true,//paginacion y filrado realizados por el server
			dom: 'Bfrtip',//definimos los elementos del control de la tabla
			buttons: [
	                  'copyHtml5',
	                  'excelHtml5',
	                  'csvHtml5',
	                  'pdf'
			],
			"ajax":
			{
				url:'../ajax/venta.php?op=listar2',
				type: "post",
				data: {'FechaInicio': FechaInicio,'FechaFin':FechaFin},
				dataType : "json",
				error:function(e){
					console.log(e.responseText);
				}
			},
			"bDestroy":true,
			"iDisplayLength":15,//paginacion
			"order":[[0,"desc"]]//ordenar (columna, orden)
		}).DataTable();
	}
}


