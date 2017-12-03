function validar(idCampo,type,campo=''){
	
	if(type=='email'){
		//var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		campo = 'Email';
	}

	if(type=='tel'){
		var regex = /^([0-9\-\+]{7,15})+$/g;
		campo='Telefono';
	}

	if(type=='num'){
		var regex = /^\d+$/g;
		campo='Numero';

	}
	//alert($('#'+idCampo).val());
	if (regex.test($('#'+idCampo).val())) {
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