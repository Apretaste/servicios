var service = {
	// get the value from the 
	submit: function() {
		// get the coupon
		var coupon = $('#coupon').val();

		// check the coupon is not empty
		if( ! coupon) {
			M.toast({html: 'El cupón no puede estar vacío'});
			return false;
		}

		// send the request
		apretaste.send({
			command: "CUPONES CANJEAR", 
			data: {"coupon":coupon},
			redirect: true});
	}
}
