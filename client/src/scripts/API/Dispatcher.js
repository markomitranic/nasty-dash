"use strict";

class Dispatcher {

	constructor(notificationPopup) {
		this.observers = [];
		this.notificationPopup = notificationPopup;
	}

	addObserver(observer) {
		this.observers.push(observer);
	}

	update(data, error) {
		if (error !== null) {
			this.notificationPopup.add(error.message);
			return;
		}

		this.observers.forEach((observer) => {
			observer(data);
		});
	}

}

export default Dispatcher;
