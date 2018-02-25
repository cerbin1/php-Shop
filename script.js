function loadTypesOfProducts() {
    $.get('product_types.php', {action: 'get'})
        .then(function (response) {
            var types = JSON.parse(response).types;

            var product_type = $('#product-type');

            product_type.empty();
            for (var index in types) {
                product_type
                    .append($('<option>', {
                        value: types[index].name,
                        text: types[index].name
                    }));
            }
        })
        .catch(function () {
            alert("Failed loading types of products");
        })
}

$('#add-type').click(function () {
    var type = $("#type-name").val();
    var typePattern = /^[a-ząęóśłńćżź]{3,25}$/i;
    if (typePattern.test(type)) {
        $.post('product_types.php', {
            action: 'add',
            type: type
        })
            .then(function () {
                $('#div-show-types').removeClass('has-error');
                loadTypesOfProducts();
                showTypes();
            })
            .catch(function () {
                alert('Error adding new type');
            })
    }
    else {
        $('#div-show-types').addClass('has-error');
    }
});

function isValidClientName() {
    var namePattern = /^[a-ząęóśłńćżź]{3,20}$/i;
    var name = $("#client-name").val();
    return namePattern.test(name);
}

function isValidClientAge() {
    var agePattern = /^[0-9]{1,3}$/;
    var age = $("#client-age").val();
    return agePattern.test(age) && 5 < age && age < 210;
}

function isValidClientPurchasePrice() {
    var purchasePricePattern = /^[0-9]+(.[0-9]{2})?$/;
    var purchase_price = $("#client-purchase-price").val();
    return purchasePricePattern.test(purchase_price)
        && 0 < purchase_price && purchase_price < 10000;
}

$("#add-client").click(function () {
    var name = $("#client-name").val();
    var age = $("#client-age").val();
    var purchase_price = $("#client-purchase-price").val();

    var nameLabel = $("#client-name-label");
    var ageLabel = $("#client-age-label");
    var purchasePriceLabel = $("#client-purchase-price-label");

    changeStatusOf(nameLabel, isValidClientName());
    changeStatusOf(ageLabel, isValidClientAge());
    changeStatusOf(purchasePriceLabel, isValidClientPurchasePrice());

    if (isValidForm())
        $.post('client.php', {
            action: 'client',
            name: name,
            age: age,
            purchase_price: purchase_price
        })
            .then(function () {
                $('#add-client-modal').modal('hide');

                nameLabel.prop('class', '');
                ageLabel.prop('class', '');
                purchasePriceLabel.prop('class', '');
                $("#client-name").val('');
                $("#client-age").val('');
                $("#client-purchase-price").val('');
                showClients();
            })
            .catch(function (response) {
                var error = JSON.parse(response.responseText);

                alert('Error: ' + error.client);
            });

    function isValidForm() {
        return isValidClientName() && isValidClientAge() && isValidClientPurchasePrice();
    }
});

function isValidProductName() {
    var namePattern = /^[a-ząęóśłńćżź]{3,20}$/i;
    var name = $("#product-name").val();
    return namePattern.test(name);
}

function isValidProductType() {
    var typePattern = /^[a-ząęóśłńćżź]{3,25}$/i;
    var type = $("#product-type").val();
    return typePattern.test(type);
}

function isValidProductPrice() {
    var pricePattern = /^[0-9]+(.[0-9]{2})?$/;
    var price = $("#product-price").val();
    return pricePattern.test(price) && 0 < price && price < 10000;
}

function changeStatusOf(label, valid) {
    label.prop('class', (valid ? 'has-success' : 'has-error'));
}

$("#add-product").click(function () {
    var name = $("#product-name").val();
    var type = $("#product-type").val();
    var price = $("#product-price").val();

    var nameLabel = $("#products-name-label");
    var typeLabel = $("#products-type-label");
    var priceLabel = $("#products-price-label");

    changeStatusOf(nameLabel, isValidProductName());
    changeStatusOf(typeLabel, isValidProductType());
    changeStatusOf(priceLabel, isValidProductPrice());

    if (isValidForm()) {
        $.post('product.php', {
            action: 'product',
            name: name,
            type: type,
            price: price
        })
            .then(function () {
                $('#add-product-modal').modal('hide');

                nameLabel.prop('class', '');
                typeLabel.prop('class', '');
                priceLabel.prop('class', '');
                $("#product-name").val('');
                $("#product-type").val('');
                $("#product-price").val('');
                showProducts();
            })
            .catch(function () {
                alert('Error');
            })
    }

    function isValidForm() {
        return isValidProductName() && isValidProductType() && isValidProductPrice();
    }
});

$("#show-clients").click(function () {
    showClients();
});

function showTypes() {
    $.get('product_types.php', {
        action: 'get'
    })
        .then(function (response) {
            var types = JSON.parse(response).types;
            console.log(types);

            var productTypes = $('#div-show-types');

            productTypes.empty()
                .append($('<table>')
                    .prop('id', 'show-types-table')
                    .addClass('table table-striped table-hover')
                    .append($('<tbody>')
                        .append($('<tr>')
                            .append($('<td>').text('Name'))
                            .append($('<td>').text('Delete'))
                        )));
            for (var index in types) {
                $('#show-types-table')
                    .append($('<tr>')
                        .append($('<td>')
                            .text(types[index].name))
                        .append($('<td>')
                            .append($('<a>')
                                .addClass('delete-type')
                                .prop('id', types[index].productID)
                                .append($('<img>')
                                    .prop('src', 'images/delete.png')))
                        ));

            }
            $('#change-types-button').text('Add new type');
            $('#add-type').prop('disabled', 'disabled');
        })
        .catch(function () {
            alert('Error');
        })
}

$(document).on('click', 'a.delete-type', function () {
    console.log(this);
    var idType = $(this).prop('id');
    $.post('delete_type.php', {
        action: 'delete',
        id: idType
    })
        .then(function () {
            showTypes();
        })
        .catch(function () {
            alert("Delete type failed!");
        })

});

$('#change-types-button').on('click', function () {
    var valueOfButton = $('#change-types-button');
    if (valueOfButton.text() === 'Show types') {
        showTypes();
    }
    if (valueOfButton.text() === 'Add new type') {
        addNewType();
    }
});

function addNewType() {
    var productTypes = $('#div-show-types');
    productTypes.empty()
        .append($('<label>')
            .text('Name'))
        .append($('<input>')
            .prop('id', 'type-name')
            .addClass('form-control')
        );
    $('#change-types-button').text('Show types');
    $('#add-type').removeAttr('disabled');
}

$('#add-new-type').on('click', function () {
    addNewType();
});

function showClients() {
    $.get('client.php', {
        action: 'clients'
    })
        .then(function (response) {
            $("#display-records-div")
                .empty()
                .append($('<button>')
                    .prop('type', 'button')
                    .addClass('btn btn-primary')
                    .attr('data-toggle', 'modal')
                    .attr('data-target', '#add-client-modal')
                    .text('Add client'))
                .append($('<table>')
                    .prop('id', 'clients-table')
                    .addClass('table')
                    .addClass('table-hover')
                    .append($('<tbody>')
                        .append(($('<tr>')
                                .append($('<td>').text('ID'))
                                .append($('<td>').text('Name'))
                                .append($('<td>').text('Age'))
                                .append($('<td>').text('Purchase price'))
                        ))
                    )
                );

            var clients = JSON.parse(response).clients;

            for (var index in clients) {
                $("#clients-table").append(
                    $('<tr>')
                        .append($('<td>').text(clients[index].clientID))
                        .append($('<td>').text(clients[index].name))
                        .append($('<td>').text(clients[index].age))
                        .append($('<td>').text(clients[index].purchase_price))
                );
            }
        })
        .catch(function () {
            alert('Error');
        })
}

function showProducts() {
    $.get('product.php', {
        action: 'products'
    })
        .then(function (response) {
            loadTypesOfProducts();

            $("#display-records-div")
                .empty()
                .append($('<button>')
                    .addClass('btn btn-primary')
                    .prop('type', 'button')
                    .attr('data-toggle', 'modal')
                    .attr('data-target', '#add-product-modal')
                    .text('Add product'))
                .append($('<button>')
                    .prop('id', 'product-type-change')
                    .addClass('btn')
                    .prop('type', 'button')
                    .text('Change types of products')
                    .attr('data-toggle', 'modal')
                    .attr('data-target', '#change-types'))
                .append($('<table>')
                    .prop('id', 'products-table')
                    .addClass('table')
                    .addClass('table-hover')
                    .append($('<tbody>')
                        .append(($('<tr>')
                                .append($('<td>').text('ID'))
                                .append($('<td>').text('Name'))
                                .append($('<td>').text('Type'))
                                .append($('<td>').text('Price'))
                        ))
                    )
                );

            var products = JSON.parse(response).products;

            for (var index in products) {
                $('#products-table').append(
                    $('<tr>')
                        .append($('<td>').text(products[index].productID))
                        .append($('<td>').text(products[index].name))
                        .append($('<td>').text(products[index].type))
                        .append($('<td>').text(products[index].price))
                );
            }
        })
        .catch(function () {
            alert('Error');
        })
}

$("#show-products").click(function () {
    showProducts();
});

$("#client-name").on('focusout', function () {
    changeStatusOf($("#client-name-label"), isValidClientName());
});

$("#client-age").on('focusout', function () {
    changeStatusOf($("#client-age-label"), isValidClientName());
});

$("#client-purchase-price").on('focusout', function () {
    changeStatusOf($("#client-purchase-price-label"), isValidClientPurchasePrice());
});

$("#product-name").on('focusout', function () {
    changeStatusOf($("#products-name-label"), isValidProductName());
});

$("#product-type").on('focusout', function () {
    changeStatusOf($("#products-type-label"), isValidProductType());
});

$("#product-price").on('focusout', function () {
    changeStatusOf($("#products-price-label"), isValidProductPrice());
});
