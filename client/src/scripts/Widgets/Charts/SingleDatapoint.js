"use strict";

class SingleDatapoint {

	constructor(wrapper, title, initialData = 'N/A') {
		this.wrapper = wrapper;
		this.title = title;
		this.datapoint = initialData;
	}

	update(data) {
		if (this.isFloat(data)) {
			data = data.toLocaleString('en-US', {minimumFractionDigits: 2});
		}
		this.datapoint = data;
		this.wrapper.innerHTML = this.getTemplate(this.title, this.datapoint);
	}

	getTemplate(title, datapoint) {
		return `<p>${title}</p><p class="datapoint">${datapoint}</p>`;
	}

	isFloat(n){
		return Number(n) === n && n % 1 !== 0;
	}

}

export default SingleDatapoint;
