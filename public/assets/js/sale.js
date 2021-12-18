var total_quantity = 0;
var total_discount = 0;
var grand_total = 0;
var sl_no = 1;

function calc_total(id_index){
    var unit_price = parseFloat($("#unit_price"+id_index).val()) || 0;
    var quantity = parseFloat($("#quantity"+id_index).val()) || 0;
    var discount = parseFloat($("#discount"+id_index).val()) || 0;

    var total = (unit_price * quantity) - discount;

    $("#total"+id_index).val(total);

    if(id_index){
        grand_calculation();
    }
}

function add_row(){
    console.log("hello");

    var item_id = $("#item_id").val();
    var item_name = $("#item_id").find(':selected').text();

    var unit_price = parseFloat($("#unit_price0").val()) || 0;
    var quantity = parseFloat($("#quantity0").val()) || 0;
    var discount = parseFloat($("#discount0").val()) || 0;

    var total = (unit_price * quantity) - discount;

    // reset
    $("#item_id").css("border", "1px solid black");
    $("#unit_price0").css("border", "1px solid black");
    $("#quantity0").css("border", "1px solid black");


    // validation
    var error_status = false;

    if(item_id == ''){
        error_status = true;
        $("#item_id").css("border", "1px solid red");
    }

    if(unit_price == ''){
        error_status = true;
        $("#unit_price0").css("border", "1px solid red");
    }

    if(quantity == ''){
        error_status = true;
        $("#quantity0").css("border", "1px solid red");
    }

    if(error_status){
        return false;
    }

    var html = '<tr id="row'+sl_no+'">'+
        '<td><input name="item_id[]" value="' + item_id + '" class="form-control" type="hidden"/>'+
        '<input value="' + item_name + '" class="form-control" readonly/></td>'+
        '<td><input name="unit_price[]" id="unit_price'+sl_no+'" value="' + unit_price + '" class="form-control" readonly /></td>'+
        '<td><input name="quantity[]" id="quantity'+sl_no+'" value="' + quantity + '" class="form-control" onkeyup="calc_total('+sl_no+')" /></td>'+
        '<td><input name="discount[]" id="discount'+sl_no+'" value="' + discount + '" class="form-control" onkeyup="calc_total('+sl_no+')" /></td>'+
        '<td><input name="total[]" id="total'+sl_no+'" value="' + total + '" class="form-control" readonly/></td>'+
        '<td><button class="btn btn-sm btn-danger" onclick="remove_item('+sl_no+')"><i class="fa fa-times"></i></button></td>'+
        '</tr>';

    $("#output").append(html);

    sl_no++;

    reset_item_add();

}

function reset_item_add(){
    $("#item_id").val('');
    $("#unit_price0").val('');
    $("#quantity0").val('');
    $("#discount0").val('');
    $("#total0").val('');

    grand_calculation();
}


function grand_calculation(){
    total_quantity = 0;
    total_discount = 0;
    grand_total = 0;

    for(var i = 1; i <= sl_no; i++){
        var unit_price = parseFloat($("#unit_price"+i).val()) || 0;
        var quantity = parseFloat($("#quantity"+i).val()) || 0;
        var discount = parseFloat($("#discount"+i).val()) || 0;

        var total = (unit_price * quantity) - discount;

        total_quantity += quantity;
        total_discount += discount;
        grand_total += total;
    }

    $("#total_quantity").html(total_quantity);
    $("#total_discount").html(total_discount);
    $("#grand_total").html(grand_total);
}


function remove_item(row_index){
    var unit_price = parseFloat($("#unit_price"+row_index).val()) || 0;
    var quantity = parseInt($("#quantity"+row_index).val()) || 0;
    var discount = parseFloat($("#discount"+row_index).val()) || 0;

    var total = (unit_price * quantity) - discount;

    total_quantity -= quantity;
    total_discount -= discount;
    grand_total -= total;

    $("#row"+row_index).remove();

    grand_calculation();
}

