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
});
