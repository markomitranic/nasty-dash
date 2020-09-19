"use strict";

import IntervalPicker from "./FieldAdapter/IntervalPicker/IntervalPicker";
import PeriodPicker from "./FieldAdapter/PeriodPicker/PeriodPicker";

class FormDispatcher {

	constructor(formWrapper) {
		this.observers = [];
		this.form = formWrapper;
		this.form.addEventListener('submit', (e) => { this.submit(e);});

		this.periodPicker = new PeriodPicker(this.form.querySelector('#aggregate-date-picker'));
		this.intervalPicker = new IntervalPicker(this.form.querySelector('#aggregate-interval'));
	}

	submit(event = null) {
		if (event !== null) { event.preventDefault(); }

		this.observers.forEach((observer) => {
			observer.fetch(
				this.intervalPicker.getData(),
				this.periodPicker.getData().startDate,
				this.periodPicker.getData().endDate
			);
		});
	}

	addObserver(observer) {
		this.observers.push(observer);
	}

}

export default FormDispatcher;
