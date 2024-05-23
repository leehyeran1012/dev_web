function chart_view(id, xvalue, yvalue) {
	var id = id;
	var xValues = xvalue;
	var yValues = yvalue;
	var barColors = ["#b91d47","#00aba9","#2b5797","#e8c3b9","#1e7145"	];

	Chart.defaults.set('plugins.datalabels', {
		color: '#ffffff',
		font: {size: 12 }
	});

	new Chart("myChart"+id, {
		type: "pie",
		data: {
			labels: xValues,
			datasets: [{
			backgroundColor: barColors,
			data: yValues
			}]
		},
		plugins: [ChartDataLabels],
		options: {
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: 'right',
				 },
				datalabels: {
					formatter: function(value, context) {
					return context.chart.data.labels[context.dataIndex]+'\n\r('+value+'%)';
					}
				},
				title: {
					display: false,
					text: ""
				},
				tooltip: {
				enabled: false
			  }
			}
		}
	});
}

function chart_view2(id, xvalue, yvalue) {
	var id = id;
	var xValues = xvalue;
	var yValues = yvalue;

	new Chart("myChart"+id, {
		type: 'pie',
		data: {
		  labels: xValues,
		  datasets: [{
			data: yValues,
			borderWidth: 1
		  }]
		},
		options: {
			maintainAspectRatio: false,
			plugins: {
			  legend: {
				position: 'right',
			  },
			  title: {
				display: false,
				text: ''
			  }
			}
		}
	});
}

