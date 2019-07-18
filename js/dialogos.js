function mostrarDetalles(folio) {
    var dialog = bootbox.alert({
      title: 'Detalles del anteproyecto',
      //title: '<div class="alert alert-info" role="alert"><h5>Detalles del anteproyecto</h5></div>',
      size: "large",
    message: '<object class="preview-pdf-file" type="text/html" data="ver-detalle-tesis.php?folio=' + folio + '"></object>',
    className : "preview-pdf-modal",
    onEscape: function() {}	        
  });
  /*$('.preview-pdf-modal .modal-content')
		        .draggable({
		        	cancel: ".preview-pdf-modal .preview-pdf-file"
		        })
		        .resizable({
		          minWidth: 350,
		          minHeight: 350,
		          alsoResize: '.preview-pdf-modal .bootbox-body'
		        });    */
}
