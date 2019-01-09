function toggleSymptomsStatus(id){
    var symptid = id;
    $.ajax({
        url: "../doctor/ajaxfiles/records.php",
        method: "POST",
        data: {
            'symptid':symptid
        },
        beforeSend: function(){
            $('.symptStatus'+id).show();
        },
        success:function(data){
            // $('.symptStatus'+id).hide();
            // location.reload();
            alert("hey");
        }
    })
}

// Up Next
    // trying to solve the success callback