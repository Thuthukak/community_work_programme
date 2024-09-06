const options = {
    series: [{
        name: 'Tickets',
        data: currentYearMonthValue,
    }],
    fill: {
        colors: ["#00c0ef", "#F27036", "#663F59", "#6A6E94", "#4E88B4", "#00A7C6", "#18D8D8", '#A9D794',
            '#46AF78', '#A93F55', '#8C5E58', '#2176FF', '#33A1FD', '#7A918D', '#BAFF29'
        ],
    },
    colors: [
        function({ value, seriesIndex, w }) {
            if (value < 5000) {
                return '#FF0000'
            } else {
                return '#02DFDE'
            }
        }
    ],
    chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        animations: {
            speed: 200
        },
    },
    annotations: {
        xaxis: [{
            x: 500,
        }],
    },
    plotOptions: {
        bar: {
            horizontal: false,
        },
    },
    dataLabels: {
        enabled: true,
    },
    stroke: {
        width: 0,
        curve: 'smooth'
    },
    xaxis: {
        categories: currentYearMonthName,
    },
    grid: {
        xaxis: {
            lines: {
                show: true
            }
        },
    },
    yaxis: {
        reversed: false,
        axisTicks: {
            show: true
        }
    }
};

const chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

const donutChartOptions = {
    series: departmentStatsTickets,
    chart: {
        type: 'donut',
    },
    labels: departmentStatsName,
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200,
                height: 350
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

const donutChart = new ApexCharts(document.querySelector("#donut-chart"), donutChartOptions);
donutChart.render();

const pieChartOptions = {
    series: ticketsStatusCount,
    chart: {
        width: '100%',
        type: 'pie',
    },
    labels: ticketsStatusName,
    theme: {
        monochrome: {
            enabled: true
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                offset: -5
            }
        }
    },
    dataLabels: {
        formatter(val, opts) {
            const name = opts.w.globals.labels[opts.seriesIndex]
            return [name, val.toFixed(1) + '%']
        }
    },
    legend: {
        show: false
    }
};

const pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieChartOptions);
pieChart.render();