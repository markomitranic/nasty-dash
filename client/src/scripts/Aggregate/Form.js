"use strict";

import IntervalPicker from "./IntervalPicker";
import PeriodPicker from "./PeriodPicker";

class Form {

	constructor(form, submitCallback) {
		this.form = form;
		this.submitCallback = submitCallback;
		this.bootstrapDom();
		this.periodPicker = new PeriodPicker(this.dateInput);
		this.intervalPicker = new IntervalPicker(this.intervalInput);
		this.form.addEventListener('submit', (event) => {
			this.submit(event);
		});
	}

	bootstrapDom() {
		this.dateInput = this.form.querySelector('#aggregate-date-picker');
		this.intervalInput = this.form.querySelector('#aggregate-interval');
	}

	submit(event = null) {
		if (event) {
			event.preventDefault();
		}
		this.submitCallback(this.intervalPicker.getData(), this.periodPicker.getData());
	}

}

export default Form;
