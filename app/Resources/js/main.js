$(function () {

	//Change random beer
	$('.btn-another-beer').on('click', function(){
		$.get("/getBeer", function (data) {
	        var beerName = $('.rand-beer-name').text(data.name);
	        var beerPic = $('.rand-beer-pic > img').attr('src', data.labels.medium);
	        var beerDesc = $('.rand-beer-desc').text(data.description);
	        var breweryId = $('#brewery-id').val(data.breweries[0].id);
	        var prevRandBeerId = $('#prev-rand-beer-id').val(data.id);
	        var moreFromBrewery = $('.btn-beer-brewery').attr('href', '/brewery/' + data.breweries[0].id);
    	});
	});

	$('.card-more-beers').on('click', function(){

		console.log($(this).attr('id'));
		var id = $(this).attr('id');
		$(location).attr('href','/beer/' + id);
	});

	$('.card-search-result').on('click', function(){

		console.log($(this).attr('id'));
		var category = $(this).data('category');
		var id = $(this).data('id');
		$(location).attr('href','/' + category + '/' + id);
	});

});