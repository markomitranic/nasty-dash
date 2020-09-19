"use strict";

class Spinner {

	constructor(wrapper) {
		this.wrapper = wrapper;
		this.count = 0;
	}

	on() {
		this.wrapper.style.opacity = 1;
		this.count++;
	}

	off() {
		this.count--;
		if (this.count <= 0) {
			this.count = 0;
			this.wrapper.style.opacity = 0;
		}
	}

}

export default Spinner;
