$(document).on("click", "#start-help", function(e) {
				var tour = new Tour({
				steps: [
					{
						element: "#start-help",
						title: "¡Bienvenido!",
						content: "Como su asistente de ayuda le acompaño en el recorrido para indicarle cual es el contenido del <strong>Sistema THOR</strong>.",
						placement: "bottom"
                    },{
						element: "#li-nuevo-anteproyecto",
						title: "Nuevo Anteproyecto",
						content: "Este enlace se dirige a la captura inicial de un anteproyecto de tesistas interesados en algún tema expuesto en el seminario de tesis.",
						placement: "right"
					},{
						element: "#li-ver-anteproyecto",
						title: "Lista de anteproyectos",
						content: "La lista de anteproyectos es una herramienta que visualiza por medio de una tabla general todos los anteproyectos que están en procesos y que son inferiores al <strong>F4</strong>. La tabla muestra detalles y ofrece capturar el F siguiente que corresponde al anteproyecto seleccionado.",
						placement: "right"
					},{
						element: "#li-estadisticas",
						title: "Estadísticas",
						content: "Aqui estan las Estadísticas (detallar más).",
						placement: "right"
                    },{
						element: "#li-buscar",
						title: "Búsqueda por matrícula",
						content: "Para capturar el documento correspondiente al tesista interesado, debe de ingresar su matrícula. Si la consulta fue un éxito será dirigido a la captura de lo contrario el sistema lo hará saber.",
						placement: "left"
					},{
						element: "#li-tesis-proceso",
						title: "Tesis en proceso",
						content: "Todo anteproyecto que haya llegado al <strong>F4</strong> se convierte en una tesis en proceso por lo tanto se muestra en una tabla que ofrece el siguiente enlace.",
						placement: "left"
					},{
						element: "#li-estadisticas-tesis",
						title: "Estadísticas",
						content: "Aqui estan las Estadísticas (detallar más).",
						placement: "left"
                    },{
						element: "#li-formatos",
						title: "Formatos",
						content: "El siguiente enlace proporciona los ocho formatos de <strong>F</strong>’s para el seguimiento de un anteproyecto a tesis.",
						placement: "bottom"
					},{
						element: "#li-profesores",
						title: "Listado de profesores",
						content: "Cuando se requiere de información de algún director de tesis o revisor, el siguiente enlace visualiza por medio de una tabla todos los profesores con información propia.",
						placement: "bottom"
					},{
						element: "#li-usuarios",
						title: "Listado de usuarios",
						content: "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.",
						placement: "bottom"
					},{
						element: "#li-modificar-tesis",
						title: "Modificar tesis",
						content: "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.",
						placement: "bottom"
					},{
						element: "#table-tesis-concluidas",
						title: "Tesis concluídas",
						content: "En esta tabla se muestra toda aquella tesis que ha llegado a la autorización de impresión descartándolas de la lista de anteproyecto y tesis en proceso ya que forman partes de proyectos concluidos.",
						placement: "bottom"
					},{
						element: "#a-close-session",
						title: "Cerrar sesión",
						content: "Termina la sesión del usuario activo redirigiéndolo a la página de autenticación.",
						placement: "bottom"
					}
				],
				template: "<div class='popover tour'>"+
								"<div class='arrow'></div>"+
								"<div class='text-right'>"+
									"<button type='button' class='close' data-role='end' data-dismiss='alert' aria-label='Close' title='Cerrar'>"+
										"<span aria-hidden='true'>&times;</span>"+
								  	"</button>"+
								"</div>"+
								"<h3 class='popover-title'></h3>"+
								"<div class='popover-content'></div>"+
								"<div class='popover-navigation text-center'>"+
									"<button class='btn btn-success btn-sm' data-role='prev'>« Anterior</button>"+
									"<span data-role='separator'>|</span>"+
									"<button class='btn btn-success btn-sm' data-role='next'>Siguiente »</button>"+
								"</div>"+
						"</div>"
			});

				//se inicia el tour
				tour.init();
				//comienza desde inicio
			    tour.restart();

			});