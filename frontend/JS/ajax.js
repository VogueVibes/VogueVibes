function removeFromCart(cardId) {
    $.ajax({
        type: "POST",
        url: "../../backend/delete_cart.php",
        data: { cardId: cardId },
        dataType: "json",
        success: function (data) {
            if (data.statusCode === 200) {
                // Successfully removed the item from the server
                $(".card-container[data-item-id='" + cardId + "']").remove(); // Remove the card from DOM
                updateTotalPrice(); // Update the total price, including the removed item

            } else if (data.statusCode === 500) {
                // Error while removing the item
                alert(data.message);
            }
        },
        error: function () {
            // Error in the AJAX request
            alert("Failed to delete the card.");
        }
    });
}

function updateTotalPrice() {
    $.ajax({
        type: "GET",
        url: "../../backend/get_cart_total.php",
        dataType: "json",
        success: function (data) {
            if (data.quantity === 0) {
                // Cart is empty, remove all item information from total sum block
                $(".total-item").remove();
                $(".ende-item").text("Total: $0");
            } else {
                // Update the total price on the page
                $(".ende-item").text("Total: $" + data.total);
                // Clear existing item information
                $(".total-item").remove();
                // Add updated item information
                for (var i = 0; i < data.items.length; i++) {
                    $(".infoGood").append('<div class="total-item">' + data.items[i].name + ' x' + data.items[i].quantity + '</div>');
                }
            }
        },
        error: function () {
            // Error in the AJAX request
            console.error("Failed to fetch the updated total.");
        }
    });
}



    function decrementQuantity(cardId, quantity) {
        var inputElement = $("input[name='quantity[" + cardId + "]']");
        var currentQuantity = parseInt(inputElement.val());
        if (currentQuantity > 1) {
            $.ajax({
                type: "POST",
                url: "../../backend/decrement.php",
                data: { cardId: cardId, quantity: quantity },
                dataType: "json",
                success: function (data) {
                    if (data.statusCode === 200) {
                        // Successfully updated the quantity on the server-side
                        // Now, update the quantity on the page
                        var updatedQuantity = currentQuantity - 1;
                        inputElement.val(updatedQuantity);
    
                        // Optionally, you can also update the total price if needed
                        updateTotalPrice();
                    } else if (data.statusCode === 500) {
                        // Error updating the quantity on the server-side
                        alert(data.message);
                    }
                },
                error: function () {
                    // Error in the AJAX request
                    alert("Failed to update the quantity.");
                }
            });
        }else{
            removeFromCart(cardId);
        }
    }
    

    function incrementQuantity(cardId, quantity) {
        var inputElement = $("input[name='quantity[" + cardId + "]']");
        var currentQuantity = parseInt(inputElement.val());
    
        // Check if the current quantity is less than 10
        if (currentQuantity < 9) {
            // Proceed to increment the quantity
            $.ajax({
                type: "POST",
                url: "../../backend/increment.php",
                data: { cardId: cardId, quantity: quantity },
                dataType: "json",
                success: function (data) {
                    if (data.statusCode === 200) {
                        // Successfully updated the quantity on the server-side
                        // Now, update the quantity on the page
                        var updatedQuantity = currentQuantity + 1;
                        inputElement.val(updatedQuantity);
    
                        // Optionally, you can also update the total price if needed
                        updateTotalPrice();
                    } else if (data.statusCode === 500) {
                        // Error updating the quantity on the server-side
                        alert(data.message);
                    }
                },
                error: function () {
                    // Error in the AJAX request
                    alert("Failed to update the quantity.");
                }
            });
        }
    }
    
        // Call the function to start updating the total price periodically
        $(document).ready(function () {
            // Update the total price initially
            updateTotalPrice();
        
            // Update the total price every 5 seconds (adjust the interval as needed)
            setInterval(function () {
                updateTotalPrice();
            }, 5000); // Update every 5 seconds
        });
        
