/**
 * 
 */

jQuery.noConflict();

jQuery( document ).ready(function( $ ) {
	
	$('tr', 'table.admin_page_tef-manage-taxonomy').each(function () {
        $(this).width( $(this).width() );
    });
	
	$('td:not(.hidden), th:not(.hidden)', 'table.admin_page_tef-manage-taxonomy').each(function () {
        $(this).width( $(this).width() );
    });
	
	$("table.admin_page_tef-manage-taxonomy tbody").sortable({
		handle: ".sortable-icon"
	}).disableSelection();
	
	
	// TABLE TAXONOMY FIELDS
	
	$('#tef-admin form.field-form').on('submit', function(event){
		event.preventDefault();
		var form = $(this);
		
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				action: 'tef_save_field',
				form: form.serialize(),
			},
			success: function(result){
				if(result)
					console.log(result);
				else
					console.error(result);
			},
			error: function(){
				console.error('ERROR!');
			}
		});
		
	});
	
	$('#tef-admin .row-actions .edit a').on('click',function(event){
		event.preventDefault();
		
		var container = $(this).closest('tr'),
			label_col = container.find('td.label');
		
		container.addClass('in-edition');
		
		label_col.attr('colspan',4);
		
	});
	
	$('#tef-admin a.unlock-field').on('click', function(){
		if($(this).siblings('input[readonly=readonly]').length)
			$(this).siblings('input[readonly=readonly]').removeAttr('readonly').focus();
	});
	
	
	
});
