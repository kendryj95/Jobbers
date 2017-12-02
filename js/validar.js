function validar(idCampo,type,campo=''){
	
	if(type=='email'){
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		campo = 'Email';
	}
	
	if(type=='texto'){
		var regex = /^([a-zA-ZñÑáéíóúÁÉÍÓÚ])+$/;
		campo == ''? 'Nombre':campo;
	}

	if(type=='tel'){
		var regex = /^([0-9\-\+]{7,15})+$/g;
		campo='Telefono';
	}

	if(type=='num'){
		var regex = /^\d+$/g;
		campo == ''? 'Numero':campo;
	}

	if (regex.test($('#'+idCampo).val())) {
		$('#'+idCampo).parent().removeClass('has-error');
		return true;
	}else{
		$('#'+idCampo).val('');
		$('#'+idCampo).parent().addClass('has-error');
		swal({
			title: 'Error',
			text: "Escriba un "+campo+" válido ",
			type: 'error'
		});
	}	
}