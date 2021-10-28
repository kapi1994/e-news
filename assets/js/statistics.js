$(document).ready(function () {
    loadStats()
    function loadStats() {
        $.ajax({
            method: 'get',
            url: 'models/action/stats.php',
            dataType: 'json',
            success: function (data) {
                console.log(data)
                newDought('viewsTotal', 'Total', data.overallViews)
                newDought('viewsH24', 'H24', data.todayViews)
                card('totalNumberOfUsers', data.totalUsers.numberOfUsers)
                card('totalNumberOfPosts', data.totalPosts.numberOfPosts)
            }
        })
    }


    const newDought = (whereToPlace, whereData, data) => {
        var labels = Object.keys(data)
        var values = Object.values(data)

        var sum = values.reduce((a, b) => {
            return a + b
        }, 0)


        $(`#${whereData}`).html(tableBody(data, sum))
        let todayOrNothing = whereData == "H24" ? "In the last 24" : "Total"
        let content = `<h5 class="text-start">${todayOrNothing} : ${sum}</h5>`
        $(`#` + whereToPlace).html(content)
        new Chart($('#Chart' + whereData), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        'rgba(253, 82, 0)',
                        'rgba(0, 207, 193)',
                        'rgba(19, 111, 99)',
                        'rgba(19, 111, 99)'
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: !window.MSInputMethodContent,
                maintainAsepctRation: false,
                legend: {
                    display: true
                }, coutoutPercentage: 75
            }
        })
    }

    const tableBody = (data, sum) => {
        var ispis = ''
        for (const key in data) {
            // console.log(key)
            ispis += `
                <tr><td class='text-capitalize'>${key}</td>
            `
            if (key != 0) {
                ispis += `<td class='text-end'>${data[key]} (${(data[key] * 100 / sum).toFixed(2)}%)</td>`
            } else {
                ispis += `<td class='text-end'>0 (0%)</td>`
            }
            ispis += `</tr > `;
        }

        return ispis
    }

    let card = (whereToPlace, data) => {
        $(`#${whereToPlace}`).html(data)
    }
});