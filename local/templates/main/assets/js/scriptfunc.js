/*(function () {
    var $container = $(document.getElementById('one_string'));
    var $address = $container.find('[name="address"]');
    $address.fias({
        type: $.fias.type.city,
    });
}
)();*/

function ans (a) {
      var namecity = $(a).attr('name');
      $('.select2-search__field').text(namecity)

      }

 window.onload = function () {

	//sessionStorage.removeItem('city');

	if(!sessionStorage.getItem('city'))
			{
				ymaps.ready(init);
					function init() {
						sessionStorage.setItem('city',ymaps.geolocation.city);
						sessionStorage.setItem('region',ymaps.geolocation.region);
						//alert(ymaps.geolocation.city);
					}


			}
			var r = sessionStorage.getItem('city');
			jQuery(".user-region").text(r);
			//jQuery("#user-regionr").text(r);
		 //jQuery("#SDEK_cityName").text(r);
		 //alert(r);
		 //IPOLSDEK_pvz.city = 'Москва';
	  }

function region () {

	var all =$('.cabinet-address-input-city option:selected').val();
	var city = all.split(',')[0];
	var region = all.substring(all.indexOf(',') + 1);

		sessionStorage.setItem('city',city);
		sessionStorage.setItem('region',region);
		var r = sessionStorage.getItem('city');
		jQuery(".user-region").text(r);
		getRegionDev();
		//jQuery("#user-regionr").text(r);
      }






