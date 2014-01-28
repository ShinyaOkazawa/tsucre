$(function(){
	setModal();

	$('.i_wrapper').find('img').hover(function(){
		$(this).attr('src', $(this).attr('src').replace('_off', '_on'));
	}, function(){
		$(this).attr('src', $(this).attr('src').replace('_on', '_off'));
	});

	/* index.php */

	// votes-button animation
	$('.votes-button').hover(function(){
		$(this).next().css({
			'width':'60px',
			'height':'60px',
			'margin-top':'-30px',
			'margin-left':'-30px',
		});
	}, function(){
		$(this).next().css({
			'width':'',
			'height':'',
			'margin-top':'',
			'margin-left':'',
		});
	});

	// #first-ovl
	$('#first .submenu-toggle').click(function(){
		
		if($('#first-ovl').css('display') == 'block'){
			$('#first .submenu-toggle').css({'background':''});
			$('#first .submenu-bars').css({'background':''});	
		} else {
			$('#first .submenu-toggle').css({'background':'#fff'});
			$('#first .submenu-bars').css({'background':'#2f2f2f'});	
		}
		$('#first-ovl').fadeToggle();
		
	});

	$('#first .submenu-toggle').hover(function(){
		$(this).css({'background':'#fff'});
		$('#first .submenu-bars').css({'background':'#2f2f2f'});
	},function(){
		if($('#first-ovl').css('display') == 'block' ){

		} else {
			$(this).css({'background':''});
			$('#first .submenu-bars').css({'background':''});	
		}
		
	});

	$('#first').mouseleave(function(){
		$('#first .submenu-toggle').css({'background':''});
		$('#first .submenu-bars').css({'background':''});	
		$('#first-ovl').fadeOut();
	});

	// nth-ovl
	$('.nth-rank .submenu-toggle, .work .submenu-toggle').click(function(){
		
		if($('.nth-ovl,.work-nth-ovl').css('display') == 'block'){
			$(this).css({'background':''});
			$(this).find('.submenu-bars').css({'background':''});	
		} else {
			$(this).css({'background':'#fff'});
			$(this).find('.submenu-bars').css({'background':'#2f2f2f'});	
		}
		$(this).closest('.nth-rank, .work').find('.nth-ovl, .work-nth-ovl').fadeToggle();
		
	});

	$('.nth-rank .submenu-toggle, .work .submenu-toggle').hover(function(){
		$(this).css({'background':'#fff'});
		$(this).find('.submenu-bars').css({'background':'#2f2f2f'});
	},function(){
		if($('.nth-ovl,.work-nth-ovl').css('display') == 'block' ){

		} else {
			//$(this).css({'background':''});
			//$('.nth-rank .submenu-bars').css({'background':''});	
		}
		
	});

	$('.nth-rank, .work').mouseleave(function(){
		$('.nth-rank .submenu-toggle, .work .submenu-toggle').css({'background':''});
		$('.nth-rank .submenu-bars, .work .submenu-bars').css({'background':''});	
		$('.nth-ovl,.work-nth-ovl').fadeOut();
	});

	// ranking-date animation
	$('#left-arrow').hover(function(){
		$(this).stop().animate({
			'left':'-5px'
		});	
	},function(){
		$(this).stop().animate({
			'left':'0'
		});	
	});
	$('#right-arrow').hover(function(){
		$(this).stop().animate({
			'right':'-5px'
		});	
	},function(){
		$(this).stop().animate({
			'right':'0'
		});	
	});

	// rank-pic overlay sns replace image
	$('.ovl-sns-wrapper').find('img').hover(function(){
		$(this).attr('src', $(this).attr('src').replace('_off', '_on'));
	}, function(){
		$(this).attr('src', $(this).attr('src').replace('_on', '_off'));
	});

	// double-arrow animation
	$('.double-arrow-left').hover(function(){
		$(this).stop().animate({
			'left':'-5px'
		});	
	},function(){
		$(this).stop().animate({
			'left':'0'
		});	
	});
	$('.double-arrow-right').hover(function(){
		$(this).stop().animate({
			'right':'-5px'
		});	
	},function(){
		$(this).stop().animate({
			'right':'0'
		});	
	});
});

function setModal(){
	// html読み込み時にモーダルウィンドウの位置をセンターに調整
	adjustCenter("#modal .container");

	// ウィンドウリサイズ時にモーダルウィンドウの位置をセンターに調整
	$(window).resize(function(){
		adjustCenter("#modal .container");
	});

	// 背景がクリックされた時にモーダルウィンドウを閉じる
	$("#modal .background").click(function(){
		displayModal(false);
	});

	// リンクがクリックされた時にajaxでコンテンツを読み込む
	$(".modal").click(function(){
		$("#modal .container").load($(this).attr("href"), data="html", onComplete);
		return false;
	});

	// コンテンツの読み込み完了時にモーダルウィンドウを開く
	function onComplete(){
		displayModal(true);
		$("#modal .container .close").click(function(){
			displayModal(false);
			return false;
		});
	}
}

// モーダル表示・非表示のアクション
function displayModal(sign){
	if(sign){
		$("#modal").fadeIn(500);
	} else {
		$("#modal").fadeOut(250);
	}
}

// センター調整
function adjustCenter(target){
	var margin_top = ($(window).height()-$(target).height())/2;
	var margin_left = ($(window).width()-$(target).width())/2;
	$(target).css({top:margin_top+"px",left:margin_left+"px"});
}