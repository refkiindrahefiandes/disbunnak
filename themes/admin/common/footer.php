<script>
$(document).ready(function() {
	let baseURI = '<?=base_url()?>';
	$.ajax({
		url: baseURI + 'admin/notification/get',
		type: 'GET',
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function(json) {
			if (json['notifications'].length > 0) {
				$("a#notif-badge").append('<span class="badge brand-warning">'+  json['notifications'].length +'</span>');
                $.each(json['notifications'], function (i, item) {
                
		            str  = '<li class="media">';
		            str +=     '<div class="media-body">';
		            str +=         '<a class="media-heading" href="'+  item['url'] +'/'+ item['id']+'">';
		            str +=             '<span class="text-normal">'+ item['type'] +'</span>';
		            str +=             '<span class="media-annotation pull-right">'+ item['date_added'] + '</span>';
		            str +=         	   '<span class="text-bold"><br> a.n. '+ item['name'] +'</span>';
					str += 			   '<span><br>'+ item['isi'] +'</span>';
		            str +=         '</a>';
		            str +=     '</div>';
		            str += '</li>';

		            $("ul#notif-content").append(str);
				});
			}
		}
	});


});
</script>

</body>
</html>