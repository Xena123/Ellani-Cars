/*
GreenDot 0.01b
*/

/* Remove front edit */
$('body').on("click",function(){
		if ( $('#front-edit') ) { $('#front-edit').remove(); }
	});

    $('.post-edit-link').parent().each( function(){
        $this = $(this);
        if ( $this.css("position") != "absolute" ) {
            $this.css("position","relative");
        }
    });


	$('.post-edit-link').on('click',function() {
		var link= $(this).attr("href");
		$('body').append("<iframe id=\"front-edit\" src="+ link +"></iframe>");
		var frontEdit = $('#front-edit');

		frontEdit.css({
			'position'  : 'fixed',
			'display'	: 'none',
			'top'		: '10%',
			'left'		: '10%',
			'width'		: '80%',
			'height'	: '80%',
			'z-index' 	: '10000'
		});

		frontEdit.focus();

		frontEdit.on("load",function(){
				frontEdit.on("blur",function() {
					frontEdit.remove();
					location.reload();
				});

				frontEdit.on("load",function() {	 $(this).remove();location.reload();	});

				function hideIt(){							
					var bar = frontEdit.contents().find("body");

					if ( bar.css("display") !== "block" ) {

						console.log("Run");
						setTimeout(hideIt , 100);								
					}

					else {

						frontEdit.contents().find("head").append("<style>#adminmenuback{display:none}#wpadminbar {display:none} #adminmenuwrap {display:none;} #wpcontent {margin-left:0;}</style>");
						frontEdit.css("display","block");
					}

				}

			hideIt();

		});


		return false;

	});
/*\GREEN DOT */