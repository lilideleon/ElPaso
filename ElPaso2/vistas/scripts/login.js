$(document).ready(function(){
	$("#frmAcceso").on('submit', function(e)
	{
		e.preventDefault();
		e.stopPropagation();
		
		logina=$("#logina").val();
		clavea=$("#clavea").val();
		
		if (!logina || !clavea) {
			bootbox.alert("Por favor ingrese usuario y contraseña");
			return false;
		}

		$.ajax({
			url: "../ajax/usuario.php?op=verificar",
			type: "POST",
			data: {"logina":logina, "clavea":clavea},
			dataType: "json",
			success: function(data)
			{
				console.log("Respuesta recibida:", data);
				
	           if (data && data.idusuario)
	            {
	            	console.log("Login exitoso, redirigiendo...");
	            	window.location.href = "escritorio.php";
	            }else{
	            	console.log("Login fallido");
	            	bootbox.alert("Usuario y/o Password incorrectos");
	            }
			},
			error: function(xhr, status, error)
			{
				console.log("Error AJAX:", error);
				console.log("Respuesta:", xhr.responseText);
				bootbox.alert("Error al conectar con el servidor");
			}
		});
		
		return false;
	});
});