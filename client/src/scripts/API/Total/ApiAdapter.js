"use strict";

import axios from 'axios';
import Dispatcher from "../Dispatcher";

class ApiAdapter extends Dispatcher {

	constructor(notificationPopup) {
		super(notificationPopup);
		this.uri = '/api/stats/total';
	}

	fetch(interval, dateFrom, dateTo) {
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
			if (response.status !== 200) {
				this.update(null, response.data);
			}

			this.update(response.data, null);
		}).catch((err) => {
			this.update(null, err);
		});
	}
}

export default ApiAdapter;
