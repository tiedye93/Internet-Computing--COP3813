//--------------------Persistence---------------------
if (localStorage.toDos) {
    var toDos = JSON.parse(localStorage.toDos);
} else {
    var toDos = [];
}

for (var i = 0; i < toDos.length; i++) {
    var anItem = toDos[i];
    $(".list").append(anItem);
}

function updateStorage() {
    var newToDos = [];
    $("p").each(function () {
        newToDos.push('<p>' + $(this).html()) + '</p>';
    });
    toDos = newToDos;
    localStorage.toDos = JSON.stringify(toDos);
}

//------------------------------------------------------

function updateText() {
    var newText = $(this).find('input').val();
    $(this).after('<span class="item">' + newText + '</span>');
    $(this).remove();
    updateStorage();
    return false;
}

function checkboxToggle() {
    $(this).toggleClass('glyphicon-unchecked').toggleClass('glyphicon-check');
   
    if ($(this).is('.glyphicon-unchecked')) {
        $(this).next().removeClass('strike');
    } else {
        $(this).next().addClass('strike');
    }
    updateStorage();
}



var template = function (text) {
   return '<p><i class="glyphicon glyphicon-unchecked"></i></i> <span class="item">' + text + '</span><span class="glyphicon glyphicon-remove"></span></p>';
};





var main = function () {
    $('.form-class').on('submit', function () {
        var html = template($('#todo').val());
        $('.list').append(html);
        $('#todo').val('');
        updateStorage();

        return false;
    });   

    $('.list').on("click", '.glyphicon-unchecked', checkboxToggle);
    $('.list').on("click", '.glyphicon-check', checkboxToggle);

    $('.list').on("click", '.glyphicon-star', function () {
        $(this).toggleClass('active');
        updateStorage();
    });

    $('.list').on("click", '.glyphicon-remove', function () {
        $(this).parent().remove();
        updateStorage();
    });

    $('.list').on("click", '.item', function () {

        var editVal = $(this).text();
        $(this).val("");
        var $newInput = $(this).before('<form class="in-line"><input name="edit-me" type="text" value=""></form>');
        $('input[name="edit-me"]').val(editVal).focus();
        $(this).remove();
        updateStorage();
    }); 

    $(".list").on("submit", '.in-line', function () {
        event.preventDefault();
    });

    //code from internet
    $(".list").on("keyup", '.in-line', function (e) {
        if (e.which === 13) {
            e.target.blur();
        }
    });

    $('.list').on("focusout", '.in-line', updateText);

};

$(document).ready(main);