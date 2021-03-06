"use strict";

import axios from 'axios';
import Dispatcher from "../Dispatcher";
import Total from "./Total";
import moment from "moment";

class ApiAdapter extends Dispatcher {

	constructor(notificationPopup, spinner) {
		super(notificationPopup);
		this.spinner = spinner;
		this.uri = '/api/stats/total';
	}

	fetch(interval, dateFrom, dateTo) {
		this.spinner.on();
		axios.get(
			this.uri,
			{
				params: {
					aggregate: interval,
					dateFrom: dateFrom.unix(),
					dateTo: dateTo.unix()
				}
			}
		).then((response) => {
			this.spinner.off();
			if (response.status !== 200) {
				this.update(null, response.data);
			}

			this.update(this.transformData(response.data), null);
		});
	}

	transformData(rawData) {
		const transformedData = [];

		rawData.data.forEach((total) => {
			transformedData.push(new Total(
				moment(total.dateFrom),
				moment(total.dateTo),
				total.orders,
				total.revenue,
				total.customers
			));
		});
		return transformedData;
	}
}

export default ApiAdapter;
