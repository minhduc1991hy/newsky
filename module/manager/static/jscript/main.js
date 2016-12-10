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