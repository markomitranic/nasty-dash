"use strict";

import axios from 'axios';

class TotalApiAdapter {


	constructor() {
		this.uri = '/api/stats/total';
	}

	resolve(aggregate, dateFrom, dateTo, callback) {
		axios.get(
			this.uri,
			{
				params: {
					aggregate: aggregate,
					dateFrom: dateFrom.unix(),
					dateTo: dateTo.unix()
				}
			}
		).then((response) => {
			if (response.status !== 200) {
				callback(null, response.data);
			}

			callback(response.data, null);
		}).catch((err) => {
			callback(null, err);
		});
	}

}

export default TotalApiAdapter;
