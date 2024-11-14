import React from "react";

class ProductCard extends React.Component {
  render() {
    const { name, price, img_url } = this.props.product; // destructure the props to get the necessary fields

    return (
      <div className="product-card">
        <img src={img_url[0]} alt={name} /> {/* Assuming img_url is an array, displaying the first image */}
        <h3>{name}</h3>
        <p>${price.toFixed(2)}</p> {/* Formatting the price to show two decimal places */}
      </div>
    );
  }
}

export default ProductCard;
