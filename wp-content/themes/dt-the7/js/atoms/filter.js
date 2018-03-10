
/* #Filter
================================================== */
// jQuery(document).ready(function($) {

	/*!-categories filter*/
	$(".filter-categories").each(function() {
		var $self = $(this);
		
		$self.find("> a").on("click", function(e) {
			var $this = $(this);

			if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
				var $filter = $this.parents(".filter").first();

				if ( $filter.hasClass("without-isotope") ) {
					arguments.callee.dtPreventD = $filter.hasClass("with-ajax") ? true: false;
				} else {
					arguments.callee.dtPreventD = true;
				};
			};

			e.preventDefault();

			$this.trigger("mouseleave");

			if ($this.hasClass("act") && !$this.hasClass("show-all")) {
				e.stopImmediatePropagation();
				$this.removeClass("act");
				$this.siblings("a.show-all").trigger("click");//.addClass("act");
			} else {
				$this.siblings().removeClass("act");
				$this.addClass("act");

				if ( !arguments.callee.dtPreventD ) {
					window.location.href = $this.attr("href");
				}
			};
		});
	});

	/*!- ordering*/
	$(".filter-extras .filter-switch").each(function(){
		var $_this = $(this);
		if($_this.prev('.act').length > 0){
			$_this.addClass('left-act');
		}else if($_this.next('.act').length > 0){
			$_this.addClass('right-act');
		}else{
			$_this.removeClass('right-act');
			$_this.removeClass('left-act');
		};
	});

	$(".filter-extras").each(function(){
		$(this).find('a').on("click", function(e) {
			var $this = $(this);

			if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
				var $filter = $this.parents(".filter").first();

				if ( $filter.hasClass("without-isotope") ) {
					arguments.callee.dtPreventD = $filter.hasClass("with-ajax") ? true: false;
				} else {
					arguments.callee.dtPreventD = true;
				}
			};

			if ( arguments.callee.dtPreventD ) {
				e.preventDefault();
			};

			$this.siblings().removeClass("act");
			$this.addClass("act");

			$(".filter-extras .filter-switch").each(function(){
				var $_this = $(this);
				if($_this.prev($this).hasClass('act')){
					$_this.addClass('left-act');
					$_this.removeClass('right-act');
				}else if($_this.next($this).hasClass('act')){
					$_this.addClass('right-act');
					$_this.removeClass('left-act');
				}else{
					$_this.removeClass('right-act');
					$_this.removeClass('left-act');
				};
			});
		});
	});

	$(".filter-extras .filter-switch").each(function(){
		var $this = $(this);
		var $filter = $this.parents(".filter").first();
		$this.on("click", function(){
			if ( $filter.hasClass("without-isotope") ) {
				if($this.hasClass("right-act")){
					$this.prev("a")[0].click();
				}else if ($this.hasClass("left-act")){
					
					$this.next("a")[0].click();
				};
			}else{
				if($this.hasClass("right-act")){
					$this.prev("a").trigger("click");
				}else if ($this.hasClass("left-act")){
					$this.next("a").trigger("click");
				};
			};
		});
	});



	//List filter
	$(".mode-list .filter-categories > a:not(.show-all), .dt-css-grid-wrap .filter-categories > a:not(.show-all)").each(function(){
		$this = $(this),
		$dataFiltr = $this.attr("data-filter");
		$newDataFilter = $dataFiltr.substring(1, $dataFiltr.length);
		$this.attr("data-filter", $newDataFilter);
		$this.parents().removeClass('iso-filter');
	})
	$.fn.shortcodesFilter = function() {
		var $el = $(this);
		if($el.hasClass("dt-css-grid")){
			var $elFilter = $el.parent().find(".filter-categories"),
				$elPaginator = $el.parent().find(".paginator"),
				$elSort = $el.parent().find(".filter-by"),
				$elOrder = $el.parent().find(".filter-sorting"),
				$elDefaultSort = $el.parent().find(".filter-by .act").attr('data-by'),
				$elDefaultOrder = $el.parent().find(".filter-sorting .act").attr('data-sort'),
				$paginationMode = $el.parent().attr("data-pagination-mode"),
				$postLimit = $el.parent().attr("data-post-limit");
		}else{
			var $elFilter = $el.find(".filter-categories"),
				$elPaginator = $el.find(".paginator"),
				$elSort = $el.find(".filter-by"),
				$elOrder = $el.find(".filter-sorting"),
				$elDefaultSort = $el.find(".filter-by .act").attr('data-by'),
				$elDefaultOrder = $el.find(".filter-sorting .act").attr('data-sort'),
				$paginationMode = $el.attr("data-pagination-mode"),
				$postLimit = $el.attr("data-post-limit");
		}

		$el.Filterade({
			// Pagination
			pageLimit: $postLimit,
			 paginationMode: $paginationMode,
			// Filters
			useFilters: true, 
			useSorting: true,
			filterControls: $elFilter,
			sortControls: $elSort,
			orderControls: $elOrder,
			pageControls: $elPaginator,
			controlsSelecter: 'a',
			controlsSelecterChecked: 'a.act',
			defaultFilter: '*',
			selectAll: '*',
			defaultSort: $elDefaultSort,
			defaultOrder: $elDefaultOrder,
            loadMoreButtonLabel: dtLocal.moreButtonText.loadMore
		});
		$el.on('updateReady', function(){
			loadingEffects();
			if($el.parent().hasClass("content-rollover-layout-list") && ! $el.parent().hasClass("disable-layout-hover")){
				$el.find(".post-entry-wrapper").each(function(){
					var $this = $(this),
						$thisOfTop = $this.find(".entry-excerpt").height() + $this.find(".post-details").innerHeight();
					$this.stop().velocity({
						translateY : $thisOfTop
					}, 0);
					$this.parents(".post").first().on("mouseenter", function(e) {
						$this.stop().velocity({
							translateY : 0
						}, 0);
					});
					$this.parents(".post").first().on("mouseleave", function(e) {
						$this.stop().velocity({
							translateY : $thisOfTop
						}, 0);
					});
				})
			}
		})
		function lazyLoading() {
			if($el.hasClass("dt-css-grid")){
				if($el.parent().hasClass("lazy-loading-mode")){
					var buttonOffset = $el.find('.button-load-more').offset();
					if ( buttonOffset && $window.scrollTop() > (buttonOffset.top - $window.height()) / 2){
						$el.find('.button-load-more').trigger('click');
					
					}
					
				}
			}else{
				if($el.hasClass("lazy-loading-mode")){
					var buttonOffset = $el.find('.button-load-more').offset();
					if ( buttonOffset && $window.scrollTop() > (buttonOffset.top - $window.height()) / 2){
						$el.find('.button-load-more').trigger('click');
					
					}
					
				}
			}
		}
		$window.on('scroll', function () {
			lazyLoading();
		});
		lazyLoading();

	}

	$('.blog-shortcode.mode-list.jquery-filter, .jquery-filter .dt-css-grid').each(function(){
		var $this = $(this);
		$this.shortcodesFilter();
	});

// });