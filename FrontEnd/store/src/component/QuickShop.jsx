import React from "react";
import quickcart from "../assets/Quickcart.png";

class QuickShop extends React.Component {
  handleQuickShop = async () => {
    const { product, addToCart , toggleCart} = this.props;

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

     
        const formattedAttributes = attributes.reduce((acc, attr) => {
          const formattedItems = attr.items.map((item, index) => ({
            display_value: item.display_value,
            valuex: item.valuex,
            selected: index === 0, 
          }));

          acc[attr.name] = formattedItems;
          return acc;
        }, {});

       
        const cartItem = {
          product_id: product.id,
          product_name: product.name,
          price: product.price,
          image: product.img_url[0],
          attributes: formattedAttributes, 
          quantity: 1,
        };

        toggleCart();
        addToCart(cartItem);

        
        
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
