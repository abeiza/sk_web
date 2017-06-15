	<script>
		function formatMonth(m){
			var monthNames = [
				"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des"
			];
			
			return monthNames[m];
		}
	</script>
	<script>
		function reply_click(click_id){
			$('#id-tanggapan').val(click_id);
			$('#box-reply-up').show();
			$("#box-reply-up").css("display","flex");
			$("#reply-pop").css("display","flex");
		}
	</script>
	<script>
		function loadReaction(){
			var url = '<?php echo $this->uri->segment(3);?>';
			 $.ajax({
				url:"<?php echo base_url();?>index.php/berita/get_reaction_post/",
				cache:false,
				data: {
				   url : url
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					$('.senang-id span').remove();
					$('.terhibur-id span').remove();
					$('.terinspirasi-id span').remove();
					$('.tidakpeduli-id span').remove();
					$('.terganggu-id span').remove();
					$('.sedih-id span').remove();
					$('.cemas-id span').remove();
					$('.marah-id span').remove();
					
					$('.senang-id').append("<span>"+result.senang+" %</span>");
					$('.terhibur-id').append("<span>"+result.terhibur+" %</span>");
					$('.terinspirasi-id').append("<span>"+result.terinspirasi+" %</span>");
					$('.tidakpeduli-id').append("<span>"+result.tidak_peduli+" %</span>");
					$('.terganggu-id').append("<span>"+result.terganggu+" %</span>");
					$('.sedih-id').append("<span>"+result.sedih+" %</span>");
					$('.cemas-id').append("<span>"+result.cemas+" %</span>");
					$('.marah-id').append("<span>"+result.marah+" %</span>");
				}
			});
		}
		
		function loadCommentPost(){
			var url = '<?php echo $this->uri->segment(3);?>';
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/get_comment_post/",
					cache:false,
					data: {
					   url : url
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						$('#comment-tree #comment-list').remove();
						$('#comment-tree').append('<div id="comment-list"></div>');
							
						$.each(result, function(i, data){
							if(data.comment_order == 1){
								if(data.guest_profile_pict == null || data.guest_profile_pict == '' || data.guest_profile_pict.substr(0,4) != 'http'){
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}else if(data.guest_profile_pict.substr(0,4) == 'http'){
								    $('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="'+data.guest_profile_pict+'"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}else{
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="../../../uploads/user/original/'+data.guest_profile_pict+'"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}
							}else{
								if(data.guest_profile_pict == null || data.guest_profile_pict == '' || data.guest_profile_pict.substr(0,4) != 'http'){
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png">'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}else if(data.guest_profile_pict.substr(0,4) == 'http'){
								    $('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="'+data.guest_profile_pict+'"/>'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}else{
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="../../../uploads/user/original/'+data.guest_profile_pict+'"/>'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}
							}
						});
					}
				});
		}
	</script>
	<script>
		$(function() {
			$(function(){
				var url = '<?php echo $this->uri->segment(3);?>';
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/get_reaction_post/",
					cache:false,
					data: {
					   url : url
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						$('.senang-id span').remove();
						$('.terhibur-id span').remove();
						$('.terinspirasi-id span').remove();
						$('.tidakpeduli-id span').remove();
						$('.terganggu-id span').remove();
						$('.sedih-id span').remove();
						$('.cemas-id span').remove();
						$('.marah-id span').remove();
						
						$('.senang-id').append("<span>"+result.senang+" %</span>");
						$('.terhibur-id').append("<span>"+result.terhibur+" %</span>");
						$('.terinspirasi-id').append("<span>"+result.terinspirasi+" %</span>");
						$('.tidakpeduli-id').append("<span>"+result.tidak_peduli+" %</span>");
						$('.terganggu-id').append("<span>"+result.terganggu+" %</span>");
						$('.sedih-id').append("<span>"+result.sedih+" %</span>");
						$('.cemas-id').append("<span>"+result.cemas+" %</span>");
						$('.marah-id').append("<span>"+result.marah+" %</span>");
					}
				}); 
			});
			setInterval(function(){loadReaction()}, 3000);
			
			$(function(){
				 var url = '<?php echo $this->uri->segment(3);?>';
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/get_comment_post/",
					cache:false,
					data: {
					   url : url
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						$('#comment-tree #comment-list').remove();
						$('#comment-tree').append('<div id="comment-list"></div>');
							
						$.each(result, function(i, data){
							if(data.comment_order == 1){
								if(data.guest_profile_pict == null || data.guest_profile_pict == '' || data.guest_profile_pict.substr(0,4) != 'http'){
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}else if(data.guest_profile_pict.substr(0,4) == 'http'){
								    $('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="'+data.guest_profile_pict+'"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}else{
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="../../../uploads/user/original/'+data.guest_profile_pict+'"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}
							}else{
								if(data.guest_profile_pict == null || data.guest_profile_pict == '' || data.guest_profile_pict.substr(0,4) != 'http'){
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png">'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}else if(data.guest_profile_pict.substr(0,4) == 'http'){
								    $('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="'+data.guest_profile_pict+'"/>'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}else{
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="../../../uploads/user/original/'+data.guest_profile_pict+'"/>'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+" "+data.comment_post_date.substr(11,5)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}
							}
						});
					
						//loadCommentPost();
					}
				}); 
			});
			setInterval(function(){loadCommentPost()}, 3000);
			
			$("#reply-close").click(function(){
				$("#box-reply-up").fadeOut();
				$("#box-reply-up").css("display","none");
				$("#login-reply").css("display","none");
			});
			
			$('#senang-box').click(function(){
				var id_post = $("#post").val();
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00001',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#terhibur-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00002',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#terinspirasi-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00003',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#tidakpeduli-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00004',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#terganggu-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00005',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#sedih-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00006',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#cemas-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00007',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#marah-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_reaction_post/",
					cache:false,
					data: {
					   reac : 'REA00008',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
					}
				});
			});
			
			$('#submit-comment').click(function(){
				var comment = $("#comment").val();
				var id_post = $("#post").val();
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_comment_post/",
					cache:false,
					data: {
					   comment : comment,
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
						
						$("#comment").val('');
					}
				});
			});
			
			$('#submit-comment-tanggapan').click(function(){
				var comment = $("#comment-tanggapan").val();
				var id_post = $("#post").val();
				var id_comment = $("#id-tanggapan").val();
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_comment_post_tanggapan/",
					cache:false,
					data: {
					   comment : comment,
					   post : id_post,
					   id_comment : id_comment
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							$("#box-pop-up").fadeIn();
							$("#box-pop-up").css("display","flex");
							$("#login-pop").css("display","flex");
						}
						
						$("#comment-tanggapan").val('');
						$('#box-reply-up').fadeOut();
					}
				});
			});
			
			$("#notif-reaction").click(function(){
				$("#notif-reaction").fadeOut();
			});
		});
		</script>
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<div id="box-reply-up" style="background-color:rgba(225,225,225,0.3);position:fixed;top:0;left:0;width:100%;height:100%;z-index:9999999;display:none;align-items:center;">
			<div id="reply-pop" style="width:500px;background-color:#fff;margin:auto;display:none;">
				<?php 
					$attibute = array("style"=>"padding:30px;width:100%");
					echo form_open("",$attibute);
				?>
					<div style="text-align:right;">
						<span id="reply-close" class="fa fa-close">Close</span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="contact-form-box">
								<div class="title-section" style="margin-top:20px;">
									<h1><span>Tanggapan Anda</span> <span class="email-not-published"></span></h1>
								</div>
								<form id="comment-form" style="margin-bottom:20px;">
									<label for="comment">Komentar*</label>
									<input type="hidden" id="id-tanggapan"/>
									<textarea id="comment-tanggapan" name="comment" class="comment"></textarea>
									<a id="submit-comment-tanggapan" class="submit-comment">
										<i class="fa fa-comment"></i> Post Comment
									</a>
								</form>
							</div>
						</div>
					</div>
				<?php echo form_close();?>
			</div>
		</div> 
		<!-- block-wrapper-section
			================================================== -->
		<div id="content-shared">
			<div class="sosmed-fixed">
				<ul>
					<li style="background:#1854dd;color:#fff;"><div style="width:100%;height:100%;margin:auto;display:flex;text-align:center;" data-href="<?php echo base_url().'index.php/berita/artikel/'.$this->uri->segment(3).'/';?>" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="facebook customer share" style="text-decoration:none;color:#fff;width:100%;display:flex;" class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fm.suarakaryanews.com%2Findex.php%2Fberita%2Fartikel%2F<?php echo rawurlencode($this->uri->segment(3));?>&amp;src=sdkpreparse"><span class="fa fa-facebook fa-2x"></span></a></div></li>
					<li style="background:#18a3dd;color:#fff;"><a style="width:100%;height:100%;text-align:center;display:flex;color:#fff;text-decoration:none;" class="twitter customer share" href="https://twitter.com/share" target="_blank"><span class="fa fa-twitter fa-2x"></span></a></li>
					<li style="background:#f14133;color:#fff;"><a style="width:100%;height:100%;text-align:center;display:flex;color:#fff;text-decoration:none;" class="google customer share" href="https://plus.google.com/share?url=<?php echo rawurlencode('http://m.suarakaryanews.com/index.php/berita/artikel/'.$this->uri->segment(3));?>" onclick="javascript:window.open(this.href,
'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span class="fa fa-google-plus fa-2x"></span></a></li>
				</ul>
			</div>
		</div>
		<section class="block-wrapper">
			<div class="container">
				<div class="row"  id="block-container">
					<div class="col-xs-7 col-sm-8 col-md-9 artikel-desc">
						<?php if($title_main != '' or $title_main != null){?>
						<!-- block content -->
						<div class="block-content">

							<!-- single-post box -->
							<div class="single-post-box">
								<div class="post-gallery">
									<!-- Vimeo -->
									<img src="<?php echo base_url();?>uploads/post/original/<?php echo $pict_main;?>" style="width:100%;padding-top:10px;" />
									<!-- End Vimeo -->
								</div>
								<div class="title-post">
									<h1><?php echo $title_main;?></h1>
									<ul class="post-tags">
										<li><i class="fa fa-clock-o"></i><?php echo date('D, d M Y H:i',strtotime($date_main));?></li>
										<li><i class="fa fa-user"></i>Editor <a href="#"><?php echo $posted_main;?></a></li>
									</ul>
								</div>
								<div class="row">
									<div class="col-md-9">
									
										<div class="article-inpost">
											<div class="row">
												<div class="col-md-12">
													<div class="text-content">
														<?php echo $desc_main;?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3" id="iklan2">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00012'){
									?>
										<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
									</div>
								</div>
								<section>
									<div class="container padding-0">
										<!-- google addsense -->
										<div class="advertisement advertisement-extends margin-bottom-0">
											<div class="desktop-advert img-full-width margin-0">
												<?php 
													foreach($query_adv->result() as $pop){
														if($pop->position_id == 'PSB00013'){
												?>
												<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
												<?php 
														}
													}
												?>
											</div>
										</div>
										<!-- End google addsense -->
									</div>
								</section>
								<div class="post-tags-box">
									<ul class="tags-box">
										<li><i class="fa fa-tags"></i><span>Tags:</span></li>
										<li><a href="<?php echo base_url().'index.php/berita/tag/'.$tag_name;?>"><?php echo $tag_name;?></a></li>
									</ul>
								</div>
								<div class="share-post-box">
								    <span>Share : </span>
									<ul class="share-box">
									<!-- Place this tag in your head or just before your close body tag. -->
										<li><div data-href="<?php echo base_url().'index.php/berita/artikel/'.$this->uri->segment(3);?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="facebook customer share" class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fm.suarakaryanews.com%2Findex.php%2Fberita%2Fartikel%2F<?php echo rawurlencode($this->uri->segment(3));?>&amp;src=sdkpreparse"><i class="fa fa-facebook"></i></a></div></li>
										<li><a class="twitter customer share" style="padding-left: 9px;padding-right: 9px;" href="https://twitter.com/share" target="_blank"><i class="fa fa-twitter"></i></a></li>
										<li><a class="google customer share" style="padding-left: 9px;padding-right: 9px;" href="https://plus.google.com/share?url=<?php echo rawurlencode('http://m.suarakaryanews.com/index.php/berita/artikel/'.$this->uri->segment(3));?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a></li>
									</ul>
								</div>

								<div class="prev-next-posts">
									<div class="prev-post" style="text-align:right;">
									<?php 
										if($before != '' or $before != null){
									?>
									
										<img src="<?php echo base_url();?>uploads/post/original/<?php echo $before_img;?>" alt="">
										<div class="post-content">
											<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $before;?>" title="prev post"><?php echo $before_title;?></a></h2>
											<ul class="post-tags">
												<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($before_date))?></li>
											</ul>
										</div>
					
									<?php 
										}
									?>
									</div>
									<div class="next-post">
									<?php
										if($after != '' or $after != null){
									?>
										<img src="<?php echo base_url();?>uploads/post/original/<?php echo $after_img;?>" alt="">
										<div class="post-content">
											<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $after;?>" title="next post"><?php echo $after_title;?></a></h2>
											<ul class="post-tags">
												<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($after_date))?></li>
											</ul>
										</div>
									<?php
										}
									?>
									</div>
								</div>
								<div class="carousel-box owl-wrapper" style="float:left;">
									<div class="title-section margin-top-0">
										<h1><span>Bagaimana reaksi Anda tentang artikel ini?</span></h1>
									</div>
									<div style="width:100%;">
										<div class="reaction-box" id="senang-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/senang.png"/>
											<div class="desc">
												<h5>Senang</h5>
												<p class="senang-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="terhibur-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/terhibur.png"/>
											<div class="desc">
												<h5>Terhibur</h5>
												<p class="terhibur-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="terinspirasi-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/terinspirasi.png"/>
											<div class="desc">
												<h5>Terinspirasi</h5>
												<p class="terinspirasi-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="tidakpeduli-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/tidak_peduli.png"/>
											<div class="desc">
												<h5>Tidak Peduli</h5>
												<p class="tidakpeduli-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="terganggu-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/terganggu.png"/>
											<div class="desc">
												<h5>Terganggu</h5>
												<p class="terganggu-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="sedih-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/sedih.png"/>
											<div class="desc">
												<h5>Sedih</h5>
												<p class="sedih-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="cemas-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/cemas.png"/>
											<div class="desc">
												<h5>Cemas</h5>
												<p class="cemas-id"><span>0 %</span></p>
											</div>
										</div>
										<div class="reaction-box" id="marah-box">
											<img class="icon" src="<?php echo base_url();?>assets/img/fwdemojisuarakaryanews/marah.png"/>
											<div class="desc">
												<h5>Marah</h5>
												<p class="marah-id"><span>0 %</span></p>
											</div>
										</div>
									</div>
									<div id="notif-reaction"><span></span></div>
									<input type="hidden" id="post" value="<?php echo $id_post;?>"/>
								</div>
								<section style="float:left;">
									<div class="container padding-0">
										<!-- google addsense -->
										<div class="advertisement advertisement-extends margin-bottom-0">
											<div class="desktop-advert img-full-width margin-0">
												<?php 
													foreach($query_adv->result() as $pop){
														if($pop->position_id == 'PSB00014'){
												?>
												<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
												<?php 
														}
													}
												?>
											</div>
										</div>
										<!-- End google addsense -->
									</div>
								</section>
								<!-- carousel box -->
								<div class="carousel-box owl-wrapper">
									<div class="title-section">
										<h1><span class="padding-top-20">Berita Terkait</span></h1>
									</div>
									<div class="owl-carousel" data-num="4">
										<?php 
											foreach($get_other->result() as $hdl){
										?>
										<div class="item news-post image-post3">
											<div class="img-owl-carousel background-img-headline" style="background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $hdl->post_thumb;?>');"></div>
											<div class="hover-box">
												<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $hdl->post_url;?>"><?php echo $hdl->post_title;?></a></h2>
											</div>
										</div>
										<?php 
											}
										?>
									</div>
								</div>
								<!-- End carousel box -->

								<!-- contact form box -->
								<div class="contact-form-box">
									<div class="title-section" style="margin-top:20px;">
										<h1><span>Komentar</span> <span class="email-not-published"></span></h1>
									</div>
									<form id="comment-form" style="margin-bottom:20px;">
										<textarea id="comment" name="comment" class="comment"></textarea>
										<a id="submit-comment" class="submit-comment">
											<i class="fa fa-comment"></i> Post Comment
										</a>
									</form>
								</div>
								<!-- End contact form box -->
								
								<!-- comment area box -->
								<div class="comment-area-box">
									<div class="title-section">
										<h1><span><?php echo $get_comment_count->num_rows?> Komentar</span></h1>
									</div>
									<ul class="comment-tree" id="comment-tree">
										<div id="comment-list"></div>
									</ul>
								</div>
								<!-- End comment area box -->


							</div>
							<!-- End single-post box -->

						</div>
						<!-- End block content -->
						<?php }else{
						?>
						<div class="block-content" style="height: 350px;align-items: center;display: flex;">
							<span style="margin:auto">This Post not Found !</span>
						</div>
						<?php
						}?>
					</div>

					<div class="col-xs-5 col-sm-4 col-md-3 side-right">

						<!-- sidebar -->
						<div class="sidebar">

							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00008'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>

							<div class="widget tab-posts-widget widget-popular">

								<ul class="nav nav-tabs" id="myTab">
									<li class="active">
										<a href="#option1" data-toggle="tab" style="font-size:12px;">Most Popular</a>
									</li>
									<li>
										<a href="#option2" data-toggle="tab" style="font-size:12px;">Most Commented</a>
									</li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active" id="option1">
										<ul class="list-posts">
											<?php 
												foreach($get_popular->result() as $pop){
											?>
											<li>
												<div class="post-content">
													<h2><a href="<?php echo base_url();?>index.php/berita/artikel/<?php echo $pop->post_url;?>"><?php echo $pop->post_title;?></a></h2>
													<ul class="post-tags">
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i', strtotime($pop->post_modify_date));?></li>
													</ul>
												</div>
											</li>
											<?php 
												}
											?>
										</ul>
									</div>
									<div class="tab-pane" id="option2">
										<ul class="list-posts">
											<?php 
												foreach($get_commended->result() as $com){
											?>
											<li>
												<div class="post-content">
													<h2><a href="<?php echo base_url();?>index.php/berita/artikel/<?php echo $com->post_url;?>"><?php echo $com->post_title;?></a></h2>
													<ul class="post-tags">
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i', strtotime($com->post_modify_date));?></li>
													</ul>
												</div>
											</li>
											<?php 
												}
											?>
										</ul>										
									</div>
								</div>
							</div>
							
							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00009'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>

							<div class="widget post-widget widget-popular">
								<div class="title-section margin-top-0 title-video">
									<h1><span class="world blue-title">Video</span></h1>
								</div>
								<?php
								    if($get_video->num_rows() == 0){
								        
								    }else{
								        foreach($get_video->result() as $vd){
								?>
								<div class="news-post video-post" style="margin-bottom:5px;">
									<iframe width="100%" height="250px" src="<?php echo $vd->video_link;?>" frameborder="0" allowfullscreen></iframe>
									<a href="<?php echo $vd->video_link;?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
									<div class="hover-box">
										<h2><a href="<?php echo base_url().'index.php/berita/video_detail/'.$vd->video_url;?>"><?php echo $vd->video_title;?></a></h2>
										<ul class="post-tags">
											<li><i class="fa fa-clock-o"></i><?php echo date('d M Y, H:i',strtotime($vd->video_modify_date));?></li>
										</ul>
									</div>
								</div>
								<?php 
								        }
								    }
								?>
							</div>
							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00010'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>
							
							<div class="widget recent-comments-widget widget-popular" id="sorot-berita">
								<div class="title-section margin-top-0 title-video">
									<h1><span class="world blue-title">Sorot Berita</span></h1>
								</div>
								<div class="news-post image-post2 background-white">
									<div class="news-post article-post" data-num="1">
											<?php 
												$s = 1;
												foreach($get_sorot->result() as $sor){
											?>
											<div class="row">
												<div class="col-xs-3 col-sm-3 col-md-3">
													<div class="padding-left-40p">
														<div class="numb-sorot"><?php echo $s++;?></div>
													</div>
												</div>
												<div class="col-xs-9 col-sm-9 col-md-9 padding-left-0" style="margin-top:12px;">
													<div>
														<p class="desc-sorot">
															<a class="hover" href="<?php echo base_url();?>index.php/berita/tag/<?php echo $sor->tag_name; ?>"><?php echo $sor->tag_name;?></a>
														</p>
													</div>
												</div>
											</div>
											<?php 
												}
											?>
									</div>
								</div>
							</div>
						
						</div>
						<!-- End sidebar -->

					</div>

				</div>

			</div>
		</section>
		<!-- End block-wrapper-section -->
		<!--<script>
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.8";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>-->
		<div id="fb-root"></div>
        <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.9&appId=298525293919660";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
		<!-- Place this tag where you want the share button to render. -->
		<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		<script>
			;(function($){
  
  /**
   * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
   *
   * @param  {[object]} e           [Mouse event]
   * @param  {[integer]} intWidth   [Popup width defalut 500]
   * @param  {[integer]} intHeight  [Popup height defalut 400]
   * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
   */
  $.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {
    
    // Prevent default anchor event
    e.preventDefault();
    
    // Set values for window
    intWidth = intWidth || '500';
    intHeight = intHeight || '400';
    strResize = (blnResize ? 'yes' : 'no');

    // Set title and open popup with focus on it
    var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
        strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,            
        objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
  }
  
  /* ================================================== */
  
  $(document).ready(function ($) {
    $('.customer.share').on("click", function(e) {
      $(this).customerPopup(e);
    });
  });
    
}(jQuery));
		</script>