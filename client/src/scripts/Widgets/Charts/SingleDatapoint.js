"use strict";

class SingleDatapoint {

	constructor(wrapper, title, initialData = 'N/A') {
		this.wrapper = wrapper;
		this.title = title;
		this.datapoint = initialData;
	}

	update(data) {
		this.datapoint = data;
		this.wrapper.innerHTML = `${this.title}: ${this.datapoint}`;
	}

}

export default SingleDatapoint;
