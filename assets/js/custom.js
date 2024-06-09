
console.log('Custom JS loaded');
$(document).on('click', '.removeData', function() {
    let id = $(this).attr("data-id");
    let targetUrl = $(this).attr("data-url"); 
    $.ajax({
        url: targetUrl,
        method: 'POST',
        data: {
            id: id,
        },
        dataType: "json",
        success: function(response) {
            console.log('AJAX request was successful');
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        },
    });
});

$(document).on('click', '.detail', function() {
    $("#staticBackdrop").modal('show');
    $("#fullname").val($(this).attr("data-name"));
    $("#age").val($(this).attr("data-age"));
    $("#occupation").val($(this).attr("data-occupation"));
    $('#submit').attr('data-mode', (!$(this).attr("data-id") ? "insert" : "update"));
    $('#submit').attr('data-id', (!$(this).attr("data-id") ? null : $(this).attr("data-id")));
    $("#staticBackdropLabel").text(!$(this).attr("data-id") ? "Create Data Form" : "Update Data Form");
});

$(document).on('click', '#submit', function() {
    let id = $(this).attr("data-id") ? $(this).attr("data-id") : null;
    let targetUrl = $(this).attr("data-route");
    $.ajax({
        url: targetUrl,
        method: 'POST',
        data: {
            id: id,
            name:  $("#fullname").val(),
            age: $("#age").val(),
            occupation: $("#occupation").val()
        },
        dataType: "json",
        success: function(response) {
            console.log('AJAX request was successful');
            location.reload();
        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed: ' + error);
        }
    });
});
