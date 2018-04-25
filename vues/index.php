<?php 
	if(!file_exists("plugins/".$_GET['tools']."/forms/"))
	{
		mkdir("plugins/".$_GET['tools']."/forms/");
	}
	if(!file_exists("plugins/".$_GET['tools']."/widgets/"))
	{
		mkdir("plugins/".$_GET['tools']."/widgets/");
	}
	if(isset($_GET['delete']))
	{
		unlink("plugins/".$_GET['tools']."/widgets/".$_GET['delete']);
		delete_shortcode("Formbuilder - ".$_GET['delete']);
		unlink("plugins/".$_GET['tools']."/forms/".$_GET['delete']);
		
		header("location: outils.php?tools=form_builder&page=index");
	}
	if(isset($_POST['save']))
	{
		//si ce n'est pas un nouveau formulaire
		if(isset($_GET['id']))
		{
			$nom = $_POST['nameForm'];
			$contenu = $_POST['form'];
			
			$widgetMaker = file_get_contents("plugins/".$_GET['tools']."/asset/widget_maker");
			
			$widgetMaker = str_replace("[[CONTENT]]", $contenu, $widgetMaker);
			$widgetMaker = str_replace("[[EMAIL]]", $_POST['destination'], $widgetMaker);
			
			
			//WIDGET READY
			//$widgetMaker
			unlink("plugins/".$_GET['tools']."/widgets/".$_GET['id']);
			delete_shortcode("Formbuilder - ".$_GET['id']);
			add_shortcode("Formbuilder - ".$nom, "[shortcode plugin=form_builder id=\"".$nom."\"]", "");
			file_put_contents("plugins/".$_GET['tools']."/widgets/".$nom, $widgetMaker);
			//editable
			
			unlink("plugins/".$_GET['tools']."/forms/".$_GET['id']);
			file_put_contents("plugins/".$_GET['tools']."/forms/".$nom, $contenu);
		}
		else
		{
			$nom = $_POST['nameForm'];
			$contenu = $_POST['form'];
			
			$widgetMaker = file_get_contents("plugins/".$_GET['tools']."/asset/widget_maker");
			
			$widgetMaker = str_replace("[[CONTENT]]", $contenu, $widgetMaker);
			$widgetMaker = str_replace("[[EMAIL]]", $_POST['destination'], $widgetMaker);
			
			
			//WIDGET READY
			//$widgetMaker
			
			add_shortcode("Formbuilder - ".$nom, "[shortcode plugin=form_builder id=\"".$nom."\"]", "");
			file_put_contents("plugins/".$_GET['tools']."/widgets/".$nom, $widgetMaker);
			//editable
			
			
			file_put_contents("plugins/".$_GET['tools']."/forms/".$nom, $contenu);
			
		}
		
		$oldName = $name;
	}
	
	if(isset($_GET['id']))
	{
		$oldName = $_GET['id'];
		$contenu = file_get_contents("plugins/".$_GET['tools']."/forms/".$oldName);
		
	}
	else
	{
		$contenu = "";
	}
	
?>


<div id="" class='col-md-12'>
	<div class='col-md-4'>
		<div class='col-md-12 cadre'>
			<h3>Liste de vos formulaires</h3>
			<?php 
				
				$dossier = "plugins/".$_GET['tools']."/forms";
				$dossier = scandir($dossier);
				
				foreach($dossier as $formulaire)
				{
					if($formulaire != "." AND $formulaire != "..")
					{
						echo "<div style='border-bottom: 1px solid #dadada; padding: 15px 0px' class='col-md-12'><a style='color: #4C4C4C' href='form_builder&page=index&id=".$formulaire."'>".$formulaire."</a><a style='font-size: 10px; color: #4C4C4C; margin-top: 5px; float: right' href='form_builder&page=index&delete=".$formulaire."'>Supprimer</a></div>";
					}
				}
				
				echo "<a class='' style='padding: 15px; display: inline-block; border: 1px solid black; color: black; margin-top: 15px' href='form_builder&page=index'>+ Créer un nouveau formulaire</a>";
			?>
			
		</div>
	</div>
	<div class='col-md-8'>
		<form method='POST' action class='col-md-12 cadre'>
			<h3>Personnalisation du formulaire</h3>
			<hr>
			<h6 style='font-weight: bold; font-size: 16px; text-align: center; margin-bottom: 15px;' >Option du formulaire</h6>
			<div class='row'>
				<label class='col-md-4 labelLeft'>Destination de l'email</label><input required value='<?=$_POST['destination']?>' class='col-md-6' type='email' name='destination'/>
			</div>
			<div class='row'>
				<label class='col-md-4 labelLeft'>Nom du formulaire</label><input pattern="[a-zA-Z0-9]+" class='col-md-6' value='<?=$oldName?>' type='text' name='nameForm'/>
			</div>
			<h6 style='margin-top: 15px; font-weight: bold; font-size: 16px; text-align: center; margin-bottom: 15px;' >Composition du formulaire</h6>
			<textarea id="form" name="form"><?=htmlentities($contenu)?></textarea>
			<input type='submit' value='Sauvegarder' name='save'>
			<div id='formPopup' style='display: none'>
				<div class='col-md-8 col-md-offset-2'>
					<h3 style='font-size: 24px; font-weight: bold; margin-bottom: 30px; padding: 15px; text-align: center'>Ajouter un champs</h3>
					<div class='row'>
						<label class='labelLeft col-md-2' >Type</label>
						<select id='type' class='col-md-10'>
							<option value='text'>Texte</option>
							<option value='textarea'>Zone de texte</option>
							<option value='email'>email</option>
							<option value='number'>Nombre</option>
							<option value='submit'>Bouton de soumission</option>
							<option value='file'>Fichier</option>
						</select>
					</div>
					<div class='row'>
						<label class='labelLeft col-md-2'>Nom</label>
						<input required class='col-md-10' id='name' type='text' />
					</div>
					<div class='row'>
						<label class='labelLeft col-md-2'>Placeholder</label>
						<input class='col-md-10' id='placeholder' type='text' />
					</div>
					<div class='row'>
						<label class='labelLeft col-md-2'>Classe</label>
						<input class='col-md-10' id='classe' type='text' />
					</div>
					<div class='row'>
						<label class='labelLeft col-md-2'>Valeur</label>
						<input class='col-md-10' id='value' type='text' />
					</div>
					<div class='row'>
						<label class='labelLeft col-md-2'>Taille</label>
						<input class='col-md-10' id='width' value='100%' type='text' />
					</div>
					<div class='row'>
						<label class='labelLeft col-md-2'>Requis ?</label>
						<select id='required' class='col-md-10'>
							<option value='on'>Oui</option>
							<option value='off'>Non</option>
						</select>
					</div>
					<div class='row' style='text-align: center; margin-top: 30px'>
						<input id='insert' type='button' value='Insérer'>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	
	$(function(){
$('.blackScreen').click(function(){
		removePopup();
	})
    
    $('.addImage').click(function(){
        
        imageLibrary($(this), $(this).attr('data-preview'));
    })	    
    
    function showPopup()
	{
		$('.popup, .blackScreen').fadeIn();
		//$('.body').css({"filter":"blur(10px)"})
	}
	
	function removePopup()
	{
		$('.popup, .blackScreen').fadeOut();
		//$('.body').css({"filter":"blur(0px)"})
	}
tinymce.init({
    	selector: "#form",
    	language : 'fr_FR',
    	height: "200px",
    	menubar: false,
    	themes: "advanced",
    	skin: "light",
    	content_css: "themes/bootstrap.min.css, themes/reset.css",
 		content_style: "#tinymce{padding: 15px} p{padding: 4px; display: block} .bootstrapElement{padding: 15px; border: 1px dotted #dadada}",
 		font_formats: "Roboto (défaut)=Roboto, sans-serif;"+"Andale Mono=andale mono,times;"+ "Arial=arial,helvetica,sans-serif;"+ "Arial Black=arial black,avant garde;"+ "Book Antiqua=book antiqua,palatino;"+ "Comic Sans MS=comic sans ms,sans-serif;"+ "Courier New=courier new,courier;"+ "Georgia=georgia,palatino;"+ "Helvetica=helvetica;"+ "Impact=impact,chicago;"+ "Symbol=symbol;"+ "Tahoma=tahoma,arial,helvetica,sans-serif;"+ "Terminal=terminal,monaco;"+ "Times New Roman=times new roman,times;"+ "Trebuchet MS=trebuchet ms,geneva;"+ "Verdana=verdana,geneva;"+ "Webdings=webdings;"+ "Wingdings=wingdings,zapf dingbats",
 		fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
    	relative_urls : false,
    	plugins: "advlist image imagetools codemirror paste jbimages colorpicker textcolor fullscreen table link contextmenu media preview", 
    	toolbar: "fullscreen | formatselect news image | mybutton | code link backcolor forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | table | fontsizeselect | media | formats | shortcode | grid | input",
    	image_advtab: true,
    	valid_children : '+div[p]',
    	codemirror:{
    	    saveCursorPosition: false,
    	    cssFiles: [
    	        "theme/tomorrow-night-eighties.css"
    	    ],
    	    config: {
    	        theme: 'tomorrow-night-eighties'
    	    }
    	},
    	valid_elements : '+*[*]',
    	extended_valid_elements: "+@[data-options]",
 		contextmenu: "link inserttable | cell row column deletetable | formats",
 		    setup : function(ed) {
        // Add a custom button     
        
        	
        		function addWhiteSpace()
        		{
	        		tinymce.activeEditor.dom.add(tinymce.activeEditor.getBody(), 'p', {title: 'my title'}, '');
        		}
        
        		ed.addButton('grid', {
			      type: 'menubutton',
			      text: 'Grille bootstrap',
			      icon: false,
			      menu: [{
			        text: 'container-fluid',
			        onclick: function() {
			          tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'container-fluid bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			          
			        }
			      },
			      {
			        text: 'container',
			        onclick: function() {
			          tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'container bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			        }
			      },
			      {
			        text: 'row',
			        onclick: function() {
			          tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'row bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			        }
			      },{
			        text: 'Grille',
			        menu: [
			        {
			          text: 'grille 12x1',
			          onclick: function() {
			            for(var i = 0; i<12; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-1 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 6x2',
			          onclick: function() {
			            for(var i = 0; i<6; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-2 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 4x3',
			          onclick: function() {
			            for(var i = 0; i<4; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-3 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 3x4',
			          onclick: function() {
			            for(var i = 0; i<3; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-4 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 2x6',
			          onclick: function() {
			            for(var i = 0; i<2; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-6 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			        },
			        {
			          text: 'grille 1x12',
			          onclick: function() {
			            for(var i = 0; i<1; i++)
			            {
				            tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'col-md-12 bootstrapElement'}, "<p><br></p>"));
			            }
			          }
			          
			        }]
			      },{
			        text: 'Ajouter espace blanc à la fin',
			        onclick: function() {
			          //tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('div', {class : 'container-fluid bootstrapElement'}, "<p><br></p>"));
			          //ed.insertContent('<div class="row bootstrapElement"><p></p></div>');
			          //tinyMCE.EditorManager.activeEditor.blur();
			          addWhiteSpace();
			        }
			      }
			      ]
			    });
			
		        ed.addButton('input', {
		            title : 'Input',
		            icon: "edit",
		            text : "Ajouter un champs",
		            onclick : function(e) {
			          
			           $('.popup').html($("#formPopup").html()).css({"height":"500px"});
			           showPopup(); 
			           
			           $('#insert').click(function(){
				           if($("#name").val() != "")
				           {
					           $("#name").css({"border":"initial"});
					           if($("#type").val() != "textarea")
					           {
						           tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('input', {
							           class : $("#classe").val(),
							           type: $("#type").val(),
							           required: $("#required").val(),
							           value: $("#value").val(),
							           placeholder: $("#placeholder").val(),
							           name: "content["+$("#name").val()+"]",
							           style: "width: "+$("#width").val()
							        }, ""));
					           }
					           else
					           {
						           tinyMCE.activeEditor.selection.setNode(tinyMCE.activeEditor.dom.create('textarea', {
							           class : $("#classe").val(),
							           type: $("#type").val(),
							           required: $("#required").val(),
							           value: $("#value").val(),
							           placeholder: $("#placeholder").val(),
							           name: "content["+$("#name").val()+"]",
							           style: "width: "+$("#width").val()
							        }, "")); 
					           }
					           
					           
					           
					           $('.popup').html("").css({"height":"initial"});
							   removePopup(); 
				           }
				           else
				           {
					           $("#name").css({"border":"1px solid red"});
				           }
			           })
			           
			            
		            }
		        });
		        ed.addButton('news', {
		            title : 'Images',
		            icon: "image",
		            text : "Images",
		            onclick : function(e) {
		                
		                var images = new Object();
                	    $('.popup').html("<iframe src='medias.php' style='height: 100%; width: 100%;'></iframe>");
                			var src;
                			$('.popup iframe').on('load', function(){
                				$(this).contents().on('click', '.imageLibrary', function(){
                					
                				});
                				var iframe = $(this);
                				$(this).contents().on("click", "#insertImage", function(){
                					//var imageArray = new Array();
                					$( ".selectimageContainer" ).sortable({
                						placeholder: "ui-state-highlight"
                					});
                					
                					//$("#votre_image").val("");
                					
                					$('.popup iframe').contents().find(".imageLibrary.selected").each(function(){
                						
                						
                						if($(this).attr('data-parent') == "")
                						{
                							var ID = $(this).attr('data-id');
                						}
                						else
                						{
                							var ID = $(this).attr('data-parent');
                						}
                						
                						var v;
                						var alt;
                						
                						$.ajax({
                							url: "ajax/photo_upload.php",
                							dataType: "json",
                							data: {
                								action: "file_details",
                								ID: ID
                							}
                						}).done(function(json){
                							//console.log(json);
                							var type = $(iframe).contents().find('.imageType').val();
                							v = $(iframe).contents().find('.activeLang').attr('data-tab');
                							console.log(json[type]);
                							src = json[type].file;
                							//alert(src);
                							alt = parseJSONresponse(json[type].alt, v);
                							if(!json[type].parent)
                							{
                							    var parent = json[type].ID;
                							}
                							else
                							{
                							    var parent = json[type].parent;
                							}
                							parent = src;
                							
                						    if(type == "video")
                                	        {
                                           		ed.selection.setContent('<video controls="controls" src="'+src+'"></video>');
                                		   	}
                                		   	else
                                		   	{
                                			   	ed.selection.setContent("<img src='"+src+"'>");
                                		   	}
                                		   	ed.windowManager.nodeChanged();
                							//images.push(json[type].parent);
                							//$('.selectimageContainer').append("<div data-id='"+json[type].ID+"' class='imageSelectionnee' style='width: 100px; height: 100px; background: url("+src+"); background-position: center; background-size: cover; float: left; margin: 5px;'></div>");
                							//editor[which].clipboard.dangerouslyPasteHTML(index, '<img src="'+src+'" alt="'+alt+'" />');
                							
                						});
                						
                						
                						//imageArray.push($(this).attr('data-src'));
                					});
                					
                					
                					
                					console.log(images);
                					//$("#votre_image").val(images.join(";"));
                					removePopup();
                					//
                				})
                			})
                			
                			showPopup();
		                
		                
						


		            }
		        });
    	}
 	});

	function parseJSONresponse(response, lang)
{
	var parsed;
	//alert(response);
	try{
		parsed = $.parseJSON(response)[lang];
		//alert($.parseJSON(response));
	}
	catch(e){
		
	}
	
	if(typeof parsed !== 'undefined')
	{
		return parsed;
	}
	else
	{
		return "";
	}
}
	})
	
</script>