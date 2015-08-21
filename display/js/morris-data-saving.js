$(function() {
    "use strict";

    $.getJSON("data2.php?group=neraca", function (json) {
        console.log(json);
        for (var i = 0; i < json.length; i++) {            
            var row = $("<tr><td>"+(i+1)+". </td> <td>"+json[i].postdate+"</td> <td>"+json[i].kategori+"</td> <td class='text-right' style='padding:7px 30px'>"+json[i].fdebet+"</td> <td class='text-right' style='padding:7px 30px'>"+json[i].fkredit+"</td> <td>"+json[i].keterangan+"</td> </tr>");
            $("#neraca").append(row);
        }
    });    


     $.getJSON("data2.php?group=smallbox-saving", function (json) { // callback function which gets called when your request completes.   
        for (var i = 0; i<json.length; i++) {
          $('#v'+json[i].name).html(json[i].formatedvalue);
          $('#lb'+json[i].name).html(json[i].label);
        }
    });    

                
     

    

});