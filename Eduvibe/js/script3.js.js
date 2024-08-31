
const regularSellChartCanvas = document.getElementById('regularSellChart');
const regularSellChartData = {
    labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    datasets: [{
        label: 'Sales',
        data: [30, 35, 48, 32, 38, 25, 42],
        backgroundColor: '#78e08f',
        borderColor: '#78e08f',
        borderWidth: 1
    }]
};
const regularSellChartOptions = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
};
const regularSellChart = new Chart(regularSellChartCanvas, {
    type: 'bar',
    data: regularSellChartData,
    options: regularSellChartOptions
});