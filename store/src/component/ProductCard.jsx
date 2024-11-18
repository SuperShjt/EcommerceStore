import React from "react";
import { Link } from "react-router-dom";

class ProductCard extends React.Component {
  render() {
    const {id, name, price, img_url } = this.props.product; // destructure the props to get the necessary fields

    return (
      <div className="product-card">
        <Link to={`/product/${id}`}>
        <img src={img_url[0]} alt={name} /> {/* Assuming img_url is an array, displaying the first image */}
        <h3>{name}</h3>
        <p>${price.toFixed(2)}</p> {/* Formatting the price to show two decimal places */}
        </Link>
      </div>
    );
  }
}

export default ProductCard;
