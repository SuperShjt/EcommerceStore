import React from "react";

class QuickShop extends React.Component {
  handleQuickShop = async () => {
    const { product, addToCart } = this.props;

    // GraphQL query to fetch attributes
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
      const response = await fetch("http://localhost/Scandiweb/Controller/test.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ query }),
      });

      const result = await response.json();
      if (result.data && result.data.fullproduct) {
        const attributes = result.data.fullproduct.attributes;

        // Auto-select the first option of each attribute
        const selectedAttributes = attributes.reduce((acc, attr) => {
          acc[attr.name] = attr.items[0].valuex; // Automatically select the first item's valuex
          return acc;
        }, {});

        // Prepare the cart item
        const cartItem = {
          product_id: product.id,
          name: product.name,
          price: product.price,
          image: product.img_url[0],
          attributes: selectedAttributes, // Align with the 2nd snippet
        };

        addToCart(cartItem); // Add the item to the cart
        alert(`Added ${product.name} to the cart with attributes: ${JSON.stringify(selectedAttributes)}`);
      }
    } catch (error) {
      console.error("Failed to fetch product attributes:", error);
    }
  };

  render() {
    return (
      <button className="quick-shop-btn" onClick={this.handleQuickShop}>
        Quick Shop
      </button>
    );
  }
}

export default QuickShop;
