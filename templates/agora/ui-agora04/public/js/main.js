let count = 1

$(document).ready(function () {
    $('#increment').click(
        function() {
            $('#increment').text(`count is ${count++}`)
        }
    )
})
