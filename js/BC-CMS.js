/*  *******************************************************************************      WEB APP STRAP      ***************************************************************************** */
/* GLOBALS */
		var orientation = "";
		var myWidth = 0;
		var lastW = 0;
		var lastH = 0;
		var myHeight = 0;
		var pc = "";
		var URL = "";
		var POSTDATA = {};
		var METHOD = "GET";
		var imgPixel = $('<img id="pixel" style="position:fixed;top:auto;bottom:0;left:auto;right:0;" src="assets/BC-CMS/pixel.gif">');
		initFlag = false;
		init();
		
/* EVENTS */
		$(window).on("resize load",function(e){
			e.stopPropagation();
			setTimeout(function() {
				init();
			}, 20);
		});
		
		$('#modal-parent').on('touchstart mousedown','.dismiss, #mCancel, #gallery', function(e){
            e.stopPropagation();
			closeModal();
		});
	
	
		$(document).on('touchstart mousedown','.enlarge', function(e){
            e.stopPropagation();
			if($(this).hasClass('enlarge') == true){
				showModal('show', $('img', this).attr('src'), '','', '100%', '100%');
			}
		});	

		// Close (Hide) Panels use data-obj="id-name" attribute on element
		$('.close').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var tmp = $(this).attr('data-close');
			hidePanel($("#"+tmp), true );
		});			
		/* Side panels USAGE */
		/*
		<div id="wrapper" class="lr fullh auto-expand">
			<div class="panel ib">
				<div class="btn next col w2 h1">Next</div>
			</div>
			<div class="panel ib">
				<div class="btn prev col w2 h1">Previous</div>
				<div class="btn next col w2 h1">Next</div>
			</div>
			<div class="panel ib">
				<div class="btn prev col w2 h1">Previous</div>
			</div>
		</div>
		*/
		$('.next').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(window).scrollLeft();
			console.log(w);
			var target = $(this).parent().next();
			var t = target.offset().left;
			console.log(t);
			if( target.length ) {
				$('html, body').stop().animate({
					scrollLeft: t
				}, 1000);
			}
		});
		
		$('.prev').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(window).scrollLeft();
			var target = $(this).parent().next();
			var t = target.offset().left;
			if( target.length ) {
				$('html, body').stop().animate({
					scrollLeft: t
				}, 1000);
			}
		});
		
		$('.nextP').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(this).parent().width() * -1;
				$('.sp').stop().animate({
					left: w
				}, 1000);
		});
		$('.prevP').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(this).parent().width();
			w = $(this).parent().scrollLeft();
				$('.sp').stop().animate({
					left: w
				}, 1000);
		});
		/* ************************************************************** */
		/* Up Down panels USAGE */
		/*
			<div id="wrapper" class="ud fullh auto-expand">
				<div class="panel ib">
					<div class="btn down col w2 h1">Down</div>
				</div>
				<div class="panel ib">
					<div class="btn up col w2 h1">Up</div>
					<div class="btn down col w2 h1">Down</div>
				</div>
				<div class="panel ib">
					<div class="btn up col w2 h1">Up</div>
				</div>
			</div>
		*/		
		$('.down').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(window).scrollTop();
			var target = $(this).closest('.panel').next();
			var t = target.offset().top;
			if( target.length ) {
				$('html, body').stop().animate({
					scrollTop: t
				}, 1000);
			}
		});
		
		$('.up').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(window).scrollTop();
			var target = $(this).closest('.panel').prev();
			var t = target.offset().top * -1;
			t = t * -1;
			if( target.length ) {
				$('html, body').stop().animate({
					scrollTop: t
				}, 1000);
			}
		});
		
		$('.upHome').on('touchstart mousedown', function(e){
			e.stopPropagation();
			var w = $(window).scrollTop();
			w = w * -1;
				$('html, body').stop().animate({
					scrollTop: w
				}, 1000);
		});
		 /* ***************************************************** */
		
/* FUNCTIONS */
		function init(){
			/* pc? */
			if(!navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)){
				pc = true;
			}else{
				pc = false;
				$('.h_effect').css({fontSize: '1.5em', lineHeight: '1.5em'});
		
			}
			/* Determine window dimensions */
			resizeInit();
		}; // End init

		function resizeInit(){
			
	
			/* pc? */
			if(navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)/i)){
				var tmp = document.documentElement.clientHeight;
				var tmp2 = document.documentElement.clientWidth;
				if(tmp > 1024 || tmp2 > 1024){
					// iPad Pro
					switch(tmp2){
						case 1024:
							myHeight = 1366;
							myWidth = 1024;
						break;
						case 1366:
							myHeight = 1024;
							myWidth = 1366;
						break;
						default:
					}
				}else{
					//alert(tmp + '  - ' + tmp2);
					switch(tmp2){
						case 768:
							myHeight = 1024;
							myWidth = 768;
						break;
						case 1024:
							myHeight = 768;
							myWidth = 1024;
						break;
						case 768:
							myHeight = 1024;
							myWidth = 768;
						break;
						case 1024:
							myHeight = 768;
							myWidth = 1024;
						break;
						case 375:
							myHeight = 667;
							myWidth = 375;
						break;
						case 667:
							myHeight = 375;
							myWidth = 667;
						break;
						case 736:
							myHeight = 414;
							myWidth = 736;
						break;
						case 414:
							myHeight = 736;
							myWidth = 414;
						break;
						case 568:
							myHeight = 320;
							myWidth = 568;
						break;
						case 320:
							myHeight = 568;
							myWidth = 320;
						break;
						default:
						
					}
				}
				if(lastW == myWidth && parseInt(myHeight - lastH) > 100){
					
				}else{
					lastW = myWidth;
					lastH = myHeight;
					setDefaults(myWidth,myHeight)
				}
			}else{		
				 var viewportwidth;
				 var viewportheight;
				  
				 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
				  
				 if (typeof window.innerWidth != 'undefined')
				 {
					  viewportwidth = window.innerWidth,
					  viewportheight = window.innerHeight
				 }
				  
				// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
				 
				 else if (typeof document.documentElement != 'undefined'
					 && typeof document.documentElement.clientWidth !=
					 'undefined' && document.documentElement.clientWidth != 0)
				 {
					   viewportwidth = document.documentElement.clientWidth,
					   viewportheight = document.documentElement.clientHeight
				 }
				  
				 // older versions of IE
				  
				 else
				 {
					   viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
					   viewportheight = document.getElementsByTagName('body')[0].clientHeight
				 }
				myWidth = viewportwidth;
				myHeight = viewportheight;	
				setDefaults(myWidth,myHeight);
			}	
				
			/* Create row heights for split rows (class h + data-rows) */
			$('.h').each(function(){
				var x = $(this).parent().outerHeight(true);
				var y = parseInt($(this).attr('data-rows'));
				$(this).css({height: (x / y) - y + 1,overflow:'hidden'});
				$(this).children().css({minHeight:'auto',height:'100%',marginTop:'1px',marginBottom:'1px'});
			});
			if(pc === false && orientation  == 'p'){
				$('.logo').attr('src','assets/classic-car-locker4.png');
			}else{
				$('.logo').attr('src','assets/classic-car-locker-narrow4.png');
			}
			$('.late').fadeIn(750);
			} // End Resize Init

			function setDefaults(myWidth,myHeight){
				if($('#wrapper').hasClass('lr') === true && pc === true){
					myHeight = myHeight - (myHeight - $('#wrapper')[0].clientHeight);
					$('#wrapper').css({display:'inline-block !important'});
				}
				// Strip out any inline styles on the following elements
				$('body, .row, #detail').attr({style:''});	
				// Hide the modal away
				$('.modal').parent().hide();
	 
				$('body').css({width:'100%',height:myHeight});	
				$('.panel').css({width:'100%',height:myHeight,minHeight:myHeight,overflow:'auto'});

				// determine orientation
				if(myWidth/myHeight > 1 && pc === false){
					orientation = 'l';
					$('body').css({fontSize:'1.2vmin'});
					// *In development for mobile view
					if(myWidth < 1025){
					$('.m').each(function(){						
						if($(this).attr('data-width')){
							var str=$(this).attr('data-width');
							$(this).alterClass('w*', str);
						}
						if($(this).attr('data-height')){
							var str=$(this).attr('data-height');
							$(this).alterClass('h*', str);
						}
						if($(this).attr('data-font')){
							var str=$(this).attr('data-font');
							$(this).css({fontSize:str});
						}
					});				
					}else if(myWidth < 1281){
						$('.m').each(function(){
							//$(this).alterClass('w*', "w18");
						});
					}
				}else if(myWidth/myHeight < 1 && pc === false && myWidth < 769){
					orientation = 'p';
					// *In development for mobile view
					
					$('body').css({fontSize:'2vmin'});
					$('.btn').css({fontSize:'1em',padding:'1em',margin:'0em'});
					$('.m').each(function(){
						
						if($(this).attr('data-width')){
							var str=$(this).attr('data-width');
							$(this).alterClass('w*', str);
						}
						if($(this).attr('data-height')){
							var str=$(this).attr('data-height');
							$(this).alterClass('h*', str);
						}
						if($(this).attr('data-font')){
							var str=$(this).attr('data-font');
							$(this).css({fontSize:str});
						}
					});

				$('.auto-expand').each(function(){
					 var x = $(this).css('height');
					 var y = $(this).css('width');
					 $(this).css({height:x, width:y});
				});
				flexImgBoxes(); /* For image galleries see function below for usage */					
					if(myWidth < 800){
						$('.d').each(function(){
							$(this).addClass('m');
							$('body').css({fontSize:'2vmin'});
						});
					}
				}

				
			}			
			
			// Called by elements with a .dismiss class added (eg: cross icon in modal)
			function closeModal(){
			$('.modal').css({opacity:'0'});
			$('#modal').find('img:first').attr('style','');
			$('#modal').find('img:first').attr('class','');
			$('#modal').find('img:first').css({	width:'20%', maxWidth:'60px' });
			$('#modal-parent').fadeOut('slow');
			if(initFlag === true){
				initFlag = false;
				init();
			}
			}
		
		/* Function to show new panel */
		/* eg: nextPanel($('#someId')) */
		
		function showPanel(obj){
			obj = $(obj);
			obj.fadeIn();
			obj.css({width:'100%',height:myHeight,minHeight:myHeight,maxHeight:myHeight,overflow:'auto'});
			obj.removeClass('hide');
		}
		
		/* eg: hidePanel($('#someId'), bool) */
		/* if bool is false all previous panels not closed will also hide */
		function hidePanel(obj,bool){
				$.when(obj.fadeOut(500)).done(function() {
					$('body').css({overflow:'auto'});
					obj.addClass('hide');					
				});
		}
		
		function showModal(type,option1,option2,option3,h,w){
			
			/*
			type can be [ show 			| msg 					| loader 	|custom	|confirm	]
			option1 		[ path to img 	| heading 			| null			| html		|heading	]
			option2 		[ null 				| message 			| null			| target	|message]
			option3 		[ null 				| warning, info 	| null			| null			|action		]
			h 					[ height % 																					]
			w 					[ width % 																					]
			
			eg for image enlarge:
			Use on any image with class='enlarge'. eg: <img class="enlarge" src="assets/someImage.jpg"> will show modal with image at 94% 94%.
			
			To enlarge an image without the class:
			showModal('show', 'assets/image.jpg', '', '' , 'height%' , 'width%');
			
			eg: for msg dialogue
			showModal('msg', 'Heading text', 'Message text', '[warning | info]', 'height%' , 'width%');
			
			To show loader:
			
			showModal('loader', '', '', '', '100%' , '100%');
			
			*/
			$('#modal-parent').css({opacity:'100'});
			$('#modal-parent').css({left:'0px'});
			$('#modal-parent').fadeIn(1000);
			$('body').css({overflowY:'none'});
			$('#modal-parent').html('<img class="dismiss" src="assets/BC-CMS/modal/dismiss.png"><div id="modal" class="modal white txt-c"><img id="icon" src=""></div>');
			if(!h){h = 'auto'};
			if(!w){w = 'auto'};
			var ml = (100 - parseInt(w)) / 2;
			var mt = (100 - parseInt(h)) / 2;
			$('.dismiss').css({right:(ml - 2) + '%', top:(mt - 5) + '%'});
			if(type=='show'){
			if(option1 != ''){
				$('#modal').find('img:first').attr({src:option1 });
				$('#modal').find('img:first').attr('style','');
				$('#modal').find('img:first').attr('class', '');
				$('#modal').css({height:h, width:w, top:  mt + '%', left: ml + '%'});
				
				var asprtio1 = ($('#modal').find('img:first').width() / $('#modal').find('img:first').height());
				var asprtio2 = ($('#modal').width() / $('#modal').height());
				if(asprtio1 < asprtio2){
					$('#modal').find('img:first').addClass('fluid-h');
					$('#modal').find('img:first').css({width:'auto'});
				}else{
					$('#modal').find('img:first').addClass('fluid-w');
					$('#modal').find('img:first').css({height:'auto'});
				}
			}
				
			}else if (type == 'msg'){
				$('#modal').find('img:first').css({	width:'20%', maxWidth:'60px' });
				$('#modal').find('img:first').attr({src:'assets/BC-CMS/modal/' + option3 + '.svg' });
				$('#modal').append('<h1>' + option1 + '</h1><p>' + option2 + '</p>');
				var m = (100 - parseInt(h)) / 2;
				$('#modal').css({height:h, width:w, top:  mt + '%', left: ml + '%'});
				
			}else if (type == 'confirm'){
				$('#modal').find('img:first').css({	width:'20%', maxWidth:'60px' });
				$('#modal').find('img:first').attr({src:'assets/BC-CMS/modal/' + option3 + '.svg' });
				$('#modal').append('<h1>' + option1 + '</h1><p>' + option2 + '</p>');
				$('#modal').append('<button id="mOK">OK</button><button id="mCancel">Cancel</button>');
				var m = (100 - parseInt(h)) / 2;
				$('#modal').css({height:h, width:w, top:  mt + '%', left: ml + '%'});
				
			}else if (type == 'custom'){
				$('#modal').append(option1);
				var m = (100 - parseInt(h)) / 2;
				$('#modal').css({height:h, width:w});
				$('#modal').css({height:h, width:w, top:  mt + '%', left: ml + '%'});
			}else{
				$('#modal-parent').html('<div class="loader">Loading...</div>');
			}
		}		

		// Data to server php pages by POST or GET - Called and Configured in JQuery 
		function ajaxIt(output){
			var result;
					$.ajax({
					cache: false,
					type: METHOD,
					url  : URL, 
					data : POSTDATA,
					cache: false,
					timeout: 20000,
					success : function(data) {
						output(data);
					}	 
				});
		}
		
		function flexImgBoxes(){
			/* USEAGE */
			/*
			<div id="card2" class="img ib w12">
				<div id="2holder" class="holder txt-c">
					<img class="w12" src="assets/art/02_image-th.jpg" data-name="02_image">					
				</div>
				
				<h1 class="artist">Augustus John</h1>
				<h2 class="title">Study for Bacchus</h2>
				<h3 class="price">£3,900</h3>

				<div class="hide vd">
					// optional description to use in another view (hidden) eg:
					<h1 class="artist2">Augustus John</h1>

					<p class="title"><span class="fl">Study for Bacchus</span><span class="fr">OM RA (1878-1961)</span></p> 
					<br>
					<p class="desc cb">Studies of Satyrs. Iron gall ink on paper circa 1906-7. Authenticated by Rebecca John in 2005.</p>

					<p class="detail">This delightful early "John" is perfect. Although there are 8 mythical figures shown here, John's hand is so superbly confident "there are no mistakes or corrections". This is a very rare and unique piece of original "John". It's value is only going to go oneway, up.</p>

					<p class="detail">In a period gilt-gesso frame 21.25 x 17.25 inches (original 13.75 x 9.5 inches).</p>


					<p class="detail">Member's trade price  £3,900.00</p>
					<div class="row txt-c" style="">
						<span class="btn brown w2">Buy</span> <span class="btn brown w2">Swap</span> <span class="btn brown w2">Email</span>
					</div>
				</div>
			</div>			
			*/
				if(myWidth > 2000){
				var tmp = 4;
				$('.content  img').css({maxWidth:'750px'});
				$('.view-details').css({maxWidth:'750px'});		
				}else if(myWidth > 1300){			
					$('.content  img').css({maxWidth:'600px'});
					$('.view-details').css({maxWidth:'600px'});
					var tmp = 4;
				}else if(myWidth > 1000){
					var tmp = 3;
				}else{
					var tmp = 2;
				}
				var tmp2 = parseInt(24 / tmp);
				
				// Move images out
				$('.img').each(function(){	
					$(this).appendTo($('#gallery'));
				});
				
				// Remove columns
				$('.main').remove();
				
				// Redraw columns
				for(i=1;i <= tmp;i++){
					$('#gallery').append('<div id="col'+i+'" class="main col w'+tmp2+' ib"></div>');
				}

				// Populate columns			
				for(i=1;i <= tmp;i++){	
					var c = 1;
					$('.img').each(function(){	
						if((c == i && c <= tmp) || c%tmp == i || (c%tmp == 0 && i == tmp)){
							$('#card' + c).appendTo($('#col' + i));
						}
					c++;	
					});	
			}	
		}
imgPixel.appendTo('body');
// Measure its position
var myid=document.getElementById("pixel").getBoundingClientRect();
console.log(myid);
myWidth = myid.left;
myHeight = myid.bottom;
setDefaults(myWidth,myHeight);
$('#pixel').remove();		

function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}