"use strict";

import moment from "moment";
import $ from "jquery";
import 'daterangepicker';
import Interval from "./Interval";

class PeriodPicker {

	constructor(
		element,
		startDate = moment().subtract(29, 'days'),
		endDate = moment()
	) {
		this.setData(startDate, endDate);

		this.picker = $(element).daterangepicker({
			opens: 'right',
			startDate: this.getData().startDate,
			endDate: this.getData().endDate,
			maxDate: moment(),
			minDate: moment.unix(0),
			timePicker: true,
			alwaysShowCalendars: true,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, (startDate, endDate, label) => {
			this.setData(startDate, endDate);
		});
	}

	setData(startDate, endDate) {
		this.data = new Interval(startDate, endDate);
	}

	getData() {
		return this.data;
	}

}

export default PeriodPicker;
