var ordersApp;

function initOrdersApp(el, orders) {
	ordersApp = new Vue({
		el: el,
		data: {
			orders: orders,
			// selectedFilter: "history",
			selectedFilter: "current",

			filterProductName: "",
			filterOrderId: "",
			filterDateBegin: "",
			filterDateEnd: "",
		},

		methods: {
			selectFilter: function (btn) {
				var self = this;
				this.selectedFilter = btn;

				if (btn === "history") {
					setTimeout(function () {
						$.datepicker.setDefaults($.datepicker.regional["ru"]);
						$(".jqui-datepicker")
							.datepicker()
							.change(function () {
								self[this.name] = this.value
							})
						;
					}, 1);
				}
			},
		},
		computed: {
			orderListFiltered: function () {
				var selectedfilter = this.selectedFilter;


				var filterProductName = this.filterProductName;
				var filterOrderId = this.filterOrderId;


				var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
				var template = "$3-$2-$1";

				var filterDateBegin = this.filterDateBegin;
				var filterDateEnd = this.filterDateEnd;

				if (filterDateBegin) filterDateBegin = new Date(this.filterDateBegin.replace(pattern, template)).getTime() / 1000;
				if (filterDateEnd) filterDateEnd = new Date(this.filterDateEnd.replace(pattern, template)).getTime() / 1000 + 86400;

				return this.orders.filter(function (elem) {
					if (selectedfilter === "current") {
						return !elem.isHistory;
					} else {
						var fitsByOrderId = filterOrderId === "" || elem.id.toString().indexOf(filterOrderId) >= 0;
						var fitsByProductName = filterProductName === "" || elem.names.indexOf(filterProductName) >= 0;
						var fitsByDateBegin = filterDateBegin === "" || elem.timestamp > filterDateBegin;
						var fitsByDateEnd = filterDateEnd === "" || elem.timestamp < filterDateEnd;

						return elem.isHistory && fitsByOrderId && fitsByProductName && fitsByDateBegin && fitsByDateEnd;
					}

				});
			}
		}
	});


};

