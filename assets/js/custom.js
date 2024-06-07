
console.log('Custom JS loaded');
$(document).on('click', '.rico', function() {
    let id = $(this).attr("data-id");
    alert('rico hachero!' + id);
});