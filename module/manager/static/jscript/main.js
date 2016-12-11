$Core.datepicker = function(ele){
	$(ele).datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	});
}

$Core.viewMoreInfoHorizontal = function(ele){
	if($(ele).closest('.wrapper_line').hasClass('open')){
		$(ele).text('Xem thêm').closest('.wrapper_line').removeClass('open');
	}else{
		$(ele).text('Thu gọn').closest('.wrapper_line').addClass('open');
	}
}

$Behavior.mainManager = function(){
	$('#collapseSearch').on('hide.bs.collapse', function () {
		$('body').removeClass('has-search');
	});

	$('#collapseSearch').on('show.bs.collapse', function () {
		$('body').addClass('has-search');
	});

	//Date picker
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	});

	$('.date_rage').daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('.date_rage').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
	});

	$('.date_rage').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});
}
