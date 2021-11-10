
function my_getDate (args) {
	let obj=new Date(args);
	year=(obj.getFullYear()).toString();
    if(obj.getMonth()+1<10)
        month="0"+(obj.getMonth()+1);
    else
        month=(obj.getMonth()+1).toString();

    if(obj.getDate()<10)
        date="0"+obj.getDate();
    else
        date=obj.getDate().toString();
    return (year+"-"+month+"-"+date);
}
function myAlertSuccess (args) {
    for(i=0;i<2;i++){
        $.notify(
        {
            icon: 'fa fa-check-circle fa-2x',
            title: '<strong>Successfully!</strong>',
            message: args.toString()+" Information"
        },
        {
            type:'warning'
        }); 
    }
}
function myAlertInfo (args) {
    for(i=0;i<2;i++){
        $.notify(
        {
            icon: 'fa fa-info-circle',
            title: '<strong>'+args.toString()+'</strong>',
            message:''
        },
        {
            type:'warning'
        });
    }
}
function myAlertError (args) {
    for(i=0;i<2;i++){
        $.notify(
        {
            icon: 'fa fa-close fa-2x',
            title: '<strong>Error !</strong>',
            message: args.toString()
        },
        {
            type:'danger'
        });
    }
}


function deleteRecord(v_id){
    swal({
        title: "Are you sure delete record?",
        text: "Once deleted, you will not be affect to another data that relate this record!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'delete.php?del_id='+v_id,
                success: function(result){
                    swal("Your Record is deleted !", {
                      icon: "success",
                    })
                    .then((status)=>{
                        location.reload();
                    });
                }
            });
        } else {
            swal("Your record is safe!");
        }
    });
}
function isNumber(e){
    return ((e.charCode >= 48 && e.charCode <= 57)||e.keyCode==46);
}