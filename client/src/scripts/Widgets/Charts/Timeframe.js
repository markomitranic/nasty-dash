"use strict";

import Highcharts from 'highcharts';

class Timeframe {

	constructor(wrapper, title, initialData = []) {
		this.wrapper = wrapper;
		this.title = title;
		this.datapoints = initialData;

		this.createChart();
	}

	createChart() {
		this.chart = Highcharts.chart(this.wrapper, {
			chart: {
				type: 'spline',
				scrollablePlotArea: {
					minWidth: 600,
					scrollPositionX: 1
				}
			},
			title: {
				text: 'Orders and newly registered Customers',
				align: 'left'
			},
			xAxis: {
				type: 'datetime',
				labels: {
					overflow: 'justify'
				},
				title: {
					text: 'Date'
				}
			},
			yAxis: {
				title: {
					text: 'Number of events'
				},
				min: 0
			},
			tooltip: {
				headerFormat: '<b>{series.name}</b><br>',
				pointFormat: '{point.x:%e. %b}: {point.y:.2f}'
			},
			plotOptions: {
				spline: {
					lineWidth: 4,
					states: {
						hover: {
							lineWidth: 5
						}
					},
					marker: {
						enabled: false
					},
					pointInterval: 3600000, // one hour
					pointStart: Date.UTC(2018, 1, 13, 0, 0, 0)
				}
			},
			series: [],
			navigation: {
				menuItemStyle: {
					fontSize: '10px'
				}
			},

			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			}

		});
	}

	update(data) {
		this.datapoints = data;
		this.chart.update({series: this.datapoints},true, true);
	}

}

export default Timeframe;
