 window.onload = function () {

    var fecha;

    //obtenemos la fecha actual
	var now = new Date();
	var day =("0"+now.getDate()).slice(-2);
	var month=("0"+(now.getMonth()+1)).slice(-2);
	var today=now.getFullYear()+"-"+(month)+"-"+(day);
	
	FechaInicio = today;
	FechaFin = today;

    $.ajax({
        url: '../ajax/caja.php?',
        type: 'post',
        data: {'FechaInicio': FechaInicio,'FechaFin':FechaFin},
        dataType: 'json',
        success:function(response) {   
			//console.log(response);    
			//var data=JSON.parse(response);
			//alert (response.Totalventas+"hola");
				$('#ventas').val(response.Totalventas).toFixed(2);
			} //success function
        }) 
 }


function Validarventas() {
	var Docientos,Cien,Cincuenta,Veinte,Diez,Cinco,uno;
	var Unq,Cincuentale,Veinticincolen,Diezlen;
	var Suma,Venta;

	//BILLETES

	Docientos = $('#docientos').val();
	Cien = $('#cien').val();
	Cincuenta = $('#cincuenta').val();
	Veinte = $('#veinte').val();
	Diez = $('#diez').val();
	Cinco = $('#cinco').val();
	uno = $('#unob').val();

	//MONEDAS

	Unq =  $('#uno').val();
	Cincuentale = $('#cincuentalen').val();
	Veinticincolen =  $('#veinticincolen').val();
	Diezlen = $('#diezcentavos').val();


	//verificar vacios

	if (Docientos == '' || Cien == '' || Cincuenta == '' || Veinte == '' || Diez == '' || Cinco == '' 
			|| uno == '' || Unq == '' || Cincuentale == '' || Veinticincolen == '' || Diezlen == ''
		)
	{
		alert ("POR FAVOR LLENE TODOS LOS CAMPOS");
	}
	else
	{
		//SUMA BILLETES

		var SumaBilletes = (Docientos * 200) + (Cien * 100) + (Cincuenta * 50) + (Veinte * 20)
		+ (Diez * 10) +(Cinco * 5)+ (uno * 1);

		//alert(SumaBilletes + "BILLETES");
		//SUMA MONEDAS

		var SumaMonedas = (Unq*1) + (Cincuentale * 0.5) + (Veinticincolen * 0.25) + (Diezlen*0.10);
		//alert(SumaMonedas + "MONEDAS");

		Suma = SumaBilletes + SumaMonedas;
		$('#suma').val(Suma);

		Venta = $('#ventas').val();

		if (Venta == Suma)
		{
			alert ('Caja cerrada exitosamente');
		}
		else
		{
			alert('FALTA DE DINERO');
			var Monto1 =  $('#ventas').val();
			var Monto2 = $('#suma').val();

			var Faltante = Monto2-Monto1;
			Faltante = Faltante.toFixed(2);

			
			$('#VENTASDIA').val(Faltante);
		}
	}
}