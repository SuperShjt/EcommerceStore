import React from "react";
import quickcart from "../assets/Quickcart.png"

class QuickShop extends React.Component {
  handleQuickShop = async () => {
    const { product, addToCart } = this.props;

    const query = `
      {
        fullproduct(id: "${product.id}") {
          attributes {
            name
            items {
              display_value
              valuex
            }
          }
        }
      }
    `;

    try {
      const response = await fetch("http://localhost/Scandiweb/Backend/Controller/test.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ query }),
      });

      const result = await response.json();
      if (result.data && result.data.fullproduct) {
        const attributes = result.data.fullproduct.attributes;

        const selectedAttributes = attributes.reduce((acc, attr) => {
          acc[attr.name] = attr.items[0].valuex;
          return acc;
        }, {});

        const cartItem = {
          product_id: product.id,
          name: product.name,
          price: product.price,
          image: product.img_url[0],
          attributes: selectedAttributes,
          quantity: 1,
        };

        addToCart(cartItem);
        alert(`Added ${product.name} to the cart with attributes: ${JSON.stringify(selectedAttributes)}`);
      }
    } catch (error) {
      console.error("Failed to fetch product attributes:", error);
    }
  };

  render() {
    return (
      <button className="quick-shop-btn" onClick={this.handleQuickShop}>
        <img src={quickcart} alt="Quick Shop" />
      </button>
    );
  }
}

export default QuickShop;
