
/* #One-page
================================================== */

// jQuery(document).ready(function($) {
	var $moveBody = $("html, body");
	var phantomStickyExists = $(".phantom-sticky").exists(),
		sideHeaderHStrokeExists = $(".sticky-top-line").exists(),
		stickyMobileHeader = $(".sticky-mobile-header").exists(),
		floatMenuH = 0;

	/*Detect floating header*/
	if(phantomStickyExists || sideHeaderHStrokeExists){
		var $phantom = $(".masthead"),
			$phantomVisibility = 1;
	}else{
		var $phantom = $("#phantom"),
			$phantomVisibility = $phantom.css("display")=="block";
	}


	// One page scrolling effect
	
	if ($(".mobile-header-bar").css('display') !== 'none') {
		var $headerBar = $(".mobile-header-bar");
		if($(".sticky-top-line").exists()){
			var $headerBar = $(".sticky-top-line.masthead-mobile-header .mobile-header-bar");
		}
		if($(".phantom-sticky").length > 0 || $(".sticky-top-line").exists()){
			if($(".sticky-header .masthead.side-header").length > 0 || $(".overlay-navigation .masthead.side-header").length > 0){
				var $phantom = $(".mobile-header-bar").parent(".masthead:not(.side-header)");
			}else{
				var $phantom = $(".mobile-header-bar").parent();
			}
		}
	}else{
		var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar");
	}

	/*Floating header height*/
	function set_sticky_header_height() {
		if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
			if(stickyMobileHeader){
				floatMenuH = $phantom.height();
			}else{
				floatMenuH = 0;
			}
		}else{
			if($phantom.css("display")=="block" || phantomStickyExists){			
				floatMenuH = $phantom.height();
			}else if(sideHeaderHStrokeExists){
				floatMenuH = $(".sticky-top-line").height();
			}else{
				floatMenuH = 0;
			}
		}
	}
	set_sticky_header_height();



	/*Set cuurent item on load*/
	addOnloadEvent(function(){
		var locHash = window.location.hash;
		if(locHash.match("^#!")){
			var urlHash = locHash.substring(3);
		}
		setTimeout(function(){
			if( typeof urlHash != 'undefined' && urlHash.length > 0 ) {
				if(urlHash == "up") {
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: 0
					}, 600, 'swing',
					function() { 
						$.closeSideHeader();
					});

				}else{
					setTimeout(function(){
						$moveBody.stop().animate({
							scrollTop: $("#" + urlHash).offset().top - floatMenuH
						}, 600, 'swing',
						function() { 

							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$moveBody.stop().animate({
											scrollTop: $("#" + urlHash).offset().top - $(".masthead-mobile-header .mobile-header-bar").height()
											}, 650, 'swing');
									}else{
										$moveBody.stop().animate({
											scrollTop: $("#" + urlHash).offset().top - $($headerBar, $phantom).height()
											}, 650, 'swing');
									}

								}
							}else{
								if(phantomStickyExists ||  sideHeaderHStrokeExists){
									
								
									$moveBody.stop().animate({
										scrollTop: $("#" + urlHash).offset().top - $($headerBar, $phantom).height()
									}, 650, 'swing');

								}
							}
							//}
						});
					},300)
				}
				$('.menu-item a').parent("li").removeClass('act');
				$('.menu-item a[href="'+locHash+'"]').parent("li").addClass('act');
				//if($('.menu-item a').attr('href').match(locHash)){
					$('.menu-item a[href*="'+locHash+'"]').parent("li").addClass('act');
				//}
			}else {
				if(typeof urlHash == 'undefined' && $( '.menu-item > a[href="#!/up"]' ).length > 0) {
					$( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
				}
			}
		},300);
	 })

	jQuery( window ).on('resize', function() {
		set_sticky_header_height();
	});

	
	var $menus = $( '.menu-item > a[href*="#!"]' );


	/*!-scroll to anchor*/
	window.clickAnchorLink = function( $a, e ) {
		var url = $a.attr( 'href' ),
			hash = url,
			$target = url.substring(3),
			base_speed  = 600,
			speed       = base_speed;
		if(url.match("^#!")){
			var $target = url.substring(3);
		}else{
			var $target = (url.substring(url.indexOf('#'))).substring(3);
		}
		
		set_sticky_header_height();

		if ( typeof $target != 'undefined' && $target && $target.length > 0 ) {
			location.hash = url;
			if($("#" + $target).length > 0) {
				var top = $("#" + $target).offset().top + 1,
					this_offset = $a.offset(),
					that_offset = $("#" + $target).offset(),
					offset_diff = Math.abs(that_offset.top - this_offset.top),
					speed = 150 * Math.log(offset_diff^2/1000 + 1.02);
					$newScrollPosition = top - floatMenuH;
			};
			if($target == "up") {
				if($body.hasClass("overlay-navigation")){
					$.closeMobileHeader();
					$.closeSideHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing');
				}else{
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: 0
					}, speed, 'swing',
					function() { $.closeSideHeader(); }
					);
				}
			}else {
				if($body.hasClass("overlay-navigation")){
					$.closeMobileHeader();
					$.closeSideHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing',
						function() { 
							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$newScrollPosition = ( top - $(".masthead-mobile-header .mobile-header-bar").height() )
									}else{
										$newScrollPosition = ( top - $($headerBar, $phantom).height() );
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');

								}
							}else{
								if(sideHeaderHStrokeExists){
									$newScrollPosition = ( top - $(".sticky-top-line").height() )

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								
								}
							}
						
					});
				}else{
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing',
						function() { 

							$.closeSideHeader();

							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$newScrollPosition = ( top - $(".masthead-mobile-header .mobile-header-bar").height() )
									}else if(topLineDocked){
										$newScrollPosition = ( top - $(".sticky-top-line").height() )
									}else{
										$newScrollPosition = ( top - $($headerBar, $phantom).height() );
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								}
							}else{
								if(phantomStickyExists ||  sideHeaderHStrokeExists){
									if(headerDocked){
										$newScrollPosition = ( top - $(".header-bar").height() );
									}else{
										$newScrollPosition = ( top - $(".sticky-top-line").height() )
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								
								}
							}

						
						//}
					});
				}
			};

			$('.menu-item a').parent("li").removeClass('act');
			$a.parent("li").addClass('act');
		};

	};

	$body.on( 'click', '.anchor-link[href^="#!"], .anchor-link a[href^="#!"], .logo-box a[href^="#!"], .branding a[href^="#!"], #branding-bottom a[href^="#!"]', function( e ) {
		clickAnchorLink( $( this ), e );
		e.preventDefault();
		return false;
	});

	$menus.on( 'click', function( e ) {
		clickAnchorLink( $( this ), e );
		if($(this).attr('href').match("^#!")){
			e.preventDefault();
			return false;
		}
	});

	/*!-set active menu item on scroll*/
	if(($('.one-page-row div[data-anchor^="#"]').length > 0 || $('.vc_row[id]').length > 0) && $(".one-page-row").length > 0){
		$window.scroll(function (e) {
			var currentNode = null;
			if(!$body.hasClass("is-scroll")){
				var currentNode;
				//for vc row id
				$('.one-page-row .vc_row[id], .one-page-row div[data-anchor^="#"]').each(function(){
					var $_this = $(this),
						activeSection = $_this,
						currentId = $_this.attr('id');
					if(isMoved){
						if(dtGlobals.winScrollTop >= ($(".one-page-row div[id='" + currentId + "']").offset().top - $($phantom).height())){
							currentNode = "#!/" + currentId;
						};
					}else{
						if(dtGlobals.winScrollTop >= ($(".one-page-row div[id='" + currentId + "']").offset().top - $($headerBar).height())){
							currentNode = "#!/" + currentId;
						};
					}
				});
				
				$('.menu-item a[href^="#!"]').parent("li").removeClass('act');
				$('.menu-item a[href="'+currentNode+'"]').parent("li").addClass('act');

				if($(".one-page-row div[data-anchor^='#']").length > 0){
					if(isMoved){
						if(dtGlobals.winScrollTop < ($(".one-page-row div[data-anchor^='#']").first().offset().top - $($phantom).height())&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
							$( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
						}
					}else{
						if(dtGlobals.winScrollTop < ($(".one-page-row div[data-anchor^='#']").first().offset().top - $($headerBar).height())&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
							$( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
						}
					}
					
				}else if( $('.vc_row[id]').length > 0){
					//for vc row id
					if(isMoved){
						if(dtGlobals.winScrollTop < ($('.one-page-row .vc_row[id]').first().offset().top - $($phantom).height())&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
							$( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
						};
					}else{
						if(dtGlobals.winScrollTop < ($('.one-page-row .vc_row[id]').first().offset().top - $($headerBar).height())&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
						$( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
					};
					}
				}
				if($('.menu-item a[href="#"]').length && currentNode == null){
					$('.menu-item a[href="#"]').parent("li").addClass('act');
				}
			};
		});
	};
// })