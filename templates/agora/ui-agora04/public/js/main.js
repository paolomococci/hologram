const baseUrl = "https://api-agora01.hologram-srv.local/";
let count = 1;

$(document).ready(function () {
    // increment
    $('#increment').click(
        function () {
            $('#increment').text(`count is ${count++}`)
        }
    );

    // GET sanctum/csrf-cookie
    $.get(
        baseUrl + "sanctum/csrf-cookie",
        function (data) {
            console.log(`Csrf-cookie: ${data}`);
        }
    );

    // GET api/ping
    $.get(
        baseUrl + "api/ping",
        function (data) {
            console.log('Success:', data);
            const response = JSON.parse(data);
            if (response.status === 200) {
                $("#loading").remove();
                $("#message").text(response.message);
            } else {
                $("#message").text(`Sorry, there was an error. <em>>response.status</em> is: ${response.status}`);
            }
        }
    );
});
