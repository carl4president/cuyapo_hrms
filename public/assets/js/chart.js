$(document).ready(function() {

    // Bar Chart
    Morris.Bar({
        element: 'bar-charts',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Total Income', 'Total Outcome'],
        barColors: ['#f43b48', '#453a94'],
        resize: true,
        redraw: true
    });

    // Line Chart
    Morris.Line({
        element: 'line-charts',
        data: [
            { y: '2006', a: 50, b: 90 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 50 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Total Sales', 'Total Revenue'],
        lineColors: ['#f43b48', '#453a94'],
        lineWidth: '3px',
        resize: true,
        redraw: true
    });

    // **New Area Chart**
    Morris.Area({
        element: 'area-charts',
        data: [
            { y: '2006', a: 30, b: 20 },
            { y: '2007', a: 50, b: 40 },
            { y: '2008', a: 75, b: 65 },
            { y: '2009', a: 100, b: 90 },
            { y: '2010', a: 50, b: 40 },
            { y: '2011', a: 75, b: 65 },
            { y: '2012', a: 90, b: 80 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Profit', 'Expenses'],
        lineColors: ['#f43b48', '#453a94'],
        fillOpacity: 0.5,
        behaveLikeLine: true,
        resize: true,
        redraw: true
    });

    // **New Donut Chart**
    Morris.Donut({
        element: 'donut-charts',
        data: [
            { label: "Product A", value: 30 },
            { label: "Product B", value: 50 },
            { label: "Product C", value: 20 }
        ],
        colors: ['#f43b48', '#453a94', '#ffcc00'],
        resize: true
    });

    // **New Stacked Bar Chart**
    Morris.Bar({
        element: 'stacked-bar-charts',
        data: [
            { y: '2016', a: 100, b: 90, c: 80 },
            { y: '2017', a: 75, b: 65, c: 55 },
            { y: '2018', a: 50, b: 40, c: 30 },
            { y: '2019', a: 75, b: 65, c: 55 },
            { y: '2020', a: 50, b: 40, c: 30 },
            { y: '2021', a: 75, b: 65, c: 55 },
            { y: '2022', a: 100, b: 90, c: 80 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Category A', 'Category B', 'Category C'],
        stacked: true,
        barColors: ['#f43b48', '#453a94', '#ffcc00'],
        resize: true,
        redraw: true
    });

});
