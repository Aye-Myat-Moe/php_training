var vehicle = Number(document.getElementById('vehicle').value);
var foodAndDrink = Number(document.getElementById('food-drink').value);
var ele = Number(document.getElementById('ele').value);
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Vehicle', 'Food & Drink', 'Electronic'],
        datasets: [{
            label: '# of Sales',
            data: [vehicle, foodAndDrink, ele],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});