"use strict";

class TotalToChartSeriesTransformer {

	transform(data) {
		const customersDatapoints = [];
		const ordersDatapoints = [];

		for (let i=0; i < data.length; i++) {
			customersDatapoints.push([this.getDateFromMoment(data[i].dateFrom), data[i].customers]);
			ordersDatapoints.push([this.getDateFromMoment(data[i].dateFrom), data[i].orders]);
		}

		return [
			{
				name: 'Customers',
				data: customersDatapoints
			},
			{
				name: 'Orders',
				data: ordersDatapoints
			}
		];
	}

	getDateFromMoment(moment) {
		return moment.valueOf();
	}

}

export default TotalToChartSeriesTransformer;
