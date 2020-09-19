"use strict";

import PeriodPicker from "./DatePicker";
import IntervalPicker from "./PeriodPicker";

class Form {

	constructor(form, submitCallback) {
		this.form = form;
		this.submitCallback = submitCallback;
		this.bootstrapDom();
		this.periodPicker = new PeriodPicker(this.dateInput);
		this.intervalPicker = new IntervalPicker(this.periodInput);
		this.form.addEventListener('submit', (event) => {
			this.submit(event);
		});
	}

	bootstrapDom() {
		this.dateInput = this.form.querySelector('#aggregate-date-picker');
		this.periodInput = this.form.querySelector('#aggregate-interval');
	}

	submit(event = null) {
		if (event) {
			event.preventDefault();
		}
		this.submitCallback(this.intervalPicker.getData(), this.periodPicker.getData());
	}

}

export default Form;
