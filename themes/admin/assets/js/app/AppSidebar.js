(function() {
    "use strict";

    $(document).ready(function() {
	    // Menubar
	    $('.sidebar-main-toggle').on('click', function() {
	        if ($('body').is('.menubar-collapsed')) {
	            $('body').removeClass('menubar-collapsed');
	            $('.side-menu li.active ul').slideDown();
	        } else {
	            $('body').addClass('menubar-collapsed');
	            $('.side-menu li ul').slideUp();
	        }
	    });

	    // On hover
	    $('#main-sidebar').hover(function() {
	        if ($('body').is('.menubar-collapsed')) {
	            $('body').addClass('menubar-visible');
	            $('.side-menu li.active ul').slideDown();
	        }
	    }, function() {
	        if ($('body').is('.menubar-collapsed')) {
	            $('body').removeClass('menubar-visible');
	            $('.side-menu li ul').slideUp();
	        }
	    });

	    $('.side-menu li ul').slideUp();
	    $('.side-menu li').removeClass('active');
	    $('.side-menu li').on('click', function() {
	        var link = $('a', this).attr('href');
	        if (link) {
	            window.location.href = link;
	        } else {
	            if ($(this).is('.active')) {
	                $(this).removeClass('active');
	                $('ul', this).slideUp();
	            } else {
	                // $('.side-menu li').removeClass('active');
	                $('.side-menu li ul').slideUp();
	                // $(this).addClass('active');
	                $('ul', this).slideDown();
	            }
	        }
	    });

	    var url = window.location.href;
	 //    var split = url.split('/');

	 //    var path = split.length;

		// var pgurl = split.lastIndexOf(",");

	 //    // var path = window.location.href.split('/')[5] + '/' + window.location.href.split('/')[6] + '/' + window.location.href.split('/')[7];

	 //    // var menuActive = $('.side-menu a[href="' + path + '"]');


	 //    // if (menuActive === '') {
	 //    // 	alert('tes');
	 //    // }

	 //    console.log(pgurl);



	    $('.side-menu a[href="' + url + '"]').parent('li').addClass('active current-page');
	    $('.side-menu a').filter(function() {
	        return this.href == url;
	    }).parent('li').addClass('current-page').parent('ul').slideDown().parent().addClass('active');
    });

}).call(this);