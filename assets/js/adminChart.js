$(document).ready(function () {

    function pieChartPages() {
        $.ajax({
            url: "models/actions/getStats.php",
            method: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data)
                // console.log(data)
                newPie('viewsTotal', 'Total', data.overallViews)
                newPie('views24H', '24h', data.todayViews)


                $('#registeredUsers').html(data.registeredUsers.users)
                $('#todayLogins').html(data.todayLogin)
            }
        })
    }

    const newPie = (wherePie, whereData, data) => {
        var labels = Object.keys(data);
        var values = Object.values(data);
        var sum = values.reduce(function (a, b) {
            return a + b;
        }, 0);
        var text = whereData == "24h" ? 'in last 24h' : ''
        let html = `<h1 class="fs-4">Total ${text}<span class="fs-bold">: ${sum}</span></h1>`
        $(`#${wherePie}`).html(html)
        $(`#${whereData}`).html(viewPieTBody(data, sum))

        var ch = $('#chart' + whereData)
        var chart = new Chart(ch, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        'rgba(87, 196, 229)',
                        'rgba(221, 64, 58)',
                        'rgba(255, 208, 70)',
                        'rgba(8, 164, 189)'

                    ]
                }]
            }
        })



    }

    const viewPieTBody = (data, sum) => {
        var html = "";
        for (const key in data) {
            html += `<tr><td class="text-start align-middle text-uppercase">${key}</td>`
            if (sum != 0)
                html += `<td class="text-end fs-4">${data[key]}
(${(data[key] * 100 / sum).toFixed(2)}%)</td>`
            else
                html += `<td class="text-end">0 (0%)</td>`
            html += `</tr>`
        }
        return html;
    }

    pieChartPages()
});