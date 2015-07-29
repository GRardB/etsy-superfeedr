<!doctype html>
<html>
    <head>
        <title>USE OUR API</title>
    </head>
    <body>
        <div id="grid"></div>
				<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
				<script src="/isotope"></script>
				<script>
						$(function() {
								var cache = [];
								function poll($grid) {
										$.get('/poll')
										.done(function(url) {
												if (url === cache[cache.length-1]) {
														setTimeout(poll.bind(null, $grid), 0);
														return;
												}
												cache.push(url);
												var $img = $('<img>').attr('src', url);
												$img.on('load', function() {
														$grid.prepend($img).isotope('prepended', $img);
														setTimeout(poll.bind(null, $grid), 500);
												});
										});
								}

								var $grid = $('#grid');
								$grid.isotope();

								poll($grid);
						});
				</script>
    </body>
</html>
