"use strict";
import moment from "moment";
import $ from "jquery";
import 'daterangepicker';
import DateSelectionDTO from "./DateSelectionDTO";

class DatePicker {

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
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});

		$(element).on('apply.daterangepicker', (event, picker) => {
			this.setData(picker.startDate, picker.endDate);
		});
	}

	setData(startDate, endDate) {
		this.data = new DateSelectionDTO(startDate, endDate);
	}

	getData() {
		return this.data;
	}

}

export default DatePicker;
