import React, { Component } from "react";

class QuickShop extends Component {
  handleQuickShop = () => {
    const { product, addToCart } = this.props;

    // Auto-select the first option for each attribute
    const selectedAttributes = {};
    product.attributes.forEach((attr) => {
      if (attr.items && attr.items.length > 0) {
        selectedAttributes[attr.name] = attr.items[0].valuex;
      }
    });

    const cartItem = {
      product_id: product.id,
      price: product.price,
      image: product.img_url[0],
      attributes: selectedAttributes,
    };

    addToCart(cartItem); // Add product with selected attributes to the cart
    alert(`${product.name} added to the cart with default attributes!`);
  };

  render() {
    return (
      <button onClick={this.handleQuickShop} className="quick-shop-btn">
        QuickShop
      </button>
    );
  }
}

export default QuickShop;
