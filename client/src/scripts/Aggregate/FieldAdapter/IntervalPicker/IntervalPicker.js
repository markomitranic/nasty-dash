"use strict";

class IntervalPicker {

	constructor(inputElement) {
		this.element = inputElement;
		this.allowedValues = ['hour', 'day', 'month', 'year'];
	}

	getData() {
		return this.sanitizeValue(this.element.value);
	}

	sanitizeValue(value) {
		if (this.allowedValues.indexOf(value) >= 0) {
			return value;
		}

		throw new Error('Provided interval value is not allowed ' + value);
	}

}

export default IntervalPicker;
