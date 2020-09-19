"use strict";

class TotalToChartSeriesTransformer {

	transform(data) {
		const customersDatapoints = [];
		const ordersDatapoints = [];

		for (let i=0; i < data.length; i++) {
			customersDatapoints.push(data[i].customers);
			ordersDatapoints.push(data[i].orders);
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

}

export default TotalToChartSeriesTransformer;
