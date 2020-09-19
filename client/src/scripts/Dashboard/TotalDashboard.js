"use strict";

import SingleDatapoint from "../Widgets/Charts/SingleDatapoint";

class TotalDashboard {

	constructor(totalApiAdapter) {
		totalApiAdapter.addObserver(data => this.totalApiUpdate(data));

		this.totalOrdersWidget = new SingleDatapoint(
			document.getElementById('total-orders-widget'),
			'Total Orders'
		);
		this.totalRevenueWidget = new SingleDatapoint(
			document.getElementById('total-revenue-widget'),
			'Total Revenue'
		);
		this.totalCustomersWidget = new SingleDatapoint(
			document.getElementById('total-customers-widget'),
			'Total Customers'
		);
	}

	totalApiUpdate(totals) {
		let sum = {
			orders: 0,
			revenue: 0,
			customers: 0
		}
		totals.forEach((total) => {
			sum.orders += total.orders;
			sum.revenue += total.revenue;
			sum.customers += total.customers;
		});
		this.totalOrdersWidget.update(sum.orders);
		this.totalRevenueWidget.update(sum.revenue);
		this.totalCustomersWidget.update(sum.customers);

		console.log(totals);
	}

}

export default TotalDashboard;
