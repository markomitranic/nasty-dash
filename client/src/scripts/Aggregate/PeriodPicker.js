"use strict";

class PeriodPicker {

	constructor(inputElement) {
		this.element = inputElement;
		this.allowedValues = ['hour', 'day', 'month', 'year'];
	}

	getData() {
		return this.sanitizeValue(this.element.value);
	}

	sanitizeValue(value) {
		if (this.allowedValues.indexOf(value)) {
			return value;
		}

		throw new Error('test');
	}

}

export default PeriodPicker;
