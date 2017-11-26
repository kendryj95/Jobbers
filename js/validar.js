function validar(idCampo,type,campo=''){
	if(type=='email'){
		//var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		var regex = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
		campo = 'Email';
	}
	if(type=='tel'){
		var regex = new RegExp(/[0-9\-\(\)\+]/);
		campo= campo == ''? 'Telefono':campo;
	}

	if(type=='num'){
		var regex = new RegExp(/[0-9]/);
		campo= campo == ''? 'Numero':campo;

	}

	if (regex.test($('#'+idCampo).val().trim())) {
	    return true;
	}else{
		$('#'+idCampo).val('');
		swal({
			title: 'Error',
			text: "Escriba un "+campo+" válido ",
			type: 'error'
		});
	}	
}