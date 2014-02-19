var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f13/fanl/test/server-side";

$(document).ready(function () {
/*---------------------Inventory---------------------------*/
    $.ajax(url_base + "/inventory.php",
	       {type: "GET",
		       dataType: "json",
		       success: function(inventory_ids, status, jqXHR) {
		       for (var i=0; i<inventory_ids.length; i++) {
			   load_inventory_item(inventory_ids[i]);
		       }
		     }
	       });
		   
	$('#new_inventory_form').on('submit',
			       function (e) {
				   e.preventDefault();
				   $.ajax(url_base + "/inventory.php",
					  {type: "POST",
						  dataType: "json",
						  data: $(this).serialize(),
						  success: function(inventory_json, status, jqXHR) {
						  var t = new Inventory(inventory_json);
						  $('#inventory').append(t.makeCompactInventoryTable());
					      },
						  error: function(jqXHR, status, error) {
						  alert(jqXHR.responseText);
					      }});
			       });
				   
	$('#inventory').on('dblclick',
			   'tr.inventory',
			   null,
			   function (e) {
			       var t = $(this).data('inventory');
                   console.log(t)
			       $(this).replaceWith(t.makeEditDiv());
			   });

	$('#inventory').on('submit',
			   'form.edit_form',
			   null,
			   function (e) {
			       e.preventDefault();
			       var edit_div = $(this).parent();
			       var t = edit_div.data('inventory');
			       $.ajax(url_base + "/inventory.php/" + t.item_id,
				      {type: "POST",
					      dataType: "json",
					      data: $(this).serialize(),
					      success: function(inventory_json, status, jqXHR) {
					      var t = new Inventory(inventory_json);
					      edit_div.replaceWith(t.makeCompactInventoryTable());
					  },
					      error: function(jqXHR, status, error) {
					      alert(jqXHR.responseText);
					  }});
			   });

    $('#inventory').on('submit',
        'form.add_form',
        null,
        function (e) {
            e.preventDefault();
            var edit_div = $(this).parent().parent();
            var that = $(this).parent();

            $.ajax(url_base + "/inventory.php",
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(inventory_json, status, jqXHR) {
                        var t = new Inventory(inventory_json);
                        that.replaceWith(t.makeCompactInventoryTable());
                    },
                    error: function(jqXHR, status, error) {
                        alert(jqXHR.responseText);
                    }});
        });

	$('#inventory').on('click',
			   'form.edit_form > button.cancel',
			   null,
			   function (e) {
			       var edit_div = $(this).parent().parent();
			       var t = edit_div.data('inventory');
			       edit_div.replaceWith(t.makeCompactInventoryTable());
			   });

    $('#inventory').on('click',
        'td > button.delete',
        null,
        function (e) {
            var inventory_id = $(this).attr('item_id');

            $.ajax(url_base + "/inventory.php/" + inventory_id + "?delete", {
                type: 'GET',
                success: function(){
                    location.reload();
                },
                error: function(jqXHR, status, error) {
                    alert(jqXHR.responseText);
                }
            })

        });

    $('#inventory').on('click',
        'form.add_form > button.cancel',
        null,
        function (e) {
            $(this).parent().parent().remove();
        });

    $('#inventory_add').click(function(){
        Inventory.prototype.makeAddDiv().insertAfter($('#inventory tr:first-child'));
    })

/*---------------------Order---------------------------*/
    $.ajax(url_base + "/order.php",
	       {type: "GET",
		       dataType: "json",
		       success: function(order_ids, status, jqXHR) {
		       for (var i=0; i<order_ids.length; i++) {
			   load_order_item(order_ids[i]);
		       }
		     }
	       });

    $('#new_order_form').on('submit',
        function (e) {
            e.preventDefault();
            $.ajax(url_base + "/order.php",
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(order_json, status, jqXHR) {
                        var t = new order(order_json);
                        $('#order').append(t.makeCompactInventoryTable());
                    },
                    error: function(jqXHR, status, error) {
                        alert(jqXHR.responseText);
                    }});
        });

    $('#order').on('dblclick',
        'tr.order',
        null,
        function (e) {
            var t = $(this).data('order');
            $(this).replaceWith(t.makeEditDiv());
        });

    $('#order').on('submit',
        'form.edit_form',
        null,
        function (e) {
            e.preventDefault();
            var edit_div = $(this).parent();
            var t = edit_div.data('order');
            $.ajax(url_base + "/order.php/" + t.order_id,
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(order_json, status, jqXHR) {
                        var t = new Order(order_json);
                        edit_div.replaceWith(t.makeCompactOrderTable());
                    },
                    error: function(jqXHR, status, error) {
                        alert(jqXHR.responseText);
                    }});
        });

    $('#order').on('submit',
        'form.add_form',
        null,
        function (e) {
            e.preventDefault();
            var edit_div = $(this).parent().parent();
            var that = $(this).parent();

            $.ajax(url_base + "/order.php",
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function(order_json, status, jqXHR) {
                        var t = new Order(order_json);
                        that.replaceWith(t.makeCompactOrderTable());
                    },
                    error: function(jqXHR, status, error) {
                        alert(jqXHR.responseText);
                    }});
        });

    $('#order').on('click',
        'form.edit_form > button.cancel',
        null,
        function (e) {
            var edit_div = $(this).parent().parent();
            var t = edit_div.data('order');
            edit_div.replaceWith(t.makeCompactOrderTable());
        });

    $('#order').on('click',
        'td > button.delete',
        null,
        function (e) {
            var order_id = $(this).attr('item_id');

            var that = $(this).parent().parent();


             $.ajax(url_base + "/order.php/" + order_id + "?delete", {
                 type: 'GET',
                 success: function(){
                     that.remove();
                 },
                 error: function(jqXHR, status, error) {
                         alert(jqXHR.responseText);
                 }
             })

        });

    $('#order').on('click',
        'form.add_form > button.cancel',
        null,
        function (e) {
            $(this).parent().parent().remove();
        });

        $('#order_add').click(function(){
            Order.prototype.makeAddDiv().insertAfter($('#order tr:first-child'));
        })

    $('#order').on('click',
        'tr',
        null,
        function (e) {
            var order = $(this).data('order');
            $('#tb_order_item tr.tr_order_item').remove();

            $.ajax(url_base + "/order_item.php/" + order.order_id, {
                type: "GET",
                dataType: "json",
                success: function(items) {

                    for (var i=0; i<items.length; i++) {
                        load_orderItem_item(items[i]);
                    }
                }
            })
        });

    $('#order_add').click(function(){
        Order.prototype.makeAddDiv().insertAfter($('#order tr:first-child'));
    })

    /*------------- Order Item ----------------*/	

    $.ajax(url_base + "/order_item.php",
	       {type: "GET",
		       dataType: "json",
		       success: function(order_ids, status, jqXHR) {
		       for (var i=0; i<order_ids.length; i++) {
			   load_orderItem_item(order_ids[i]);
		       }
		     }
	       });

/*---------------------Order Item---------------------------*/

    $('#order').on('dblclick',
                   'tr.order',
                   null,
                   function (e) {
		           e.preventDefault ();
				   $.ajax(url_base + "/order_item.php" + order_id,
		              {type: "GET",
					   dataType: "json",
                       data: $(this).serialize(),
                       success: function(order_item_json, status, jqXHR) {
                          var t = new order(order_json);
                          $('#order').append(t.makeCompactInventoryTable());
                       },
                        error: function(jqXHR, status, error) {
                           alert(jqXHR.responseText);
				   }});
        });


	
    /*------------- login ----------------*/
    $('form.login_form').submit(
        function (e) {
            e.preventDefault();

            $.ajax(url_base + "/login.php",
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: function() {
                        window.location = "inventory.html"
                    },
                    error: function(jqXHR, status, error) {
                        alert(jqXHR.responseText);
                    }});
        }
    );

    /*------------ other -----------*/
    $('#order').css('display', 'none')
	$('#order_item').css('display', 'none')

    $('#a_inventory').click(function(){
        $('#inventory').css('display', 'block')
        $('#order').css('display', 'none')
		$('#order_item').css('display', 'none')
    })

    $('#a_order').click(function(){
        $('#inventory').css('display', 'none')
        $('#order').css('display', 'block')
		$('#order_item').css('display', 'block')
    })

});



var load_inventory_item = function (item_id) {
    $.ajax(url_base + "/inventory.php/" + item_id,
    {type: "GET",
     dataType: "json",
     success: function(inventory_json, status, jqXHR) {
        var t = new Inventory(inventory_json);
        $('#inventory').append(t.makeCompactInventoryTable());
        }
    });
}

var load_order_item = function (order_id) {
    $.ajax(url_base + "/order.php/" + order_id,
        {type: "GET",
            dataType: "json",
            success: function(order_json, status, jqXHR) {
                var t = new Order(order_json);
                $('#order').append(t.makeCompactOrderTable());
            }
        });
}


var load_orderItem_item = function (order_item) {
    console.log(order_item)
    var tr = $('<tr class="tr_order_item"></tr>');
    var td_item_id = $('<td>'+order_item.item_id+'</td>')
    var td_quantity = $('<td>'+order_item.quantity+'</td>')

    tr.append(tr).append(td_item_id).append(td_quantity)

    $('#tb_order_item').append(tr);

}




