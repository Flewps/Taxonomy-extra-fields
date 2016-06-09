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
	
	
	// LISTENERS
	$('#tef-admin').on('submit', 'form.field-form', tef_save_field);
	
	$('#tef-admin').on('click', '.row-actions .edit a', tef_set_row_in_edition);
	
	$('#tef-admin').on('click', 'a.unlock-field', tef_unlock_field);
	
	$('#tef-admin').on('click', '.add-new-field', tef_add_new_field);

	
	/**
	 * 
	 */
	function tef_row_actualize( row, data ){
		
		row.find('td.ID').html(data.ID);
		
		row.find('td.taxonomy').html(data.taxonomy);
		
		row.find('td.position input').attr('name','field['+data.ID+']').val(data.position);
		
		row.find('td.label span.label').html(data.label);

		if(data.required){
			if(0 == row.find('td.label a.row-title span.required').length)
				row.find('td.label a.row-title').append('<span class="required">*</span>');		
		}else
			row.find('td.label a.row-title span.required').remove();
		
		row.find('td.name').html(data.name);
		
		row.find('td.type').html(tef.translations.types[data.type]);
		
		row.find('td.description').html(data.description);
		
		row.find('td.required').html(data.required);
		
	}
	
	/**
	 * 
	 */
	function tef_save_field(event){
		event.preventDefault();
		var form = $(this),
			container = $(this).closest('tr'),
			label_col = container.find('td.label');
		
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				action: 'tef_save_field',
				form: form.serialize(),
			},
			success: function(result){
				if(result != 0){
					tef_row_actualize(container, JSON.parse(result) );
					container.removeClass('in-edition');
					label_col.removeAttr('colspan');

					var n = noty({
						layout: 'topRight',
						timeout: 1000,
						text: tef.translations.msg.saved,
						type: 'success',
						closeWith: ['click','hover', 'backdrop'],
						animation: {
					        open: 'animated tada', // Animate.css class names
					        close: 'animated hinge', // Animate.css class names
					        easing: 'swing', // unavailable - no need
					        speed: 500, // unavailable - no need  
					    },					   
					});
					
				}else
					console.error(result);
			},
			error: function(){
				console.error('ERROR!');
			}
		});
		
	}

	/**
	 * 
	 */
	function tef_unlock_field(){
		
		var elem = $(this);
		
		if( elem.siblings('input[readonly=readonly]').length ){
			
			var n = noty({
				layout: 'center',
				//timeout: 1000,
				text: tef.translations.msg.confirm,
				type: 'alert',
				 dismissQueue: true,
			    modal: true,
				animation: {
			        open: 'animated pulse', // Animate.css class names
			        close: 'animated fadeOut', // Animate.css class names
			        easing: 'swing', // unavailable - no need
			        speed: 200, // unavailable - no need  
			    },
			    buttons: [
				   {
					   addClass: 'button button-primary', text: tef.translations.msg.accept, onClick: function ($noty) {
						   $noty.close();
						   $(elem).siblings('input[readonly=readonly]').removeAttr('readonly').focus();
					   }
				   },
				   {
					   addClass: 'button button-danger', text: tef.translations.msg.cancel, onClick: function ($noty) {
						   $noty.close();
				       }
				   },
			   	],
			   
			});
			
		}
			//
	}


	/**
	 * 
	 */
	function tef_set_row_in_edition(event){
		event.preventDefault();
		
		var container = $(this).closest('tr'),
			label_col = container.find('td.label');
		
		container.addClass('in-edition');
		
		label_col.attr('colspan',4);
		
	}
	
	/**
	 * 
	 */
	function tef_add_new_field(event){
		
		event.preventDefault();
		
		
		
		var data = $('form#defaults');
		
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				action: 'tef_get_row_template',
				data: data.serialize(),
			},
			success: function(result){
				
				if( result ){
					var html = jQuery.parseHTML( result );
					
					//$(html).addClass('in-edition');
				
					$('table.admin_page_tef-manage-taxonomy tr.no-items').fadeOut(500);
					
					$('table.admin_page_tef-manage-taxonomy > tbody').delay(500).append( html );
					
					$('.row-actions .edit a', html).click();
					
					$('input[name=label]',html).focus();
				}
				
			},
			error: function(){
				console.error('ERROR!');
			}
		});
		
	}
	
});
