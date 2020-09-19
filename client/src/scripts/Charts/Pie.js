"use strict";

import Highcharts from 'highcharts';

class Pie {

	constructor() {
		this.bootstrapDom();
		this.initChart();
	}

	bootstrapDom() {
		this.chartElement = document.createElement('div');
		this.chartElement.id = 'pie-chart';
		this.chartElement.style.height = '370px';
		this.chartElement.style.width = '100%';
		this.container.append(this.chartElement);
	}

	initChart() {
		this.chart = new CanvasJS.Chart(this.chartElement, {
			animationEnabled: true,
			data: [{
				type: "pie",
				startAngle: 240,
				indexLabel: "{label}",
				dataPoints: [
				]
			}]
		});
	}

	populate(room) {
		console.log('populating room');
	}

}

export default Pie;
