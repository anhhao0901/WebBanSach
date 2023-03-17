$(function(){
	$('.ck_editor').each(function(index, el) {
		var id = $(this).attr('id');

		CKEDITOR.replace( id, {

			height : 500,

			filebrowserBrowseUrl : 'ckfinder/ckfinder.html',

			filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',

			filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',

			filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

			filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

			filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'

		});
	});	
})
