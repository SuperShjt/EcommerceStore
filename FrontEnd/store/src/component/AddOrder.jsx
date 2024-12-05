import React, { Component } from "react";

class AddOrder extends Component {
  handleOrder = async () => {
    const { cartItems, clearCart } = this.props;

    const promises = cartItems.map(async (item) => {
      const mutation = `
        mutation {
          createOrder(
            product_id: "${item.product_id}",
            price: ${item.price},
            attributes: """${JSON.stringify(item.attributes)}"""
          ) 
        }
      `;

      try {
        const response = await fetch("http://localhost/Scandiweb/Backend/Controller/test.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ query: mutation }),
        });
        const result = await response.json();

        if (result.errors) {
          console.error(`Error for product ${item.product_id}:`, result.errors[0].message);
        } else {
          console.log(`Order placed successfully for product ${item.product_id}`);
        }
      } catch (error) {
        console.error(`Failed to place order for product ${item.product_id}:`, error);
      }
    });

   
    await Promise.all(promises);

    
    

    alert("Order placement completed, and cart is cleared!");
    clearCart();
  };

  render() {
    const { cartItems } = this.props;
    return (
      <>
        {cartItems.length === 0 ? (
          <button disabled id="place-order-btn">
            Place Order
          </button>
        ) : (
          <button onClick={this.handleOrder} id="place-order-btn">
            Place Order
          </button>
        )}
      </>
    );
  }
}

export default AddOrder;
