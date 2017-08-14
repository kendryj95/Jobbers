$(document).ready(function(){

    /* Line Chart */
    var data1 = [[1, 10], [2, 20], [3, 12], [4, 28], [5, 15]];
    var data2 = [[1, 8], [2, 15], [3, 10], [4, 18], [5, 8]];

    var labels = ["Visits", "Page views", "Sales"];
    var colors = [
        '#43b968',
        '#3e70c9'
    ];

    /* Realtime chart */
    $(function() {

        // We use an inline data source in the example, usually data would
        // be fetched from a server

        var data = [],
            totalPoints = 300;

        function getRandomData() {
            if (data.length > 0)
                data = data.slice(1);

            // Do a random walk

            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;

                if (y < 5) {
                    y = 5;
                } else if (y > 95) {
                    y = 95;
                }

                data.push(y);
            }

            // Zip the generated y values with the x values

            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }

            return res;
        }

        // Set up the control widget

        var updateInterval = 30;

    });

});