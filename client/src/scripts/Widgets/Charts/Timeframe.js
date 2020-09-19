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
			title: {
				text: 'Solar Employment Growth by Sector, 2010-2016'
			},
			subtitle: {
				text: 'Source: thesolarfoundation.com'
			},
			yAxis: {
				title: {
					text: 'Number of Employees'
				}
			},
			xAxis: {
				accessibility: {
					rangeDescription: 'Range: 2010 to 2017'
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			},
			plotOptions: {
				series: {
					label: {
						connectorAllowed: false
					},
					pointStart: 2010
				}
			},
			series: [],
			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}

		});
	}

	update(data) {
		this.datapoints = data;
		this.chart.update({series: this.datapoints},true, true);
	}

}

export default Timeframe;
