// /* ----- Employee Dashboard Chart Js For Applications Statistics ----- */
// Circle Doughnut Chart
var ctx = document.getElementById('myChart').getContext('2d');
var doughnutData = (function () {
    if (window.DASHBOARD_STATS && window.DASHBOARD_STATS.totals) {
        var t = window.DASHBOARD_STATS.totals;
        var labels = ['Sales', 'Trips', 'Tours', 'Visas', 'Portals', 'PettyCash'];
        var data = [t.totalSales || 0, t.totalTrips || 0, t.totalTours || 0, t.totalVisas || 0, t.totalPortals || 0, t.totalPetty || 0];
        var colors = ['#5BBB7B', '#FFEDE8', '#FBF7ED', '#FFD56B', '#7CC7FF', '#E6E6E6'];
        return { labels: labels, datasets: [{ data: data, backgroundColor: colors }] };
    }
    return {
        labels: [' Direct 32%', 'Referal 28%', 'Oragnic 40%'],
        datasets: [{
            data: [50, 25, 25],
            backgroundColor: ["#5BBB7B", "#FFEDE8", "#FBF7ED"]
        }]
    };
})();

var ctx = document.getElementById('myChart').getContext('2d');
var doughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: doughnutData,
    options: {
        aspectRatio: 0,
        cutoutPercentage: 60,
        responsive: true,
        legend: { position: 'left' }
    }
});

// LineChart Style 2
var lineCtx = document.getElementById('myChartweave').getContext('2d');
// helper: build months list
function monthsListLastN(n) {
    var now = new Date();
    var arr = [];
    for (var i = n - 1; i >= 0; i--) {
        var dt = new Date(now.getFullYear(), now.getMonth() - i, 1);
        var key = dt.getFullYear() + '-' + String(dt.getMonth() + 1).padStart(2, '0');
        var label = dt.toLocaleString('default', { month: 'short' }) + ' ' + dt.getFullYear();
        arr.push({ key: key, label: label });
    }
    return arr;
}

function monthsListYTD() {
    var now = new Date();
    var arr = [];
    for (var m = 0; m <= now.getMonth(); m++) {
        var dt = new Date(now.getFullYear(), m, 1);
        var key = dt.getFullYear() + '-' + String(dt.getMonth() + 1).padStart(2, '0');
        var label = dt.toLocaleString('default', { month: 'short' }) + ' ' + dt.getFullYear();
        arr.push({ key: key, label: label });
    }
    return arr;
}

function yearsListLastN(n) {
    var now = new Date();
    var arr = [];
    for (var i = n - 1; i >= 0; i--) {
        var y = now.getFullYear() - i;
        arr.push({ key: String(y), label: String(y) });
    }
    return arr;
}

function sumByYear(arr, monthKeyName, valueName, year) {
    if (!Array.isArray(arr)) return 0;
    var total = 0;
    for (var i = 0; i < arr.length; i++) {
        var item = arr[i];
        var monthKey = item[monthKeyName] || '';
        if (String(monthKey).indexOf(year + '-') === 0 || String(monthKey) === year) {
            total += parseFloat(item[valueName] || 0);
        }
    }
    return total;
}

function findByKey(arr, key, keyName) {
    if (!Array.isArray(arr)) return null;
    for (var i = 0; i < arr.length; i++) {
        if ((arr[i][keyName] || '') === key) return arr[i];
    }
    return null;
}

function buildRangeData(range) {
    // range: 'Last 6 Months', 'Last 12 Months', 'Year To Date'
    var months = [];
    if (range === 'Last 12 Months') months = monthsListLastN(12);
    else if (range === 'Last 10 Years' || range === 'Year To Date') {
        // user requested Year To Date to show last 10 years year-wise
        months = yearsListLastN(10);
    } else months = monthsListLastN(6);

    var salesArr = window.DASHBOARD_STATS && window.DASHBOARD_STATS.salesByMonth ? window.DASHBOARD_STATS.salesByMonth : [];
    var expensesArr = window.DASHBOARD_STATS && window.DASHBOARD_STATS.expensesByMonth ? window.DASHBOARD_STATS.expensesByMonth : [];

    var labels = months.map(function (m) { return m.label; });
    var sales = months.map(function (m) {
        if (m.key && m.key.length === 4) {
            return parseFloat(sumByYear(salesArr, 'sale_month', 'total_sales', m.key)) || 0;
        }
        var s = findByKey(salesArr, m.key, 'sale_month');
        return parseFloat((s && (s.total_sales || s.total || 0)) || 0);
    });
    var expenses = months.map(function (m) {
        if (m.key && m.key.length === 4) {
            return parseFloat(sumByYear(expensesArr, 'expense_month', 'total_expense', m.key)) || 0;
        }
        var e = findByKey(expensesArr, m.key, 'expense_month');
        return parseFloat((e && (e.total_expense || e.total || 0)) || 0);
    });

    return { labels: labels, sales: sales, expenses: expenses };
}

var lineChart = new Chart(lineCtx, {
    // The type of chart we want to create
    type: 'line', // also try bar or other graph types
    data: (function () {
        var initial = buildRangeData('Last 6 Months');
        return {
            labels: initial.labels,
            datasets: [
                { label: 'Sales', backgroundColor: 'rgba(124,199,255,0.35)', borderColor: '#7CC7FF', fill: true, data: initial.sales },
                { label: 'Expenses', backgroundColor: 'rgba(251,247,237,0.6)', borderColor: '#5BBB7B', fill: true, data: initial.expenses }
            ]
        };
    })(),

    // Configuration options
    options: {
        layout: {
            padding: 10,
        },
        legend: {
            position: 'top',
        },
        title: {
            display: false,
            text: 'Precipitation in Toronto'
        },
        scales: {
            yAxes: [{
                scaleLabel: { display: true },
                ticks: {
                    beginAtZero: true,
                    // max will be set dynamically below if reportSample exists
                }
            }],
            xAxes: [{ scaleLabel: { display: true } }]
        }
    }
});

// Update Y max helper
function updateYAxisMaxForChart(ch) {
    try {
        var ds = [];
        ch.data.datasets.forEach(function (d) { ds = ds.concat(d.data || []); });
        var maxVal = Math.max.apply(null, ds.concat([0]));
        var step = Math.pow(10, Math.floor(Math.log10(maxVal || 1)));
        var niceMax = Math.ceil((maxVal + 1) / step) * step;
        if (ch && ch.options && ch.options.scales && ch.options.scales.yAxes && ch.options.scales.yAxes[0]) {
            ch.options.scales.yAxes[0].ticks.max = niceMax;
            ch.update();
        }
    } catch (e) { /* silent */ }
}

// dropdown handling: update line chart when selection changes
function attachRangeSelector() {
    var sel = document.querySelector('select.selectpicker');
    if (!sel) return;
    sel.addEventListener('change', function (ev) {
        var val = ev.target.value || ev.target.options[ev.target.selectedIndex].text;
        var range = val.trim();
        var data = buildRangeData(range);
        if (lineChart) {
            lineChart.data.labels = data.labels;
            lineChart.data.datasets[0].data = data.sales;
            lineChart.data.datasets[1].data = data.expenses;
            updateYAxisMaxForChart(lineChart);
            lineChart.update();
        }
    });

    // trigger initial set (in case select has non-default)
    var evt = new Event('change');
    sel.dispatchEvent(evt);
}

attachRangeSelector();

